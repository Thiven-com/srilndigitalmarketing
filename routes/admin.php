<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BillerCategoryController;
use App\Http\Controllers\Admin\BillerGroupController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GiftCardCategoryController;
use App\Http\Controllers\Admin\GiftCardProductController;
use App\Http\Controllers\Admin\GiftTypeController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProductController;
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


    //Billers
    Route::resource('biller/categories', BillerCategoryController::class)->names('admin.biller.category');
    Route::resource('biller/groups', BillerGroupController::class)->names('admin.biller.groups');

    Route::resource('activities', ActivityController::class)->names('admin.activities');

    //Giftsection
    Route::resource('gift/card/products', GiftCardProductController::class)->names('admin.giftcard.products');
    Route::resource('gift/types', GiftTypeController::class)->names('admin.gifttypes');
    Route::resource('gift/card/categories', GiftCardCategoryController::class)->names('admin.giftcard.category');

    //Wallet
    Route::post('/wallet/add', [WalletController::class, 'add'])->name('admin.wallet.add');
    Route::post('/wallet/deduct', [WalletController::class, 'deduct'])->name('admin.wallet.deduct');

    Route::any('genealogy-tree/{id}', [TreeController::class, 'genealogyTree']);
    Route::any('leadership-table/{id}', [TreeController::class, 'genealogyTable']);
    Route::any('t20-genealogy-tree/{id}', [TreeController::class, 't20GenealogyTree']);
    Route::any('t20-table/{id}', [TreeController::class, 't20Table']);

    Route::any('unilevel-genealogy-tree/{id}', [TreeController::class, 'unilevelGenealogyTree']);
    Route::get(
        'unilevel-table/{id?}',
        [TreeController::class, 'unilevelTable']
    )->name('admin.unilevel.table');

    Route::post(
        '/makeSubscriber/{id}',
        [CustomerController::class, 'makeSubscriber']
    )->name('admin.makeSubscriber');

    Route::post('/customers/{customer}/update', [CustomerController::class, 'update'])
        ->name('admin.customer.update');

    Route::get('generateUserIds', [AuthController::class, 'generateUserIds']);

    Route::post(
        'customer/{customer}/update-sponsor',
        [CustomerController::class, 'updateSponsor']
    )->name('admin.customer.updateSponsor');
    Route::get('rebuildAllT20Tree', [CustomerController::class, 'rebuildAllT20Tree']);
    Route::get('rebuildCustomerReferralTree', [CustomerController::class, 'rebuildCustomerReferralTree']);
    //wallet
    Route::get('wallet-recharge/approve/{id}', [WalletRechargeController::class, 'approveWalletRecharge'])
        ->name('admin.wallet.recharge.approve');
    Route::get(
        'wallet-recharges',
        [WalletRechargeController::class, 'walletRechargeHistory']
    )->name('admin.wallet.recharges');

    //Withdraw Request
    Route::resource('withdraw-requests', WithdrawRequestController::class)->names('admin.withdraw-requests');
    Route::post('withdraw-requests/{id}/status', [WithdrawRequestController::class, 'updateStatus'])
        ->name('withdraw-requests.status');

    //Ecommerce
    Route::resource('products', 'ProductController')->names('admin.products');
    Route::resource('categories', 'CategoryController')->names('admin.categories');
    Route::resource('brands', 'BrandController')->names('admin.brands');
    Route::resource('units', 'UnitController')->names('admin.units');
    Route::resource('attributes', 'AttributeController')->names('admin.attributes');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])
        ->name('admin.productDestroy');
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
