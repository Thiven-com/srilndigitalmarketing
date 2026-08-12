@extends('layouts.website')

@section('title', 'Customer Dashboard')

@section('content')

<div class="customer-dashboard">

    <!-- Dashboard Header -->
    <section class="dashboard-hero">

        <div class="container-custom">

            <div class="dashboard-welcome">

                <div>
                    <span class="welcome-label">
                        MEMBER DASHBOARD
                    </span>

                    <h1>
                        Welcome back,
                        <span>{{ auth()->user()->name ?? 'Member' }}</span>
                    </h1>

                    <p>
                        Manage your package, earnings, referrals and account
                        from one place.
                    </p>
                </div>

                <div class="dashboard-avatar">

                    @if(auth()->user()->profile_pic)

                        <img
                            src="{{ asset('storage/' . auth()->user()->profile_pic) }}"
                            alt="{{ auth()->user()->name }}"
                        >

                    @else

                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}

                    @endif

                </div>

            </div>

        </div>

    </section>


    <!-- Statistics -->
    <section class="dashboard-content">

        <div class="container-custom">

            <div class="dashboard-stats">

                <!-- Wallet -->
                <div class="dashboard-stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <div class="stat-content">

                        <span>
                            Wallet Balance
                        </span>

                        <strong>
                            ₹{{ number_format(auth()->user()->wallet ?? 0, 2) }}
                        </strong>

                    </div>

                </div>


                <!-- Rewards -->
                <div class="dashboard-stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-gift"></i>
                    </div>

                    <div class="stat-content">

                        <span>
                            Rewards
                        </span>

                        <strong>
                            ₹{{ number_format(auth()->user()->rewards ?? 0, 2) }}
                        </strong>

                    </div>

                </div>


                <!-- KYC -->
                <div class="dashboard-stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div class="stat-content">

                        <span>
                            KYC Status
                        </span>

                        <strong class="status-text">
                            {{ ucfirst(auth()->user()->kyc_status ?? 'Pending') }}
                        </strong>

                    </div>

                </div>


                <!-- Mobile -->
                <div class="dashboard-stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-phone"></i>
                    </div>

                    <div class="stat-content">

                        <span>
                            Mobile
                        </span>

                        <strong>
                            {{ auth()->user()->mobile ?? '-' }}
                        </strong>

                    </div>

                </div>

            </div>


            <!-- Main Grid -->
            <div class="dashboard-grid">


                <!-- Left -->
                <div class="dashboard-main">


                    <!-- My Package -->
                    <div class="dashboard-card">

                        <div class="dashboard-card-header">

                            <div>

                                <span class="card-small-title">
                                    MY PACKAGE
                                </span>

                                <h3>
                                    Package Details
                                </h3>

                            </div>

                            <i class="bi bi-box-seam"></i>

                        </div>


                        <div class="empty-package">

                            <div class="empty-icon">
                                <i class="bi bi-box"></i>
                            </div>

                            <h4>
                                No Package Selected
                            </h4>

                            <p>
                                Choose a growth package to start your journey.
                            </p>

                            <a
                                href="{{ route('packages') }}"
                                class="dashboard-primary-btn"
                            >
                                Explore Packages
                                <i class="bi bi-arrow-right"></i>
                            </a>

                        </div>

                    </div>


                    <!-- Quick Actions -->
                    <div class="dashboard-card">

                        <div class="dashboard-card-header">

                            <div>

                                <span class="card-small-title">
                                    QUICK ACCESS
                                </span>

                                <h3>
                                    Manage Your Account
                                </h3>

                            </div>

                        </div>


                        <div class="quick-actions">


                            <a
                                href="{{ route('customer.profile') }}"
                                class="quick-action"
                            >

                                <div class="quick-icon">
                                    <i class="bi bi-person"></i>
                                </div>

                                <div>
                                    <strong>
                                        My Profile
                                    </strong>

                                    <span>
                                        Update your personal details
                                    </span>
                                </div>

                                <i class="bi bi-chevron-right"></i>

                            </a>


                            <a
                                href="{{ route('customer.packages') }}"
                                class="quick-action"
                            >

                                <div class="quick-icon">
                                    <i class="bi bi-box-seam"></i>
                                </div>

                                <div>
                                    <strong>
                                        Packages
                                    </strong>

                                    <span>
                                        Explore available packages
                                    </span>
                                </div>

                                <i class="bi bi-chevron-right"></i>

                            </a>


                            <a
                                href="{{ route('customer.wallet') }}"
                                class="quick-action"
                            >

                                <div class="quick-icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>

                                <div>
                                    <strong>
                                        Wallet
                                    </strong>

                                    <span>
                                        View your wallet transactions
                                    </span>
                                </div>

                                <i class="bi bi-chevron-right"></i>

                            </a>


                            <a
                                href="{{ route('customer.referrals') }}"
                                class="quick-action"
                            >

                                <div class="quick-icon">
                                    <i class="bi bi-people"></i>
                                </div>

                                <div>
                                    <strong>
                                        My Referrals
                                    </strong>

                                    <span>
                                        Manage your referral network
                                    </span>
                                </div>

                                <i class="bi bi-chevron-right"></i>

                            </a>


                        </div>

                    </div>

                </div>


                <!-- Right -->
                <div class="dashboard-sidebar">


                    <!-- Profile -->
                    <div class="dashboard-card profile-card">

                        <div class="profile-card-top">

                            <div class="profile-avatar">

                                @if(auth()->user()->profile_pic)

                                    <img
                                        src="{{ asset('storage/' . auth()->user()->profile_pic) }}"
                                        alt="{{ auth()->user()->name }}"
                                    >

                                @else

                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}

                                @endif

                            </div>

                            <div>

                                <h4>
                                    {{ auth()->user()->name ?? 'Member' }}
                                </h4>

                                <span>
                                    {{ auth()->user()->mobile ?? '-' }}
                                </span>

                            </div>

                        </div>


                        <div class="profile-info">

                            <div>
                                <span>Email</span>
                                <strong>
                                    {{ auth()->user()->email ?? '-' }}
                                </strong>
                            </div>

                            <div>
                                <span>Account Status</span>

                                <strong class="active-status">
                                    {{ ucfirst(auth()->user()->account_status ?? 'Pending') }}
                                </strong>
                            </div>

                        </div>


                        <a
                            href="{{ route('customer.profile') }}"
                            class="profile-btn"
                        >
                            View Profile
                        </a>

                    </div>


                    <!-- Referral -->
                    <div class="dashboard-card referral-card">

                        <div class="referral-icon">
                            <i class="bi bi-share"></i>
                        </div>

                        <h3>
                            Grow Your Network
                        </h3>

                        <p>
                            Invite people and grow your referral network.
                        </p>

                        <a
                            href="{{ route('customer.referrals') }}"
                            class="dashboard-primary-btn"
                        >
                            View Referrals
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>


                </div>

            </div>

        </div>

    </section>

</div>

@endsection