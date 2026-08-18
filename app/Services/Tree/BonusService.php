<?php

namespace App\Services\Tree;

use App\Models\Customer;
use App\Models\PackageLevel;
use App\Models\Reward;
use App\Models\CustomerPackage;
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
            | Get package level bonus configuration
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

                Log::info(
                    'No package level bonus configuration found.',
                    [
                        'package_id' => $packageId,
                        'customer_id' => $customer->id,
                    ]
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Level 1 starts from SPONSOR
            |--------------------------------------------------------------------------
            */

            if (empty($customer->sponsor_id)) {

                Log::info(
                    'No sponsor found. No level bonus distributed.',
                    [
                        'customer_id' => $customer->id,
                        'userid' => $customer->userid,
                    ]
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Get Level 1 Sponsor
            |--------------------------------------------------------------------------
            */

            $upline = Customer::where(
                'userid',
                $customer->sponsor_id
            )->first();


            if (!$upline) {

                Log::warning(
                    'Sponsor not found for package bonus.',
                    [
                        'customer_id' => $customer->id,
                        'sponsor_id' => $customer->sponsor_id,
                    ]
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Level 1 - Level 6
            |--------------------------------------------------------------------------
            */

            foreach ($levels as $level) {

                if (!$upline) {
                    break;
                }


                /*
                |--------------------------------------------------------------------------
                | Never reward purchasing customer
                |--------------------------------------------------------------------------
                */

                if (
                    (int) $upline->id ===
                    (int) $customer->id
                ) {

                    Log::warning(
                        'Self bonus prevented.',
                        [
                            'customer_id' => $customer->id,
                            'userid' => $customer->userid,
                            'level' => $level->level,
                        ]
                    );

                    $upline =
                        $this->getNextSponsor($upline);

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Calculate level bonus
                |--------------------------------------------------------------------------
                */

                $amount =
                    $this->calculateAmount(
                        $level,
                        $packageAmount
                    );


                if ($amount <= 0) {

                    $upline =
                        $this->getNextSponsor($upline);

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Credit Reward
                |--------------------------------------------------------------------------
                */

                $this->creditReward(
                    customer: $upline,
                    amount: $amount,
                    level: $level,
                    packageCustomer: $customer,
                    sourceType: $sourceType,
                    sourceId: $sourceId,
                    packageId: $packageId
                );


                /*
                |--------------------------------------------------------------------------
                | Move to next sponsor
                |--------------------------------------------------------------------------
                */

                $upline =
                    $this->getNextSponsor($upline);
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