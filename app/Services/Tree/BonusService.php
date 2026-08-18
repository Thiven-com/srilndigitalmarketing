<?php

namespace App\Services\Tree;

use App\Models\Customer;
use App\Models\PackageLevel;
use App\Models\Reward;
use App\Models\CustomerPackage;
use App\Models\ThreeWayReferral;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BonusService
{
    /**
     * Distribute package level bonus.
     *
     * Level 1 = Customer Sponsor
     * Level 2 = Sponsor's Sponsor
     * Level 3 = Next Upline
     * ...
     * Level 6 = Sixth Upline
     *
     * Customer himself will NEVER receive package level bonus.
     */
    public function distributePackageBonus(
        Customer $customer,
        int $packageId,
        float $packageAmount,
        string $sourceType = 'package_purchase',
        ?int $sourceId = null
    ): void {

        DB::transaction(function () use ($customer, $packageId, $packageAmount, $sourceType, $sourceId) {

            /*
            |--------------------------------------------------------------------------
            | PACKAGE LEVEL CONFIGURATION
            |--------------------------------------------------------------------------
            */

            $levels = PackageLevel::where(
                'package_id',
                $packageId
            )
                ->where('status', 1)
                ->whereBetween('level', [1, 6])
                ->orderBy('level')
                ->get();


            if ($levels->isEmpty()) {

                Log::info('No package levels found.', [
                    'package_id' => $packageId,
                    'customer_id' => $customer->id,
                ]);

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | FIND PURCHASING USER IN SAME PACKAGE TREE
            |--------------------------------------------------------------------------
            */

            $currentNode = ThreeWayReferral::where(
                'package_id',
                $packageId
            )
                ->where(
                    'userId',
                    $customer->userid
                )
                ->first();


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER MUST EXIST IN THIS PACKAGE TREE
            |--------------------------------------------------------------------------
            */

            if (!$currentNode) {

                Log::warning(
                    'Customer not found in package tree. Bonus skipped.',
                    [
                        'customer_id' => $customer->id,
                        'userid' => $customer->userid,
                        'package_id' => $packageId,
                    ]
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | LEVEL-WISE REWARD
            |--------------------------------------------------------------------------
            */

            foreach ($levels as $level) {

                /*
                |--------------------------------------------------------------------------
                | GET PARENT USING placedunder_id
                |--------------------------------------------------------------------------
                |
                | DO NOT USE:
                |
                | customer.sponsor_id
                | tree.sponser_id
                |
                */

                if (empty($currentNode->placedunder_id)) {

                    Log::info(
                        'No placement upline available.',
                        [
                            'package_id' => $packageId,
                            'userid' => $currentNode->userId,
                            'level' => $level->level,
                        ]
                    );

                    break;
                }


                /*
                |--------------------------------------------------------------------------
                | FIND PARENT IN SAME PACKAGE
                |--------------------------------------------------------------------------
                */

                $parentNode = ThreeWayReferral::where(
                    'package_id',
                    $packageId
                )
                    ->where(
                        'userId',
                        $currentNode->placedunder_id
                    )
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | NO PARENT
                |--------------------------------------------------------------------------
                */

                if (!$parentNode) {

                    Log::warning(
                        'Placement parent not found.',
                        [
                            'package_id' =>
                                $packageId,

                            'current_userid' =>
                                $currentNode->userId,

                            'placedunder_id' =>
                                $currentNode->placedunder_id,

                            'level' =>
                                $level->level,
                        ]
                    );

                    break;
                }


                /*
                |--------------------------------------------------------------------------
                | FIND CUSTOMER
                |--------------------------------------------------------------------------
                */

                $receiver = Customer::where(
                    'userid',
                    $parentNode->userId
                )->first();


                if (!$receiver) {

                    Log::warning(
                        'Placement parent customer not found.',
                        [
                            'package_id' =>
                                $packageId,

                            'userid' =>
                                $parentNode->userId,

                            'level' =>
                                $level->level,
                        ]
                    );

                    break;
                }


                /*
                |--------------------------------------------------------------------------
                | PREVENT SELF REWARD
                |--------------------------------------------------------------------------
                */

                if (
                    (int) $receiver->id ===
                    (int) $customer->id
                ) {

                    Log::warning(
                        'Self reward prevented.',
                        [
                            'customer_id' =>
                                $customer->id,

                            'package_id' =>
                                $packageId,

                            'level' =>
                                $level->level,
                        ]
                    );

                    /*
                    | Even if self is encountered,
                    | continue upward through placement tree.
                    */

                    $currentNode = $parentNode;

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | CALCULATE REWARD
                |--------------------------------------------------------------------------
                */

                $amount = $this->calculateAmount(
                    $level,
                    $packageAmount
                );


                if ($amount > 0) {

                    /*
                    |--------------------------------------------------------------------------
                    | CREDIT REWARD
                    |--------------------------------------------------------------------------
                    */

                    $this->creditReward(
                        customer: $receiver,
                        amount: $amount,
                        level: $level,
                        packageCustomer: $customer,
                        sourceType: $sourceType,
                        sourceId: $sourceId,
                        packageId: $packageId
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | IMPORTANT
                |--------------------------------------------------------------------------
                |
                | NEXT LEVEL STARTS FROM THIS PARENT.
                |
                */

                $currentNode = $parentNode;
            }
        });
    }


    /**
     * Calculate package level bonus.
     */
    protected function calculateAmount(
        PackageLevel $level,
        float $packageAmount
    ): float {

        /*
        |--------------------------------------------------------------------------
        | Fixed
        |--------------------------------------------------------------------------
        */

        if ($level->calculation_type === 'fixed') {

            return (float) $level->amount;
        }


        /*
        |--------------------------------------------------------------------------
        | Percentage
        |--------------------------------------------------------------------------
        */

        if ($level->calculation_type === 'percentage') {

            return round(
                (
                    $packageAmount *
                    (float) $level->percentage
                ) / 100,
                2
            );
        }


        return 0;
    }


    /**
     * Get next sponsor.
     */
    protected function getNextSponsor(
        Customer $customer
    ): ?Customer {

        if (empty($customer->sponsor_id)) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent infinite loop
        |--------------------------------------------------------------------------
        */

        if (
            (string) $customer->sponsor_id ===
            (string) $customer->userid
        ) {
            return null;
        }


        return Customer::where(
            'userid',
            $customer->sponsor_id
        )->first();
    }


    /**
     * Credit reward.
     */
    protected function creditReward(
        Customer $customer,
        float $amount,
        PackageLevel $level,
        Customer $packageCustomer,
        string $sourceType,
        ?int $sourceId = null,
        ?int $packageId = null
    ): void {

        if ($amount <= 0) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent self reward
        |--------------------------------------------------------------------------
        */

        if (
            (int) $customer->id ===
            (int) $packageCustomer->id
        ) {

            Log::warning(
                'Self reward blocked.',
                [
                    'customer_id' =>
                        $customer->id,

                    'package_customer_id' =>
                        $packageCustomer->id,

                    'level' =>
                        $level->level,
                ]
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Opening Balance
        |--------------------------------------------------------------------------
        */

        $openingBalance =
            (float) ($customer->rewards ?? 0);


        /*
        |--------------------------------------------------------------------------
        | Closing Balance
        |--------------------------------------------------------------------------
        */

        $closingBalance =
            $openingBalance + $amount;


        /*
        |--------------------------------------------------------------------------
        | Update Customer Rewards
        |--------------------------------------------------------------------------
        */

        $customer->rewards =
            $closingBalance;

        $customer->save();


        /*
        |--------------------------------------------------------------------------
        | Reward History
        |--------------------------------------------------------------------------
        */

        Reward::create([

            'user_id' =>
                $customer->id,

            'package_id' =>
                $packageId,


            'role' =>
                'customer',

            'activity_id' =>
                $level->id,

            'source_type' =>
                $sourceType,

            'source_id' =>
                $sourceId,

            'reward_type' =>
                'package_bonus',

            'transaction_type' =>
                'credit',

            'amount' =>
                $amount,

            'opening_balance' =>
                $openingBalance,

            'closing_balance' =>
                $closingBalance,

            'description' =>
                'Level ' .
                $level->level .
                ' package bonus received from ' .
                (
                    $packageCustomer->name ??
                    $packageCustomer->userid
                ),

            'status' =>
                'completed',

            'is_reverted' =>
                0,

            'meta_data' =>
                json_encode([

                    'package_id' =>
                        $level->package_id,

                    'package_level_id' =>
                        $level->id,

                    'level' =>
                        $level->level,

                    'package_customer_id' =>
                        $packageCustomer->id,

                    'package_customer_userid' =>
                        $packageCustomer->userid,

                    'amount' =>
                        $amount,
                ]),
        ]);


        Log::info(
            'Package level bonus credited.',
            [
                'receiver_id' =>
                    $customer->id,

                'receiver_userid' =>
                    $customer->userid,

                'from_customer_id' =>
                    $packageCustomer->id,

                'from_customer_userid' =>
                    $packageCustomer->userid,

                'level' =>
                    $level->level,

                'amount' =>
                    $amount,
            ]
        );
    }


    /**
     * Compatibility method.
     */
    public function distribute(
        CustomerPackage $customerPackage,
        string $treeModel
    ): void {

        $customer =
            Customer::find(
                $customerPackage->customer_id
            );


        if (!$customer) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Package Amount
        |--------------------------------------------------------------------------
        */

        $packageAmount =
            (float) (
                $customerPackage->amount
                ?? $customerPackage->package_amount
                ?? $customerPackage->total_amount
                ?? 0
            );


        /*
        |--------------------------------------------------------------------------
        | Package ID
        |--------------------------------------------------------------------------
        */

        $packageId =
            (int) $customerPackage->package_id;


        if (!$packageId) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Distribute
        |--------------------------------------------------------------------------
        */

        $this->distributePackageBonus(
            customer: $customer,
            packageId: $packageId,
            packageAmount: $packageAmount,
            sourceType: 'package_purchase',
            sourceId: $customerPackage->id
        );
    }
}