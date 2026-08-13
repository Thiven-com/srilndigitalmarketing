@extends('layout.mainlayout')

@section('content')

<style>
    .password-page {
        background: #f8fafc;
        min-height: 100vh;
    }

    .password-header {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 20px;
        padding: 30px;
        color: #fff;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(79, 70, 229, 0.2);
    }

    .password-card {
        border: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,.08);
    }

    .password-card .card-header {
        background: #fff;
        border-bottom: 1px solid #eef2f7;
        padding: 20px 25px;
    }

    .password-card .card-body {
        padding: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .input-group-text {
        background: #f8fafc;
        border-right: 0;
    }

    .form-control {
        height: 50px;
        border-left: 0;
        border-radius: 0 12px 12px 0 !important;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #6366f1;
    }

    .input-group {
        border-radius: 12px;
        overflow: hidden;
    }

    .password-tips {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        padding: 15px;
        margin-top: 20px;
    }

    .password-tips ul {
        margin: 0;
        padding-left: 20px;
    }

    .btn-update {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border: 0;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
    }

    .btn-update:hover {
        opacity: .95;
    }

    .security-icon {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }
</style>

<div class="page-wrapper password-page">
    <div class="content">

        {{-- Header --}}
        <div class="password-header d-flex justify-content-between align-items-center flex-wrap">

            <div>
                <h3 class="fw-bold text-white mb-2">
                    <i class="ti ti-lock me-2"></i>
                    Update Password
                </h3>
                <p class="mb-0 text-white opacity-75">
                    Secure your account by updating your password regularly.
                </p>
            </div>

            <div class="security-icon">
                <i class="ti ti-shield-lock"></i>
            </div>

        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="ti ti-circle-check me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card password-card">

                    <div class="card-header">
                        <h5 class="mb-0 fw-semibold">
                            <i class="ti ti-key me-2 text-primary"></i>
                            Change Password
                        </h5>
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.update.password') }}">
                            @csrf

                            {{-- Current Password --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    Current Password
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-lock"></i>
                                    </span>
                                    <input type="password"
                                        name="current_password"
                                        class="form-control"
                                        placeholder="Enter current password"
                                        required>
                                </div>
                            </div>

                            {{-- New Password --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    New Password
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-key"></i>
                                    </span>
                                    <input type="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Enter new password"
                                        required>
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    Confirm Password
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-check"></i>
                                    </span>
                                    <input type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        placeholder="Confirm new password"
                                        required>
                                </div>
                            </div>

                            {{-- Tips --}}
                            {{-- <div class="password-tips">
                                <h6 class="fw-semibold mb-2">
                                    <i class="ti ti-info-circle text-primary me-1"></i>
                                    Password Requirements
                                </h6>

                                <ul>
                                    <li>Minimum 8 characters</li>
                                    <li>Include uppercase and lowercase letters</li>
                                    <li>Include at least one number</li>
                                    <li>Include at least one special character</li>
                                </ul>
                            </div> --}}

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-update">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    Update Password
                                </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection