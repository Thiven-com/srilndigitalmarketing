@extends('layouts.website')

@section('title', 'Create Account')

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
                        <i class="bi bi-person-plus"></i>
                        CREATE ACCOUNT
                    </span>

                    <h1>
                        Join
                        <span>Us.</span>
                    </h1>

                    <p>
                        Create your account using your mobile number.
                        We will verify your number with a secure OTP.
                    </p>

                </div>


                @if(session('error'))

                    <div class="auth-alert error">

                        <i class="bi bi-exclamation-circle"></i>

                        <span>
                            {{ session('error') }}
                        </span>

                    </div>

                @endif


                @if(session('success'))

                    <div class="auth-alert success">

                        <i class="bi bi-check-circle"></i>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                @endif


                <form action="{{ route('register.send.otp') }}" method="POST" class="auth-form">

                    @csrf


                    {{-- NAME --}}
                    {{-- SPONSOR --}}

                    <div class="auth-field">

                        <label>
                            Sponsor User ID
                            <span class="text-muted">(Optional)</span>
                        </label>

                        <div class="auth-input">

                            <input type="text" name="sponsor_user_id" value="{{ old('sponsor_user_id', request('ref')) }}"
                                placeholder="Enter Sponsor User ID (Optional)">

                            <i class="bi bi-person-check"></i>

                        </div>

                        @error('sponsor_user_id')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                        <small class="text-muted">
                            Leave empty if you are creating the main account.
                        </small>

                    </div>


                    <div class="auth-field">

                        <label>
                            Full Name
                            <span style="color:#d92a7b;">*</span>
                        </label>

                        <div class="auth-input">

                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name"
                                required>

                            <i class="bi bi-person"></i>

                        </div>

                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- MOBILE --}}

                    <div class="auth-field">

                        <label>
                            Mobile Number
                            <span style="color:#d92a7b;">*</span>
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


                    {{-- EMAIL --}}

                    <div class="auth-field">

                        <label>
                            Email Address
                        </label>

                        <div class="auth-input">

                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your email address">

                            <i class="bi bi-envelope"></i>

                        </div>

                        @error('email')
                            <small>{{ $message }}</small>
                        @enderror

                    </div>


                    {{-- SUBMIT --}}

                    <button type="submit" class="auth-button">

                        Continue With OTP

                        <i class="bi bi-arrow-right"></i>

                    </button>

                </form>


                <div class="auth-divider">
                    <span>ALREADY A MEMBER?</span>
                </div>


                <a href="{{ route('login') }}" class="auth-register-button">
                    Login With Mobile
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
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <span>
                        GET STARTED
                    </span>

                    <h2>
                        Create your
                        <strong>account.</strong>
                    </h2>

                    <p>
                        It only takes a few moments to create
                        your account and get started.
                    </p>


                    <div class="auth-steps">

                        <div class="auth-step">

                            <div>
                                <i class="bi bi-person"></i>
                            </div>

                            <span>
                                Your Details
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
                                Account Ready
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection