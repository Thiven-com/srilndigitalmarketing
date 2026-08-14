<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Generate Customer User ID
     *
     * Example:
     * SRILX12345678
     */
    public function generateUserID(): string
    {
        do {
            $letter = chr(random_int(65, 90));

            $numbers = str_pad(
                random_int(0, 99999999),
                8,
                '0',
                STR_PAD_LEFT
            );

            $userId = "SRIL{$letter}{$numbers}";

        } while (
            Customer::where('userid', $userId)->exists()
        );

        return $userId;
    }


    /**
     * Login page
     */
    public function login()
    {
        return view('website.auth.login');
    }


    /**
     * Check mobile number
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => [
                'required',
                'string',
                'min:10',
                'max:15',
            ],
        ]);

        $mobile = preg_replace('/[^0-9]/', '', $request->mobile);

        $customer = Customer::where('mobile', $mobile)->first();

        /*
        |--------------------------------------------------------------------------
        | NEW CUSTOMER
        |--------------------------------------------------------------------------
        */

        if (!$customer) {

            return redirect()
                ->route('register')
                ->withInput([
                    'mobile' => $mobile,
                ])
                ->with('new_customer', true);
        }


        /*
        |--------------------------------------------------------------------------
        | BLOCKED CUSTOMER
        |--------------------------------------------------------------------------
        */

        if ($customer->is_block === 'yes') {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Your account has been blocked. Please contact support.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE OTP
        |--------------------------------------------------------------------------
        */

        $otp = rand(100000, 999999);

        $customer->update([
            'otp' => $otp,
        ]);


        session([
            'otp_mobile' => $mobile,
            'otp_customer_id' => $customer->id,
            'otp_type' => 'login',
        ]);


        /*
        |--------------------------------------------------------------------------
        | DEVELOPMENT OTP
        |--------------------------------------------------------------------------
        */

        session([
            'development_otp' => $otp,
        ]);


        return redirect()
            ->route('verify.otp')
            ->with('success', 'OTP sent successfully.');
    }


    /**
     * Registration page
     */
    public function register()
    {
        return view('website.auth.register');
    }


    /**
     * Send registration OTP
     */
    public function sendRegisterOtp(Request $request)
    {
        $request->validate([

            'sponsor_user_id' => [
                'nullable',
                'string',
                'max:100',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'mobile' => [
                'required',
                'string',
                'min:10',
                'max:15',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

        ]);


        $mobile = preg_replace(
            '/[^0-9]/',
            '',
            $request->mobile
        );


        /*
        |--------------------------------------------------------------------------
        | CHECK EXISTING CUSTOMER
        |--------------------------------------------------------------------------
        */

        $existingCustomer = Customer::where(
            'mobile',
            $mobile
        )->first();

        if ($existingCustomer) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Mobile number already registered. Please login.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SPONSOR
        |--------------------------------------------------------------------------
        */

        $sponsorUserId = trim(
            $request->sponsor_user_id ?? ''
        );


        /*
        |--------------------------------------------------------------------------
        | CHECK SPONSOR IF ENTERED
        |--------------------------------------------------------------------------
        */

        $sponsor = null;

        if (!empty($sponsorUserId)) {

            $sponsor = Customer::where(
                'userid',
                $sponsorUserId
            )->first();

            if (!$sponsor) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Invalid Sponsor User ID.'
                    );
            }

            if ($sponsor->is_block === 'yes') {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'This sponsor account is blocked.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | OTP
        |--------------------------------------------------------------------------
        */

        $otp = rand(100000, 999999);


        /*
        |--------------------------------------------------------------------------
        | TEMP REGISTRATION DATA
        |--------------------------------------------------------------------------
        */

        session([
            'register_name' => $request->name,

            'register_mobile' => $mobile,

            'register_email' => $request->email,

            /*
            |--------------------------------------------------------------------------
            | Keep sponsor userid in session
            |--------------------------------------------------------------------------
            */

            'register_sponsor_user_id' => $sponsorUserId ?: null,

            'register_otp' => $otp,

            'otp_type' => 'register',
        ]);


        /*
        |--------------------------------------------------------------------------
        | DEVELOPMENT OTP
        |--------------------------------------------------------------------------
        */

        session([
            'development_otp' => $otp,
        ]);


        return redirect()
            ->route('verify.otp')
            ->with(
                'success',
                'OTP sent successfully.'
            );
    }


    /**
     * OTP page
     */
    public function verifyOtp()
    {
        if (
            !session('otp_mobile') &&
            !session('register_mobile')
        ) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Please enter your mobile number first.'
                );
        }

        return view(
            'website.auth.verify-otp'
        );
    }


    /**
     * Verify OTP
     */
    public function verifyOtpPost(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | LOGIN OTP
        |--------------------------------------------------------------------------
        */

        if (session('otp_type') === 'login') {

            $customer = Customer::find(
                session('otp_customer_id')
            );

            if (!$customer) {

                return redirect()
                    ->route('login')
                    ->with(
                        'error',
                        'Customer account not found.'
                    );
            }


            if ($customer->otp != $request->otp) {

                return back()
                    ->with(
                        'error',
                        'Invalid OTP. Please try again.'
                    );
            }


            $customer->update([
                'otp' => null,

                'mobile_verified' => 'yes',

                'mobile_verified_at' => now(),

                'is_verify' => 'yes',

                'account_status' => 'active',
            ]);


            Auth::guard('web')->login(
                $customer
            );


            session()->forget([
                'otp_mobile',
                'otp_customer_id',
                'otp_type',
                'development_otp',
            ]);


            return redirect()
                ->route('home')
                ->with(
                    'success',
                    'Login successful.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | REGISTRATION OTP
        |--------------------------------------------------------------------------
        */

        if (session('otp_type') === 'register') {

            if (
                session('register_otp') !=
                $request->otp
            ) {

                return back()
                    ->with(
                        'error',
                        'Invalid OTP. Please try again.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | CREATE CUSTOMER
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use (&$customer) {

                /*
                |--------------------------------------------------------------------------
                | Generate User ID
                |--------------------------------------------------------------------------
                */

                $userId = $this->generateUserID();


                /*
                |--------------------------------------------------------------------------
                | Sponsor
                |--------------------------------------------------------------------------
                */

                $sponsorUserId = session('register_sponsor_user_id');

                $sponsor = null;

                if (!empty($sponsorUserId)) {

                    $sponsor = Customer::where(
                        'userid',
                        $sponsorUserId
                    )->first();
                }


                /*
                |--------------------------------------------------------------------------
                | ROOT CUSTOMER
                |--------------------------------------------------------------------------
                |
                | If sponsor is empty, root user becomes sponsor.
                |
                */

                $root = Customer::where(
                    'userid',
                    'SLM00000001'
                )->first();


                /*
                |--------------------------------------------------------------------------
                | FINAL SPONSOR
                |--------------------------------------------------------------------------
                */

                if ($sponsor) {

                    $finalSponsorId = $sponsor->userid;
                    $sponsorName = $sponsor->name;

                } elseif ($root) {

                    $finalSponsorId = $root->userid;
                    $sponsorName = $root->name;

                } else {

                    throw new \Exception(
                        'Root account was not found. Please contact administrator.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | CREATE CUSTOMER ONLY
                |--------------------------------------------------------------------------
                |
                | DO NOT CREATE TREE RECORD HERE.
                |
                */

                $customer = Customer::create([

                    'userid' => $userId,

                    'name' => session('register_name'),

                    'old_name' => null,

                    'mobile' => session('register_mobile'),

                    'email' => session('register_email'),

                    /*
                    |--------------------------------------------------------------------------
                    | Sponsor
                    |--------------------------------------------------------------------------
                    */

                    'sponsor_id' => $finalSponsorId,

                    'sponsor_name' => $sponsorName,

                    /*
                    |--------------------------------------------------------------------------
                    | Wallet / Rewards
                    |--------------------------------------------------------------------------
                    */

                    'wallet' => 0,

                    'bonus' => 0,

                    'rewards' => 0,

                    'otp' => null,

                    /*
                    |--------------------------------------------------------------------------
                    | Account
                    |--------------------------------------------------------------------------
                    */

                    'activation' => 'yes',

                    'kyc_status' => 'pending',

                    'mobile_verified' => 'yes',

                    'email_verified' => 'no',

                    'mobile_verified_at' => now(),

                    'email_verified_at' => null,

                    'is_verify' => 'yes',

                    'is_block' => 'no',

                    'is_deleted' => 'no',

                    'account_status' => 'active',
                ]);
            });


            /*
            |--------------------------------------------------------------------------
            | LOGIN AFTER REGISTRATION
            |--------------------------------------------------------------------------
            */

            Auth::guard('web')->login(
                $customer
            );


            /*
            |--------------------------------------------------------------------------
            | CLEAR SESSION
            |--------------------------------------------------------------------------
            */

            session()->forget([

                'register_name',

                'register_mobile',

                'register_email',

                'register_sponsor_user_id',

                'register_otp',

                'otp_type',

                'development_otp',
            ]);


            return redirect()
                ->route('home')
                ->with(
                    'success',
                    'Registration completed successfully. Your User ID is ' .
                    $customer->userid
                );
        }


        return redirect()
            ->route('login')
            ->with(
                'error',
                'Invalid authentication session.'
            );
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Logged out successfully.'
            );
    }
}