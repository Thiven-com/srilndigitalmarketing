@extends('layouts.website')

@section('title', 'Login')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/auth.css') }}">
@endsection

@section('content')

    <section class="auth-page">

        <div class="auth-wrapper">

            {{-- LEFT --}}
            <div class="auth-content">

                <div class="auth-brand">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('website/images/logo.png') }}" alt="Logo">
                    </a>
                </div>

                <div class="auth-heading">

                    <span class="auth-badge">
                        <i class="bi bi-shield-lock"></i>
                        MEMBER LOGIN
                    </span>

                    <h1>
                        Welcome
                        <span>Back.</span>
                    </h1>

                    <p>
                        Login using your registered mobile number.
                        We will send you a secure OTP to continue.
                    </p>

                </div>


                @if(session('error'))

                    <div class="auth-alert error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>

                @endif


                @if(session('success'))

                    <div class="auth-alert success">
                        <i class="bi bi-check-circle"></i>
                        {{ session('success') }}
                    </div>

                @endif


                <form action="{{ route('login.send.otp') }}" method="POST" class="auth-form">

                    @csrf

                    <div class="auth-field">

                        <label>
                            Mobile Number
                        </label>

                        <div class="auth-input">

                            <span class="country-code">
                                +91
                            </span>

                            <input type="tel" name="mobile" value="{{ old('mobile') }}"
                                placeholder="Enter your mobile number" maxlength="10" required>

                            <i class="bi bi-phone"></i>

                        </div>

                        @error('mobile')
                            <small>{{ $message }}</small>
                        @enderror

                    </div>


                    <button type="submit" class="auth-button">

                        Continue With OTP

                        <i class="bi bi-arrow-right"></i>

                    </button>

                </form>


                <div class="auth-divider">
                    <span>NEW HERE?</span>
                </div>


                <a href="{{ route('register') }}" class="auth-register-button">
                    Create New Account
                </a>


                <p class="auth-bottom-text">

                    By continuing, you agree to our
                    <a href="#">Terms</a>
                    and
                    <a href="#">Privacy Policy</a>.

                </p>

            </div>


            {{-- RIGHT --}}
            <div class="auth-visual">

                <div class="auth-visual-content">

                    <div class="auth-visual-icon">
                        <i class="bi bi-phone"></i>
                    </div>

                    <span>
                        SIMPLE & SECURE
                    </span>

                    <h2>
                        Your journey
                        <strong>starts here.</strong>
                    </h2>

                    <p>
                        Enter your mobile number and verify
                        with a one-time password.
                    </p>


                    <div class="auth-steps">

                        <div class="auth-step">

                            <div>
                                <i class="bi bi-phone"></i>
                            </div>

                            <span>
                                Enter Mobile
                            </span>

                        </div>

                        <div class="auth-step-line"></div>

                        <div class="auth-step">

                            <div>
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <span>
                                Verify OTP
                            </span>

                        </div>

                        <div class="auth-step-line"></div>

                        <div class="auth-step">

                            <div>
                                <i class="bi bi-check-lg"></i>
                            </div>

                            <span>
                                Continue
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection