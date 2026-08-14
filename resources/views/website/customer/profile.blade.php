@extends('layouts.website')

@section('title', 'My Profile')

@section('content')

<section class="customer-profile-page">

    <div class="container-custom">

        <!-- Page Header -->
        <div class="profile-page-header">

            <div>

                <span class="profile-page-label">
                    MY ACCOUNT
                </span>

                <h1>
                    My Profile
                </h1>

                <p>
                    View and manage your personal account information.
                </p>

            </div>

            <a
                href="{{ route('customer.dashboard') }}"
                class="profile-back-btn"
            >
                <i class="bi bi-arrow-left"></i>
                Dashboard
            </a>

        </div>


        <div class="profile-layout">

            <!-- Profile Card -->
            <div class="profile-main-card">

                <div class="profile-cover"></div>

                <div class="profile-main-content">

                    <div class="profile-photo-wrapper">

                        <div class="profile-photo">

                            @if($customer->profile_pic)

                                <img
                                    src="{{ asset('storage/' . $customer->profile_pic) }}"
                                    alt="{{ $customer->name }}"
                                >

                            @else

                                {{ strtoupper(
                                    substr($customer->name ?? 'U', 0, 1)
                                ) }}

                            @endif

                        </div>

                    </div>


                    <div class="profile-name-area">

                        <h2>
                            {{ $customer->name ?? 'Member' }}
                        </h2>

                        <p>
                            <i class="bi bi-phone"></i>

                            {{ $customer->mobile ?? '-' }}
                        </p>

                    </div>


                    <div class="profile-status">

                        @if($customer->account_status === 'active')

                            <span class="status-active">
                                <i class="bi bi-check-circle-fill"></i>
                                Active
                            </span>

                        @else

                            <span class="status-pending">
                                <i class="bi bi-clock-fill"></i>
                                {{ ucfirst($customer->account_status ?? 'Pending') }}
                            </span>

                        @endif

                    </div>

                </div>


                <!-- Personal Information -->
                <div class="profile-section">

                    <div class="profile-section-title">

                        <div>

                            <span>
                                ACCOUNT INFORMATION
                            </span>

                            <h3>
                                Personal Details
                            </h3>

                        </div>

                        <i class="bi bi-person"></i>

                    </div>


                    <div class="profile-info-grid">


                        <div class="profile-info-item">

                            <span>
                                Full Name
                            </span>

                            <strong>
                                {{ $customer->name ?? '-' }}
                            </strong>

                        </div>


                        <div class="profile-info-item">

                            <span>
                                Mobile Number
                            </span>

                            <strong>
                                {{ $customer->mobile ?? '-' }}

                                @if($customer->mobile_verified === 'yes')

                                    <small class="verified">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Verified
                                    </small>

                                @endif

                            </strong>

                        </div>


                        <div class="profile-info-item">

                            <span>
                                Email Address
                            </span>

                            <strong>
                                {{ $customer->email ?? '-' }}
                            </strong>

                        </div>


                        <div class="profile-info-item">

                            <span>
                                Date of Birth
                            </span>

                            <strong>
                                @if($customer->dob)
                                    {{ $customer->dob->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </strong>

                        </div>


                        <div class="profile-info-item">

                            <span>
                                KYC Status
                            </span>

                            <strong>

                                @if($customer->kyc_status === 'approved')

                                    <small class="verified">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Approved
                                    </small>

                                @elseif($customer->kyc_status === 'rejected')

                                    <small class="rejected">
                                        <i class="bi bi-x-circle-fill"></i>
                                        Rejected
                                    </small>

                                @else

                                    <small class="pending">
                                        <i class="bi bi-clock-fill"></i>
                                        Pending
                                    </small>

                                @endif

                            </strong>

                        </div>


                        <div class="profile-info-item">

                            <span>
                                Account Status
                            </span>

                            <strong class="active-text">
                                {{ ucfirst($customer->account_status ?? 'Pending') }}
                            </strong>

                        </div>

                    </div>

                </div>


                <!-- Wallet Summary -->
                <div class="profile-section">

                    <div class="profile-section-title">

                        <div>

                            <span>
                                ACCOUNT SUMMARY
                            </span>

                            <h3>
                                Balance Overview
                            </h3>

                        </div>

                        <i class="bi bi-wallet2"></i>

                    </div>
                    {{-- <div class="balance-grid">

                        <div class="balance-box">

                            <div class="balance-icon">
                                <i class="bi bi-wallet2"></i>
                            </div>

                            <span>
                                Wallet Balance
                            </span>

                            <strong>
                                ₹{{ number_format($customer->wallet ?? 0, 2) }}
                            </strong>

                        </div>


                        <div class="balance-box">

                            <div class="balance-icon reward-icon">
                                <i class="bi bi-gift"></i>
                            </div>

                            <span>
                                Rewards
                            </span>

                            <strong>
                                ₹{{ number_format($customer->rewards ?? 0, 2) }}
                            </strong>

                        </div>

                    </div> --}}

                </div>


                <!-- Edit Profile -->
                <div class="profile-footer-action">

                    <a
                        href="{{ route('customer.profile.edit') }}"
                        class="edit-profile-btn"
                    >
                        <i class="bi bi-pencil"></i>
                        Edit Profile
                    </a>

                </div>

            </div>


            <!-- Right Sidebar -->
            <div class="profile-sidebar">


                <!-- Verification -->
                <div class="profile-side-card">

                    <div class="side-card-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <h3>
                        Account Verification
                    </h3>

                    <p>
                        Keep your account information verified and up to date.
                    </p>


                    <div class="verification-item">

                        <span>
                            Mobile
                        </span>

                        @if($customer->mobile_verified === 'yes')

                            <strong class="verified">
                                <i class="bi bi-check-circle-fill"></i>
                                Verified
                            </strong>

                        @else

                            <strong class="pending">
                                Pending
                            </strong>

                        @endif

                    </div>


                    <div class="verification-item">

                        <span>
                            Email
                        </span>

                        @if($customer->email_verified === 'yes')

                            <strong class="verified">
                                <i class="bi bi-check-circle-fill"></i>
                                Verified
                            </strong>

                        @else

                            <strong class="pending">
                                Pending
                            </strong>

                        @endif

                    </div>

                </div>


                <!-- Quick Links -->
                <div class="profile-side-card">

                    <h3>
                        Quick Links
                    </h3>


                    <a
                        href="{{ route('customer.dashboard') }}"
                        class="side-link"
                    >
                        <i class="bi bi-grid"></i>

                        Dashboard

                        <i class="bi bi-chevron-right"></i>
                    </a>


                    <a
                        href="{{ route('customer.packages') }}"
                        class="side-link"
                    >
                        <i class="bi bi-box-seam"></i>

                        My Packages

                        <i class="bi bi-chevron-right"></i>
                    </a>


                    <a
                        href="{{ route('customer.wallet') }}"
                        class="side-link"
                    >
                        <i class="bi bi-wallet2"></i>

                        Wallet

                        <i class="bi bi-chevron-right"></i>
                    </a>


                    <a
                        href="{{ route('customer.referrals') }}"
                        class="side-link"
                    >
                        <i class="bi bi-people"></i>

                        Referrals

                        <i class="bi bi-chevron-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection