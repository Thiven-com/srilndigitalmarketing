<?php $page = 'signin-2'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 600px; border-radius: 10px;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('website/images/logo.png') }}" alt="logo" style="max-height: 60px;">
                    <h3 class="mt-3">Verify OTP</h3>
                    <h4>Enter the OTP sent to your email</h4>

                </div>
                <form method="POST" action="{{ route('admin.password.verifyOtp') }}">
                    @csrf
                    <div class="login-userset">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <input type="hidden" name="email" value="{{ session('email') }}">

                        <div class="mb-3">
                            <label class="form-label">OTP Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control border-end-0 @error('otp') is-invalid @enderror"
                                    name="otp" placeholder="Enter 6-digit OTP">
                                <span class="input-group-text border-start-0">
                                    <i class="ti ti-key"></i>
                                </span>
                            </div>
                            @error('otp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-login">
                            <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                        </div>

                        <div class="signinform text-center">
                            <h6>
                                Didn't receive OTP?
                                <a href="{{ route('admin.password.request') }}" class="hover-a">
                                    Try Again
                                </a>
                            </h6>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection