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
    Route::get('/profile/edit', [CustomerController::class, 'profile'])
        ->name('customer.profile.edit');

    Route::post('/profile/update', [CustomerController::class, 'updateProfile'])
        ->name('customer.profile.update');


    /*
    |--------------------------------------------------------------------------
    | My Packages
    |--------------------------------------------------------------------------
    */

    Route::get('/myPackages', [CustomerController::class, 'myPackages'])
        ->name('customer.packages');


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