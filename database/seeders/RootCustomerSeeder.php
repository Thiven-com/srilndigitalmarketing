<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Package;
use App\Models\ThreeWayReferral;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RootCustomerSeeder extends Seeder
{
    /**
     * Create root customer and initialize the root
     * for every package's Three-Way referral tree.
     */
    public function run(): void
    {
        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | ROOT USER DETAILS
            |--------------------------------------------------------------------------
            */

            $userId = 'SLM00000001';

            $mobile = '9999999999';


            /*
            |--------------------------------------------------------------------------
            | CHECK / CREATE ROOT CUSTOMER
            |--------------------------------------------------------------------------
            */

            $customer = Customer::where(
                'userid',
                $userId
            )->first();


            if (!$customer) {

                $customer = Customer::create([

                    'userid' => $userId,

                    'name' => 'Root User',

                    'old_name' => null,

                    'email' => 'root@test.com',

                    'mobile' => $mobile,

                    'sponsor_id' => null,

                    'sponsor_name' => null,

                    'wallet' => 0,

                    'bonus' => 0,

                    'rewards' => 0,

                    'dob' => null,

                    'otp' => null,

                    'latitude' => null,

                    'longitude' => null,

                    'activation' => 'yes',

                    'placedunder_id' => null,

                    'position' => null,

                    'rootmap' => null,

                    'kyc_status' => 'pending',

                    'profile_pic' => null,

                    'mobile_verified' => 'yes',

                    'email_verified' => 'no',

                    'mobile_verified_at' => now(),

                    'email_verified_at' => null,

                    'firebase_token' => null,

                    'remember_token' => null,

                    'is_verify' => 'yes',

                    'is_block' => 'no',

                    'is_deleted' => 'no',

                    'account_status' => 'active',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | GET ALL ACTIVE PACKAGES
            |--------------------------------------------------------------------------
            |
            | Every package gets its own Three-Way tree.
            |
            */

            $packages = Package::where('status', 1)
                ->orderBy('id')
                ->get();


            if ($packages->isEmpty()) {

                $this->command->warn(
                    'No active packages found. Root tree was not initialized.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | CREATE ROOT FOR EACH PACKAGE TREE
            |--------------------------------------------------------------------------
            */

            foreach ($packages as $package) {

                /*
                |--------------------------------------------------------------------------
                | Root data
                |--------------------------------------------------------------------------
                */

                $rootData = [

                    'customer_id' =>
                        $customer->id,

                    'package_id' =>
                        $package->id,

                    'userId' =>
                        $customer->userid,

                    /*
                     * Root has no sponsor.
                     */
                    'sponser_id' =>
                        null,

                    /*
                     * Root has no parent.
                     */
                    'placedunder_id' =>
                        null,

                    'left_points' =>
                        0,

                    'right_points' =>
                        0,

                    'total_income' =>
                        0,

                    'last_settled_at' =>
                        null,

                    /*
                     * Root map.
                     */
                    'rootmap' =>
                        ',' . $customer->userid . ',',

                    'points' =>
                        0,

                    'edate' =>
                        now(),

                    'g_count' =>
                        0,

                    /*
                     * Root referral.
                     */
                    'g_reff' =>
                        $customer->userid,

                    /*
                     * Root initially has no children.
                     */
                    'placedunderid_cnt' =>
                        0,

                    'cron_start' =>
                        null,

                    'cron_end' =>
                        null,
                ];


                /*
                |--------------------------------------------------------------------------
                | Create / Verify Package Root
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | customer_id + package_id identifies the root
                | for that particular package tree.
                |
                */

                ThreeWayReferral::updateOrCreate(

                    [
                        'customer_id' =>
                            $customer->id,

                        'package_id' =>
                            $package->id,
                    ],

                    $rootData
                );


                $this->command->info(
                    'Root initialized for Package ID: '
                    . $package->id
                    . ' - '
                    . ($package->name ?? 'Package')
                );
            }


            /*
            |--------------------------------------------------------------------------
            | CONSOLE MESSAGE
            |--------------------------------------------------------------------------
            */

            $this->command->info(
                'Root customer created/verified successfully.'
            );

            $this->command->info(
                'Root User ID: ' .
                $customer->userid
            );

            $this->command->info(
                'Root Customer ID: ' .
                $customer->id
            );

            $this->command->info(
                'Three-Way root initialized for '
                . $packages->count()
                . ' package(s).'
            );
        });
    }
}