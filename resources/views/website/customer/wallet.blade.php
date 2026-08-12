@extends('layouts.website')

@section('title', 'My Wallet')

@section('content')

<div class="customer-wallet-page">

    <div class="container">

        {{-- PAGE HEADER --}}
        <div class="customer-page-header">

            <div>
                <span class="page-label">MY WALLET</span>

                <h1>Wallet</h1>

                <p>
                    Manage your wallet balance and account funds.
                </p>
            </div>

            <a
                href="{{ route('customer.dashboard') }}"
                class="back-dashboard-btn"
            >
                <i class="bi bi-arrow-left"></i>
                Dashboard
            </a>

        </div>


        {{-- WALLET BALANCE --}}
        <div class="balance-banner">

            <div>

                <span>AVAILABLE WALLET BALANCE</span>

                <strong>
                    ₹{{ number_format($customer->wallet ?? 0, 2) }}
                </strong>

            </div>

            <div class="balance-banner-icon">
                <i class="bi bi-wallet2"></i>
            </div>

        </div>


        {{-- WALLET SUMMARY --}}
        <div class="dashboard-stat-grid">

            {{-- WALLET --}}
            <div class="dashboard-stat-card">

                <div class="dashboard-stat-icon">
                    <i class="bi bi-wallet2"></i>
                </div>

                <span>Wallet Balance</span>

                <strong>
                    ₹{{ number_format($customer->wallet ?? 0, 2) }}
                </strong>

            </div>


            {{-- REWARDS --}}
            <div class="dashboard-stat-card">

                <div class="dashboard-stat-icon">
                    <i class="bi bi-gift"></i>
                </div>

                <span>Rewards</span>

                <strong>
                    ₹{{ number_format($customer->rewards ?? 0, 2) }}
                </strong>

            </div>


            {{-- ACCOUNT --}}
            <div class="dashboard-stat-card">

                <div class="dashboard-stat-icon">
                    <i class="bi bi-person-check"></i>
                </div>

                <span>Account Status</span>

                <strong style="font-size:15px;">
                    {{ ucfirst($customer->account_status ?? 'Pending') }}
                </strong>

            </div>


            {{-- MOBILE --}}
            <div class="dashboard-stat-card">

                <div class="dashboard-stat-icon">
                    <i class="bi bi-phone"></i>
                </div>

                <span>Mobile</span>

                <strong style="font-size:14px;">
                    {{ $customer->mobile }}
                </strong>

            </div>

        </div>


        {{-- WALLET INFORMATION --}}
        <div class="customer-content-card">

            <div class="customer-content-card-header">

                <h3>
                    Wallet Information
                </h3>

                <span class="page-label">
                    ACCOUNT BALANCE
                </span>

            </div>


            <div class="profile-info-grid">

                <div class="profile-info-item">

                    <span>Available Balance</span>

                    <strong>
                        ₹{{ number_format($customer->wallet ?? 0, 2) }}
                    </strong>

                </div>


                <div class="profile-info-item">

                    <span>Reward Balance</span>

                    <strong>
                        ₹{{ number_format($customer->rewards ?? 0, 2) }}
                    </strong>

                </div>


                <div class="profile-info-item">

                    <span>Mobile Verification</span>

                    <strong class="verified">

                        @if($customer->mobile_verified === 'yes')

                            <i class="bi bi-check-circle"></i>
                            Verified

                        @else

                            <i class="bi bi-exclamation-circle"></i>
                            Not Verified

                        @endif

                    </strong>

                </div>


                <div class="profile-info-item">

                    <span>Account Status</span>

                    <strong class="active-text">

                        {{ ucfirst($customer->account_status ?? 'Pending') }}

                    </strong>

                </div>

            </div>

        </div>


        {{-- TRANSACTIONS PLACEHOLDER --}}
        <div class="customer-content-card" style="margin-top:22px;">

            <div class="customer-content-card-header">

                <h3>
                    Wallet Transactions
                </h3>

                <span class="page-label">
                    TRANSACTION HISTORY
                </span>

            </div>


            <div class="packages-empty">

                <div class="empty-icon">

                    <i class="bi bi-receipt"></i>

                </div>

                <h3>
                    No Transactions Yet
                </h3>

                <p>
                    Your wallet transaction history will appear here.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection