<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get("/", [PageController::class, "home"])->name("home");
Route::get("about", [PageController::class, "about"])->name("about");
Route::get("packages", [PageController::class, "packages"])->name("packages");

Route::get('/packages/{slug}', [PageController::class, 'packageDetails'])->name('package.details');

Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how.it.works');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/contact', [PageController::class, 'contact'])
    ->name('contact');

Route::post('/contact', [PageController::class, 'contactStore'])
    ->name('contact.store');

//Authentication
Route::get('/login', [AuthController::class, 'login'])
    ->name('login');

Route::post('/login/send-otp', [AuthController::class, 'sendOtp'])
    ->name('login.send.otp');

Route::get('/register', [AuthController::class, 'register'])
    ->name('register');

Route::post('/register/send-otp', [AuthController::class, 'sendRegisterOtp'])
    ->name('register.send.otp');

Route::get('/verify-otp', [AuthController::class, 'verifyOtp'])
    ->name('verify.otp');

Route::post('/verify-otp', [AuthController::class, 'verifyOtpPost'])
    ->name('verify.otp.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
