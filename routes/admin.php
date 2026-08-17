<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BillerCategoryController;
use App\Http\Controllers\Admin\BillerGroupController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerPackageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GiftCardCategoryController;
use App\Http\Controllers\Admin\GiftCardProductController;
use App\Http\Controllers\Admin\GiftTypeController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RewardWithdrawalController;
use App\Http\Controllers\Admin\RewardHistoryController;
use App\Http\Controllers\Admin\TreeController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\WalletRechargeController;
use App\Http\Controllers\Admin\WithdrawRequestController;
use Illuminate\Support\Facades\Route;

Route::get('login', "AuthController@showLoginForm")->name('admin.login');
Route::post('login', "AuthController@login")->name('admin.loginAction');
Route::get('logout', "AuthController@logout")->name('admin.logout');

Route::post('logout', "AuthController@logout")->name('admin.logout');

Route::group(['middleware' => 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('customers', CustomerController::class)->names('admin.customers');
    Route::get('change-password', [DashboardController::class, 'changePassword'])
        ->name('admin.change.password');
    Route::post('update-password', [DashboardController::class, 'updatePassword'])
        ->name('admin.update.password');

    Route::get('/reward-history', [RewardHistoryController::class, 'index'])
        ->name('admin.rewardhistory.index');


    Route::get('/customers', [CustomerController::class, 'index'])
        ->name('admin.customers.all');

    // Package List
    Route::get('/packages', [PackageController::class, 'index'])
        ->name('packages.all');

    // Create Package Form
    Route::get('/packages/create', [PackageController::class, 'create'])
        ->name('packages.create');

    Route::get('/packages/{package}', [PackageController::class, 'show'])
        ->name('packages.show');

    // Store Package
    Route::post('/packages', [PackageController::class, 'store'])
        ->name('packages.store');

    // Edit Package Form
    Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])
        ->name('packages.edit');

    // Update Package
    Route::put('/packages/{package}', [PackageController::class, 'update'])
        ->name('packages.update');

    // Delete Package
    Route::delete('/packages/{package}', [PackageController::class, 'destroy'])
        ->name('packages.destroy');

    Route::get('/customer-packages', [
        CustomerPackageController::class,
        'index'
    ])->name('admin.customer-packages.index');

    Route::get('/customer-packages/{id}', [
        CustomerPackageController::class,
        'show'
    ])->name('admin.customer-packages.show');

    Route::post('/customer-packages/{id}/approve', [
        CustomerPackageController::class,
        'approve'
    ])->name('admin.customer-packages.approve');

    Route::post('/customer-packages/{id}/reject', [
        CustomerPackageController::class,
        'reject'
    ])->name('admin.customer-packages.reject');
    Route::get(
        '/trees',
        [TreeController::class, 'index']
    )->name('admin.trees.index');

    //Reward Withdrawl
    Route::get(
        '/reward-withdrawals',
        [RewardWithdrawalController::class, 'index']
    )->name('admin.reward-withdrawals.index');
    Route::get(
        '/reward-withdrawals/{id}',
        [RewardWithdrawalController::class, 'show']
    )->name('admin.reward-withdrawals.show');

    Route::post(
        '/reward-withdrawals/{id}/approve',
        [RewardWithdrawalController::class, 'approve']
    )->name('admin.reward-withdrawals.approve');


    Route::post(
        '/reward-withdrawals/{id}/reject',
        [RewardWithdrawalController::class, 'reject']
    )->name('admin.reward-withdrawals.reject');
    Route::post(
        '/reward-withdrawals/{id}/settle',
        [RewardWithdrawalController::class, 'settle']
    )->name('admin.reward-withdrawals.settle');

});
Route::get('products/get-attribute-values/{unitId}', [ProductController::class, 'getAttributeValues'])->name('products.getAttributeValues');

Route::get('forgot-password', [AuthController::class, 'showForgotForm'])->name('admin.password.request');

Route::post('send-otp', [AuthController::class, 'sendOtp'])->name('admin.password.sendOtp');

Route::get('verify-otp', [AuthController::class, 'showVerifyForm'])->name('admin.password.verifyForm');

Route::post('verify-otp', [AuthController::class, 'verifyOtp'])->name('admin.password.verifyOtp');

Route::post('reset-password-otp', [AuthController::class, 'resetPassword'])->name('admin.password.resetOtp');

Route::get('/reset-password', function () {
    return view('admin.auth.reset-password', [
        'email' => session('email')
    ]);
})->name('admin.password.resetForm');
