<?php

namespace App\Services\Tree;

use App\Models\Customer;
use App\Models\PackageComponent;
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

            $components = PackageComponent::where(
                'package_id',
                $packageId
            )
                ->where('status', 1)
                ->whereNotNull('level')
                ->whereBetween('level', [1, 6])
                ->orderBy('level')
                ->get();

            if ($components->isEmpty()) {
                Log::info('No package level bonus configuration found.', [
                    'package_id' => $packageId,
                    'customer_id' => $customer->id,
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            | Level 1 starts from SPONSOR.
            |
            | Never start with:
            |
            | $customer
            |
            | because customer must not get self bonus.
            |--------------------------------------------------------------------------
            */

            if (empty($customer->sponsor_id)) {

                Log::info('No sponsor found. No level bonus distributed.', [
                    'customer_id' => $customer->id,
                    'userid' => $customer->userid,
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Get Level 1 Upline
            |--------------------------------------------------------------------------
            */

            $upline = Customer::where(
                'userid',
                $customer->sponsor_id
            )->first();

            if (!$upline) {

                Log::warning('Sponsor not found for package bonus.', [
                    'customer_id' => $customer->id,
                    'sponsor_id' => $customer->sponsor_id,
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Distribute Level 1 - Level 6
            |--------------------------------------------------------------------------
            */

            foreach ($components as $component) {

                if (!$upline) {
                    break;
                }

                /*
                |--------------------------------------------------------------------------
                | Safety: Never reward purchasing customer
                |--------------------------------------------------------------------------
                */

                if ((int) $upline->id === (int) $customer->id) {

                    Log::warning(
                        'Self bonus prevented.',
                        [
                            'customer_id' => $customer->id,
                            'userid' => $customer->userid,
                            'level' => $component->level,
                        ]
                    );

                    $upline = $this->getNextSponsor($upline);

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Calculate bonus
                |--------------------------------------------------------------------------
                */

                $amount = $this->calculateAmount(
                    $component,
                    $packageAmount
                );

                if ($amount <= 0) {

                    $upline = $this->getNextSponsor($upline);

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Credit reward
                |--------------------------------------------------------------------------
                */

                $this->creditReward(
                    customer: $upline,
                    amount: $amount,
                    component: $component,
                    packageCustomer: $customer,
                    sourceType: $sourceType,
                    sourceId: $sourceId
                );

                /*
                |--------------------------------------------------------------------------
                | Move to next upline
                |--------------------------------------------------------------------------
                */

                $upline = $this->getNextSponsor($upline);
            }

            /*
|--------------------------------------------------------------------------
| Direct Bonus
|--------------------------------------------------------------------------
| Direct bonus goes ONLY to the immediate sponsor.
| Customer himself will never receive it.
*/

            $directComponent = PackageComponent::where('package_id', $packageId)
                ->where('component_type', 'direct')
                ->where('code', 'DIRECT')
                ->where('status', 1)
                ->first();

            if ($directComponent && !empty($customer->sponsor_id)) {

                $directSponsor = Customer::where(
                    'userid',
                    $customer->sponsor_id
                )->first();

                if (
                    $directSponsor &&
                    (int) $directSponsor->id !== (int) $customer->id
                ) {

                    $directAmount = $this->calculateAmount(
                        $directComponent,
                        $packageAmount
                    );

                    if ($directAmount > 0) {

                        $this->creditReward(
                            customer: $directSponsor,
                            amount: $directAmount,
                            component: $directComponent,
                            packageCustomer: $customer,
                            sourceType: $sourceType,
                            sourceId: $sourceId
                        );
                    }
                }
            }
        });
    }


    /**
     * Calculate bonus amount from package_components.
     */
    protected function calculateAmount(
        PackageComponent $component,
        float $packageAmount
    ): float {

        /*
        |--------------------------------------------------------------------------
        | Fixed amount
        |--------------------------------------------------------------------------
        */

        if ($component->calculation_type === 'fixed') {

            return (float) $component->amount;
        }

        /*
        |--------------------------------------------------------------------------
        | Percentage
        |--------------------------------------------------------------------------
        */

        if ($component->calculation_type === 'percentage') {

            return round(
                ($packageAmount * (float) $component->percentage) / 100,
                2
            );
        }

        return 0;
    }


    /**
     * Get next upline.
     *
     * Current sponsor
     *      ↓
     * sponsor's sponsor
     *      ↓
     * next sponsor
     */
    protected function getNextSponsor(
        Customer $customer
    ): ?Customer {

        if (empty($customer->sponsor_id)) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Never return the same customer
        |--------------------------------------------------------------------------
        */

        if ((string) $customer->sponsor_id === (string) $customer->userid) {
            return null;
        }

        return Customer::where(
            'userid',
            $customer->sponsor_id
        )->first();
    }


    /**
     * Credit reward.
     *
     * IMPORTANT:
     * No wallet update.
     *
     * Only customers.rewards is updated.
     *
     * Reward history is also stored in rewards table.
     */
    protected function creditReward(
        Customer $customer,
        float $amount,
        PackageComponent $component,
        Customer $packageCustomer,
        string $sourceType,
        ?int $sourceId = null
    ): void {

        if ($amount <= 0) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent self reward
        |--------------------------------------------------------------------------
        */

        if ((int) $customer->id === (int) $packageCustomer->id) {

            Log::warning(
                'Self reward blocked.',
                [
                    'customer_id' => $customer->id,
                    'package_customer_id' => $packageCustomer->id,
                    'level' => $component->level,
                ]
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Opening reward balance
        |--------------------------------------------------------------------------
        */

        $openingBalance = (float) $customer->rewards;

        /*
        |--------------------------------------------------------------------------
        | Closing reward balance
        |--------------------------------------------------------------------------
        */

        $closingBalance = $openingBalance + $amount;

        /*
        |--------------------------------------------------------------------------
        | Update ONLY rewards
        |--------------------------------------------------------------------------
        */

        $customer->rewards = $closingBalance;

        $customer->save();

        /*
        |--------------------------------------------------------------------------
        | Store Reward History
        |--------------------------------------------------------------------------
        */

        Reward::create([
            'user_id' => $customer->id,

            'role' => 'customer',

            'activity_id' => $component->id,

            'source_type' => $sourceType,

            'source_id' => $sourceId,

            'reward_type' => 'package_bonus',

            'transaction_type' => 'credit',

            'amount' => $amount,

            'opening_balance' => $openingBalance,

            'closing_balance' => $closingBalance,

            'description' =>
                'Level ' . $component->level .
                ' package bonus received from ' .
                ($packageCustomer->name ?? $packageCustomer->userid),

            'status' => 'completed',

            'is_reverted' => 0,

            'meta_data' => json_encode([
                'package_id' => $component->package_id,
                'package_component_id' => $component->id,
                'level' => $component->level,
                'package_customer_id' => $packageCustomer->id,
                'package_customer_userid' => $packageCustomer->userid,
                'amount' => $amount,
            ]),
        ]);

        Log::info('Package bonus credited.', [
            'receiver_id' => $customer->id,
            'receiver_userid' => $customer->userid,
            'from_customer_id' => $packageCustomer->id,
            'from_customer_userid' => $packageCustomer->userid,
            'level' => $component->level,
            'amount' => $amount,
        ]);
    }


    /**
     * Compatibility method.
     *
     * If your controller currently calls:
     *
     * $this->bonusService->distribute(
     *     $customerPackage,
     *     $treeModel
     * );
     *
     * this method will continue to work.
     */
    public function distribute(
        CustomerPackage $customerPackage,
        string $treeModel
    ): void {

        $customer = Customer::find(
            $customerPackage->customer_id
        );

        if (!$customer) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Get package amount
        |--------------------------------------------------------------------------
        */

        $packageAmount =
            (float) (
                $customerPackage->amount
                ?? $customerPackage->package_amount
                ?? 0
            );

        /*
        |--------------------------------------------------------------------------
        | Get package ID
        |--------------------------------------------------------------------------
        */

        $packageId =
            (int) $customerPackage->package_id;

        if (!$packageId) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Distribute bonus
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