<?php $page = 'signin-2'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 600px; border-radius: 10px;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('website/images/logo.png') }}" alt="logo" style="max-height: 60px;">
                    <h3 class="mt-3">Forgot Password</h3>
                </div>
                <form method="POST" action="{{ route('admin.password.sendOtp') }}">
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
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control border-end-0" name="email">
                                <span class="input-group-text border-start-0">
                                    <i class="ti ti-mail"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-primary w-100">Send OTP</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection