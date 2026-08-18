<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\CustomerPackage;
use App\Models\CustomerSubscription;
use App\Models\Package;
use App\Models\PackageComponent;
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


        /*
        |--------------------------------------------------------------------------
        | PACKAGE 1 COMPANY COMMISSION
        |--------------------------------------------------------------------------
        */

        $package1Count = CustomerPackage::where(
            'package_id',
            1
        )
            ->where(
                'payment_status',
                'approved'
            )
            ->count();

        $package1Company = PackageComponent::where(
            'package_id',
            1
        )
            ->where(
                'component_type',
                'company'
            )
            ->where(
                'code',
                'COMPANY'
            )
            ->value('amount') ?? 0;

        $package1Commission =
            $package1Count * $package1Company;


        /*
        |--------------------------------------------------------------------------
        | PACKAGE 2 COMPANY COMMISSION
        |--------------------------------------------------------------------------
        */

        $package2Count = CustomerPackage::where(
            'package_id',
            2
        )
            ->where(
                'payment_status',
                'approved'
            )
            ->count();

        $package2Company = PackageComponent::where(
            'package_id',
            2
        )
            ->where(
                'component_type',
                'company'
            )
            ->where(
                'code',
                'COMPANY'
            )
            ->value('amount') ?? 0;

        $package2Commission =
            $package2Count * $package2Company;


        /*
        |--------------------------------------------------------------------------
        | PACKAGE 3 COMPANY COMMISSION
        |--------------------------------------------------------------------------
        */

        $package3Count = CustomerPackage::where(
            'package_id',
            3
        )
            ->where(
                'payment_status',
                'approved'
            )
            ->count();

        $package3Company = PackageComponent::where(
            'package_id',
            3
        )
            ->where(
                'component_type',
                'company'
            )
            ->where(
                'code',
                'COMPANY'
            )
            ->value('amount') ?? 0;

        $package3Commission =
            $package3Count * $package3Company;


        /*
        |--------------------------------------------------------------------------
        | PACKAGE 4 COMPANY COMMISSION
        |--------------------------------------------------------------------------
        */

        $package4Count = CustomerPackage::where(
            'package_id',
            4
        )
            ->where(
                'payment_status',
                'approved'
            )
            ->count();

        $package4Company = PackageComponent::where(
            'package_id',
            4
        )
            ->where(
                'component_type',
                'company'
            )
            ->where(
                'code',
                'COMPANY'
            )
            ->value('amount') ?? 0;

        $package4Commission =
            $package4Count * $package4Company;


        /*
        |--------------------------------------------------------------------------
        | TOTAL COMPANY COMMISSION
        |--------------------------------------------------------------------------
        */

        $totalAdminCommission =
            $package1Commission +
            $package2Commission +
            $package3Commission +
            $package4Commission;


        return view(
            'admin.auth.dash',
            compact(
                'totalCustomers',
                'totalPackages',

                'package1Commission',
                'package2Commission',
                'package3Commission',
                'package4Commission',

                'totalAdminCommission'
            )
        );
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
