<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
                ->with('error', 'Your account has been blocked. Please contact support.');
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


        /*
        |--------------------------------------------------------------------------
        | SESSION
        |--------------------------------------------------------------------------
        */

        session([
            'otp_mobile' => $mobile,
            'otp_customer_id' => $customer->id,
            'otp_type' => 'login',
        ]);


        /*
        |--------------------------------------------------------------------------
        | DEVELOPMENT
        |--------------------------------------------------------------------------
        |
        | Later replace this with MSG91 / SMS provider.
        |
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
            'name' => 'required|string|max:255',

            'mobile' => [
                'required',
                'string',
                'min:10',
                'max:15',
            ],

            'email' => 'nullable|email|max:255',
        ]);

        $mobile = preg_replace('/[^0-9]/', '', $request->mobile);


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
                ->with('error', 'Mobile number already registered. Please login.');
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
            ->with('success', 'OTP sent successfully.');
    }


    /**
     * OTP page
     */
    public function verifyOtp()
    {
        if (!session('otp_mobile') && !session('register_mobile')) {

            return redirect()
                ->route('login')
                ->with('error', 'Please enter your mobile number first.');
        }

        return view('website.auth.verify-otp');
    }


    /**
     * Verify OTP
     */
    public function verifyOtpPost(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
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
                    ->with('error', 'Customer account not found.');
            }


            if ($customer->otp != $request->otp) {

                return back()
                    ->with('error', 'Invalid OTP. Please try again.');
            }


            $customer->update([
                'otp' => null,
                'mobile_verified' => 'yes',
                'mobile_verified_at' => now(),
                'is_verify' => 'yes',
                'account_status' => 'active',
            ]);


            Auth::guard('web')->login($customer);


            session()->forget([
                'otp_mobile',
                'otp_customer_id',
                'otp_type',
                'development_otp',
            ]);


            return redirect()
                ->route('home')
                ->with('success', 'Login successful.');
        }


        /*
        |--------------------------------------------------------------------------
        | REGISTRATION OTP
        |--------------------------------------------------------------------------
        */

        if (session('otp_type') === 'register') {

            if (session('register_otp') != $request->otp) {

                return back()
                    ->with('error', 'Invalid OTP. Please try again.');
            }


            /*
            |--------------------------------------------------------------------------
            | CREATE CUSTOMER
            |--------------------------------------------------------------------------
            */

            $customer = Customer::create([
                'name' => session('register_name'),

                'mobile' => session('register_mobile'),

                'email' => session('register_email'),

                'otp' => null,

                'mobile_verified' => 'yes',

                'mobile_verified_at' => now(),

                'is_verify' => 'yes',

                'is_block' => 'no',

                'account_status' => 'active',

                'kyc_status' => 'pending',

                'wallet' => 0,

                'rewards' => 0,
            ]);


            /*
            |--------------------------------------------------------------------------
            | LOGIN AFTER REGISTRATION
            |--------------------------------------------------------------------------
            */

            Auth::guard('web')->login($customer);


            session()->forget([
                'register_name',
                'register_mobile',
                'register_email',
                'register_otp',
                'otp_type',
                'development_otp',
            ]);


            return redirect()
                ->route('home')
                ->with(
                    'success',
                    'Registration completed successfully.'
                );
        }


        return redirect()
            ->route('login')
            ->with('error', 'Invalid authentication session.');
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
            ->with('success', 'Logged out successfully.');
    }
}