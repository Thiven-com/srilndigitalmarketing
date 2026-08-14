<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('customer')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [CustomerController::class, 'dashboard'])
        ->name('customer.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [CustomerController::class, 'profile'])
        ->name('customer.profile');
    Route::get('/profile/edit', [CustomerController::class, 'editProfile'])
        ->name('customer.profile.edit');

    Route::post('/profile/update', [CustomerController::class, 'updateProfile'])
        ->name('customer.profile.update');
    Route::get('/kyc', [CustomerController::class, 'kyc'])
        ->name('customer.kyc');

    Route::post('/kyc/aadhaar/verify', [CustomerController::class, 'verifyAadhaar'])
        ->name('customer.kyc.aadhaar.verify');

    Route::post('/kyc/aadhaar/verify-otp', [CustomerController::class, 'verifyAadhaarOtp'])
        ->name('customer.kyc.aadhaar.verify.otp');

    Route::post('/kyc/pan/verify', [CustomerController::class, 'verifyPan'])
        ->name('customer.kyc.pan.verify');

    Route::post('/kyc/bank/verify', [CustomerController::class, 'verifyBank'])
        ->name('customer.kyc.bank.verify');

    Route::post('/kyc/upi/verify', [CustomerController::class, 'verifyUpi'])
        ->name('customer.kyc.upi.verify');


    /*
    |--------------------------------------------------------------------------
    | My Packages
    |--------------------------------------------------------------------------
    */

    Route::get('/myPackages', [CustomerController::class, 'myPackages'])
        ->name('customer.packages');
    Route::get('/package/{id}/details', [
        CustomerController::class,
        'packageDetails'
    ])->name('customer.package.details');


    Route::get('/package/{id}/tree', [
        CustomerController::class,
        'packageTree'
    ])->name('customer.package.tree');

    /*
    |--------------------------------------------------------------------------
    | Package Purchase
    |--------------------------------------------------------------------------
    */

    Route::get('/package/{id}/purchase', [CustomerController::class, 'purchasePackage'])
        ->name('customer.package.purchase');

    Route::post('/package/{id}/purchase', [CustomerController::class, 'storePackagePurchase'])
        ->name('customer.package.purchase.store');


    /*
    |--------------------------------------------------------------------------
    | My Package
    |--------------------------------------------------------------------------
    */

    Route::get('/my-package', [CustomerController::class, 'myPackage'])
        ->name('customer.my-package');


    /*
    |--------------------------------------------------------------------------
    | Wallet
    |--------------------------------------------------------------------------
    */

    Route::get('/wallet', [CustomerController::class, 'wallet'])
        ->name('customer.wallet');


    /*
    |--------------------------------------------------------------------------
    | Rewards
    |--------------------------------------------------------------------------
    */

    Route::get('/rewards', [CustomerController::class, 'rewards'])
        ->name('customer.rewards');


    /*
    |--------------------------------------------------------------------------
    | Earnings
    |--------------------------------------------------------------------------
    */

    Route::get('/earnings', [CustomerController::class, 'earnings'])
        ->name('customer.earnings');


    /*
    |--------------------------------------------------------------------------
    | Referrals
    |--------------------------------------------------------------------------
    */

    Route::get('/referrals', [CustomerController::class, 'referrals'])
        ->name('customer.referrals');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [CustomerController::class, 'logout'])
        ->name('customer.logout');

});