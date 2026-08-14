<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\ThreeWayReferral;
use App\Models\ThreeWayDirectReferral;
use App\Models\FiveWayReferral;
use App\Models\FiveWayDirectReferral;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RootCustomerSeeder extends Seeder
{
    /**
     * Create root customer and initialize all four referral trees.
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
            | CHECK EXISTING ROOT CUSTOMER
            |--------------------------------------------------------------------------
            */

            $customer = Customer::where('userid', $userId)->first();

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
            | COMMON ROOT TREE DATA
            |--------------------------------------------------------------------------
            */

            $rootData = [

                'customer_id' => $customer->id,

                'userId' => $customer->userid,

                // Root has no sponsor
                'sponser_id' => null,

                // Root has no parent
                'placedunder_id' => null,

                'left_points' => 0,

                'right_points' => 0,

                'total_income' => 0,

                'last_settled_at' => null,

                // Root node
                'rootmap' => ',' . $customer->userid . ',',

                'presenttime' => now(),

                'points' => 0,

                'edate' => now(),

                'g_count' => 0,

                // Root referral
                'g_reff' => $customer->userid,

                // No children initially
                'placedunderid_cnt' => 0,

                'cron_start' => null,

                'cron_end' => null,
            ];


            /*
            |--------------------------------------------------------------------------
            | THREE WAY REFERRAL TREE
            |--------------------------------------------------------------------------
            */

            ThreeWayReferral::firstOrCreate(
                [
                    'customer_id' => $customer->id,
                ],
                $rootData
            );


            /*
            |--------------------------------------------------------------------------
            | THREE WAY DIRECT REFERRAL TREE
            |--------------------------------------------------------------------------
            */

            ThreeWayDirectReferral::firstOrCreate(
                [
                    'customer_id' => $customer->id,
                ],
                $rootData
            );


            /*
            |--------------------------------------------------------------------------
            | FIVE WAY REFERRAL TREE
            |--------------------------------------------------------------------------
            */

            FiveWayReferral::firstOrCreate(
                [
                    'customer_id' => $customer->id,
                ],
                $rootData
            );


            /*
            |--------------------------------------------------------------------------
            | FIVE WAY DIRECT REFERRAL TREE
            |--------------------------------------------------------------------------
            */

            FiveWayDirectReferral::firstOrCreate(
                [
                    'customer_id' => $customer->id,
                ],
                $rootData
            );


            /*
            |--------------------------------------------------------------------------
            | CONSOLE MESSAGE
            |--------------------------------------------------------------------------
            */

            $this->command->info(
                'Root customer created/verified successfully.'
            );

            $this->command->info(
                'Root User ID: ' . $customer->userid
            );

            $this->command->info(
                'Root Customer ID: ' . $customer->id
            );

            $this->command->info(
                'Initialized: 3-way, 3-way direct, 5-way and 5-way direct trees.'
            );
        });
    }
}