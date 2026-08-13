<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminPasswordResetOtpMail;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $email = Cookie::get('admin_email');
        $password = Cookie::get('admin_password')
            ? Crypt::decryptString(Cookie::get('admin_password'))
            : '';

        return view('admin.auth.login', compact('email', 'password'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {

            if ($remember) {

                Cookie::queue(
                    Cookie::make('admin_email', $request->email, 43200) // 30 days
                );

                Cookie::queue(
                    Cookie::make(
                        'admin_password',
                        Crypt::encryptString($request->password),
                        43200
                    )
                );
            } else {
                Cookie::queue(Cookie::forget('admin_email'));
                Cookie::queue(Cookie::forget('admin_password'));
            }

            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['Invalid Credentials']);
    }

    public function dashboard()
    {
        return view('admin.auth.dashboard'); // create this Blade view
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function showForgotForm()
    {
        return view('admin.auth.forgot-password');
    }
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (!isset($admin->id)) {
            return back()->withErrors(['email' => 'Invalid Email']);
        }
        $otp = 123456;
        // $otp = rand(100000, 999999);

        $admin->otp = $otp;
        $admin->save();

        // try {
        //     Mail::to($request->email)->send(new AdminPasswordResetOtpMail($otp));
        // } catch (\Exception $e) {
        // }
        session(['email' => $request->email]);
        return redirect()->route('admin.password.verifyForm')
            ->with('email', $request->email)
            ->with('success', 'OTP sent to your email.');
    }
    public function showVerifyForm()
    {
        if (!session('email')) {

            return redirect()->route('admin.password.request');
        }

        return view('admin.auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !$admin->otp) {
            session(['email' => $request->email]);

            return redirect(route('admin.password.verifyForm'))->withErrors(['otp' => 'Invalid OTP']);
        }

        if ($request->otp != $admin->otp) {
            session(['email' => $request->email]);

            return redirect(route('admin.password.verifyForm'))->withErrors(['otp' => 'Invalid OTP']);
        }

        session(['email' => $request->email]);

        return redirect()->route('admin.password.resetForm');
    }
    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);
        if (!session('email')) {
            return redirect()->route('admin.password.request');
        }

        if ($validator->fails()) {
            return redirect()
                ->route('admin.password.resetForm')
                ->withErrors($validator)
                ->withInput();
        }


        $admin = Admin::where('email', $request->email)->first();

        $admin->password = bcrypt($request->password);
        $admin->otp = null;
        $admin->save();
        session()->forget('email');

        return redirect()->route('admin.login')
            ->with('success', 'Password reset successfully.');
    }

    public function generateUserIds()
    {
        $customers = Customer::whereNull('userid')
            ->orWhere('userid', '')
            ->get();

        $service = new CustomerService();

        $updatedCount = 0;

        foreach ($customers as $customer) {

            // ensure unique userid
            do {
                $userId = $service->generateUserID();
            } while (
                Customer::where('userid', $userId)->exists()
            );

            $updated = Customer::where('id', $customer->id)->update([
                'userid' => $userId,
                'sponsor_id' => "ASK11122025",
                'sponsor_name' => "ASKRPAY",
                'updated_at' => now()
            ]);

            if ($updated) {
                $updatedCount++;
            }
        }

        return "Updated customers: " . $updatedCount;
    }
}
