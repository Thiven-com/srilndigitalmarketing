<?php $page = 'signin-2'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 600px; border-radius: 10px;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('website/images/logo.png') }}" alt="logo" style="max-height: 60px;">
                    <h3 class="mt-3">Reset Password</h3>
                    <h4>Enter your new password</h4>
                </div>
                <form method="POST" action="{{ route('admin.password.resetOtp') }}">
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

                        <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="pass-group">
                                <input type="password" name="password"
                                    class="form-control pass-input @error('password') is-invalid @enderror">
                                <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <div class="pass-group">
                                <input type="password" name="password_confirmation" class="form-control pass-input">
                                <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                            </div>
                        </div>

                        <div class="form-login">
                            <button type="submit" class="btn btn-primary w-100">
                                Reset Password
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection