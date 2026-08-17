<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\CustomerPackage;
use App\Models\CustomerSubscription;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Reward;
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
        // $adminCommission = CustomerPackage::query()
        //     ->where('payment_status', 'approved')
        //     ->join(
        //         'package_components',
        //         'package_components.package_id',
        //         '=',
        //         'customer_packages.package_id'
        //     )
        //     ->where(
        //         'package_components.component_type',
        //         'company'
        //     )
        //     ->sum('package_components.amount');

        $rewardCount = Reward::where('reward_type','package_bonus')->count();
        $adminCommission = $rewardCount * 150;
        return view('admin.auth.dash', compact('totalCustomers', 'totalPackages','adminCommission'));

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
