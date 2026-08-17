<?php

use App\Http\Controllers\CustomerApp\AccountController;
use App\Http\Controllers\CustomerApp\ActivityController;
use App\Http\Controllers\CustomerApp\AddressController;
use App\Http\Controllers\CustomerApp\BankAccountController;
use App\Http\Controllers\CustomerApp\BillerController;
use App\Http\Controllers\CustomerApp\CartController;
use App\Http\Controllers\CustomerApp\CategoryController;
use App\Http\Controllers\CustomerApp\CheckoutController;
use App\Http\Controllers\CustomerApp\GiftCardController;
use App\Http\Controllers\CustomerApp\HomeController;
use App\Http\Controllers\CustomerApp\KycController;
use App\Http\Controllers\CustomerApp\PaymentController;
use App\Http\Controllers\CustomerApp\ProductVariantController;
use App\Http\Controllers\CustomerApp\ProfileController;
use App\Http\Controllers\CustomerApp\RechargeController;
use App\Http\Controllers\CustomerApp\SubscriptionController;
use App\Http\Controllers\CustomerApp\WebhookController;
use App\Http\Controllers\CustomerApp\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [AccountController::class, 'login']);
Route::post('verifyMobile', [AccountController::class, 'verifyMobile']);
Route::post('resendOtp', [AccountController::class, 'resendOtp']);

Route::get('category-billers', [BillerController::class, 'categoryBillers']);
Route::any('billerGroupDetails', [BillerController::class, 'billerGroupDetails']);

//Ecommerce
Route::get('categories', [CategoryController::class, 'categories']);
Route::get('home', [HomeController::class, 'index']);


Route::group(['middleware' => ['customertokenCheck']], function () {
    Route::get('logout', [AccountController::class, 'logout']);

    Route::get('profile', [ProfileController::class, 'profile']);
    Route::post('profile/update', [ProfileController::class, 'updateProfile']);
    Route::post('updateProfilePic', [ProfileController::class, 'updateProfilePic']);
    Route::get('deleteAccount', [ProfileController::class, 'deleteAccount']);


    Route::get('notifications', [ProfileController::class, 'notifications']);
    Route::get('markasRead', [ProfileController::class, 'markasRead']);

    Route::any('/recharge/fetch-plans', [RechargeController::class, 'fetchPlans']);
    Route::get('circleCodes', [RechargeController::class, 'circleCodes']);
    Route::get('billers', [RechargeController::class, 'billers']);

    Route::post('recharge/store', [RechargeController::class, 'store']);

    Route::post('submitCheckout', [CheckoutController::class, 'submit']);
    Route::post('payments/capture', [PaymentController::class, 'capture']);
    Route::post('ecommercePayments/capture', [PaymentController::class, 'ecommerceCapture']);

    Route::any('activities', [ActivityController::class, 'activities']);
    Route::any('activity/{id}', [ActivityController::class, 'activityDetails']);
    Route::any('latestBills', [ActivityController::class, 'latestBills']);

    Route::get('rewards', [ProfileController::class, 'rewards']);
    Route::get('walletHistory', [ProfileController::class, 'walletHistory']);
    Route::get('bonus', [ProfileController::class, 'bonus']);


    Route::any('giftcardCategories', [GiftCardController::class, 'giftcardCategories']);
    Route::any('giftcardTypes', [GiftCardController::class, 'giftcardTypes']);
    Route::any('giftcardProducts', [GiftCardController::class, 'giftcardProducts']);
    Route::post('giftcards/store', [GiftCardController::class, 'store']);

    //subscription
    Route::get('subscriptionPlans', [SubscriptionController::class, 'subscriptionPlans']);
    Route::post('purchaseSubscription', [SubscriptionController::class, 'purchaseSubscription']);
    Route::get('getLevelWiseTeamCount/{id}', [SubscriptionController::class, 'getLevelWiseTeamCount']);

    //Kyc
    Route::post('/bank/verify', [KycController::class, 'bankVerify']);
    Route::post('/bank/confirm', [KycController::class, 'bankConfirm']);
    Route::post('/upi/verify', [KycController::class, 'upiVerify']);
    Route::post('/upi/confirm', [KycController::class, 'upiConfirm']);

    Route::post('/pan/verify', [KycController::class, 'panVerify']);
    Route::post('/pan/confirm', [KycController::class, 'panConfirm']);

    //Ecommerce
    Route::post('products', [ProductVariantController::class, 'index']);
    Route::get('product/{slug}', [ProductVariantController::class, 'show']);

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);                  // view cart
        Route::post('add', [CartController::class, 'add']);                 // add to cart
        Route::post('{cartItem}/quantity', [CartController::class, 'updateQuantity']);
        Route::delete('{cartItem}', [CartController::class, 'remove']);     // remove one
        Route::delete('/', [CartController::class, 'clear']);               // clear all
    });
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index']);
        Route::post('add', [WishlistController::class, 'store']);
        Route::delete('{item}', [WishlistController::class, 'destroy']);
        Route::post('toggle', [WishlistController::class, 'toggle']);
    });

    Route::post('checkout/preview', [CheckoutController::class, 'show']);
    Route::post('checkout', [CheckoutController::class, 'store']);


    Route::get('locations', [AddressController::class, 'index']);
    Route::get('location/{id}/delete', [AddressController::class, 'destroy']);
    Route::post('location/store', [AddressController::class, 'store']);
});

Route::post('generateVoucher', [SubscriptionController::class, 'generateVoucher']);
Route::any('webhook/cashfree', [WebhookController::class, 'cashfreeWebhook']);


