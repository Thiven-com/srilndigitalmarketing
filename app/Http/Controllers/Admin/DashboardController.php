<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\CustomerSubscription;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Wallet;
use App\Models\WalletRecharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPackages = Package::count();
        $totalCustomers = Customer::count();
        return view('admin.auth.dash', compact('totalCustomers', 'totalPackages'));

    }
    // public function index(Request $request)
    // {
    //     $data['total_customers'] = Customer::count();

    //     return view('admin.auth.dash', compact('data'));
    // }

    public function changePassword()
    {
        return view('admin.auth.update-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = Auth::guard('admin')->user();
        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }
}
