<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPackage;
use App\Models\Package;
use App\Models\PackageComponent;
use App\Models\PackageLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $customer = auth()->user();

        return view('website.customer.dashboard', compact(
            'customer'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        $customer = auth()->user();

        return view('website.customer.profile', compact(
            'customer'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function updateProfile(Request $request)
    {
        $customer = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

            'email' => [
                'nullable',
                'email',
                'max:255',
                'unique:customers,email,' . $customer->id,
            ],

            'dob' => 'nullable|date',

            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->dob = $request->dob;


        /*
        |--------------------------------------------------------------------------
        | Profile Picture
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_pic')) {

            if ($customer->profile_pic) {

                Storage::disk('public')->delete(
                    $customer->profile_pic
                );
            }

            $customer->profile_pic = $request
                ->file('profile_pic')
                ->store('customers/profile', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Email Verification Reset
        |--------------------------------------------------------------------------
        */

        if (
            $customer->isDirty('email') &&
            $customer->email
        ) {
            $customer->email_verified = 'no';
            $customer->email_verified_at = null;
        }


        $customer->save();


        return back()->with(
            'success',
            'Profile updated successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Packages
    |--------------------------------------------------------------------------
    */

    public function myPackages()
    {
        $customer = auth()->user();

        $packages = CustomerPackage::with('package')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view(
            'website.customer.my-packages',
            compact('customer', 'packages')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Package Details
    |--------------------------------------------------------------------------
    */

    public function packageDetails($id)
    {
        $package = Package::query()
            ->where('id', $id)
            ->where('status', true)
            ->firstOrFail();


        $components = PackageComponent::query()
            ->where('package_id', $package->id)
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();


        $levels = PackageLevel::query()
            ->where('package_id', $package->id)
            ->where('status', true)
            ->orderBy('level')
            ->get();


        return view(
            'website.customer.package-details',
            compact(
                'package',
                'components',
                'levels'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | My Package
    |--------------------------------------------------------------------------
    */

    public function myPackage()
    {
        $customer = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Package relationship will be connected here
        |--------------------------------------------------------------------------
        |
        | Once your customer package/purchase table is created,
        | load the customer's active package here.
        |
        */

        $package = null;

        return view(
            'website.customer.my-package',
            compact(
                'customer',
                'package'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Wallet
    |--------------------------------------------------------------------------
    */

    public function wallet()
    {
        $customer = auth()->user();

        return view(
            'website.customer.wallet',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Rewards
    |--------------------------------------------------------------------------
    */

    public function rewards()
    {
        $customer = auth()->user();

        return view(
            'website.customer.rewards',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Earnings
    |--------------------------------------------------------------------------
    */

    public function earnings()
    {
        $customer = auth()->user();

        return view(
            'website.customer.earnings',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Referrals
    |--------------------------------------------------------------------------
    */

    public function referrals()
    {
        $customer = auth()->user();

        return view(
            'website.customer.referrals',
            compact('customer')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with(
                'success',
                'Logged out successfully.'
            );
    }

    public function purchasePackage($id)
    {
        $customer = auth()->user();

        $package = Package::where('id', $id)
            ->where('status', true)
            ->first();

        return view(
            'website.customer.package-purchase',
            compact(
                'customer',
                'package'
            )
        );
    }
    public function storePackagePurchase(Request $request, $id)
    {
        $customer = auth()->user();

        $package = Package::where('id', $id)
            ->where('status', true)
            ->firstOrFail();

        $request->validate([
            'payment_reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'payment_receipt' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Check Existing Pending Purchase
        |--------------------------------------------------------------------------
        */

        $pendingPurchase = CustomerPackage::where(
            'customer_id',
            $customer->id
        )
            ->where(
                'package_id',
                $package->id
            )
            ->where(
                'payment_status',
                'pending'
            )
            ->exists();

        if ($pendingPurchase) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'You already have a pending payment for this package.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Receipt
        |--------------------------------------------------------------------------
        */

        $receiptPath = $request
            ->file('payment_receipt')
            ->store(
                'customer/package-payments',
                'public'
            );

        /*
        |--------------------------------------------------------------------------
        | Amount
        |--------------------------------------------------------------------------
        */

        $packageAmount = (float) ($package->price ?? 0);

        $joiningAmount = (float) ($package->joining_amount ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Total
        |--------------------------------------------------------------------------
        |
        | Since this is a lifetime package, there is no expiry calculation.
        |
        */

        $totalAmount = $packageAmount;

        /*
        |--------------------------------------------------------------------------
        | Create Purchase
        |--------------------------------------------------------------------------
        */

        $purchase = CustomerPackage::create([

            'customer_id' => $customer->id,

            'package_id' => $package->id,

            'order_number' =>
                'PKG-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(Str::random(5)),

            'package_amount' => $packageAmount,

            'joining_amount' => $joiningAmount,

            'total_amount' => $totalAmount,

            'payment_method' => 'qr',

            'payment_reference' =>
                $request->payment_reference,

            'payment_receipt' =>
                $receiptPath,

            'payment_status' => 'pending',

            'package_status' => 'pending',
        ]);

        return redirect()
            ->route('customer.my-packages')
            ->with(
                'success',
                'Payment receipt uploaded successfully. Your package is waiting for admin approval.'
            );
    }
}