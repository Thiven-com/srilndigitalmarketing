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

                <a href="{{ route('customer.dashboard') }}" class="back-dashboard-btn">
                    <i class="bi bi-arrow-left"></i>
                    Dashboard
                </a>

            </div>


            {{-- WALLET BALANCE --}}
            {{-- <div class="balance-banner">

                <div>

                    <span>AVAILABLE WALLET BALANCE</span>

                    <strong>
                        ₹{{ number_format($customer->wallet ?? 0, 2) }}
                    </strong>

                </div>

                <div class="balance-banner-icon">
                    <i class="bi bi-wallet2"></i>
                </div>

            </div> --}}


            {{-- WALLET SUMMARY --}}
            <div class="dashboard-stat-grid">

                {{-- WALLET --}}
                {{-- <div class="dashboard-stat-card">

                    <div class="dashboard-stat-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <span>Wallet Balance</span>

                    <strong>
                        ₹{{ number_format($customer->wallet ?? 0, 2) }}
                    </strong>

                </div> --}}


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

                    {{-- <div class="profile-info-item">

                        <span>Available Balance</span>

                        <strong>
                            ₹{{ number_format($customer->wallet ?? 0, 2) }}
                        </strong>

                    </div> --}}


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


            {{-- REWARD HISTORY --}}
            <div class="customer-content-card" style="margin-top:22px;">

                <div class="customer-content-card-header">

                    <div>
                        <h3>
                            Rewards History
                        </h3>

                        <p class="text-muted mb-0">
                            Your complete reward earnings history.
                        </p>
                    </div>

                    <span class="page-label">
                        REWARD HISTORY
                    </span>

                </div>


                @if($rewardHistory->count())

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>

                                <tr>

                                    <th>
                                        Date
                                    </th>

                                    <th>
                                        Description
                                    </th>

                                    <th>
                                        Type
                                    </th>

                                    <th>
                                        Transaction
                                    </th>

                                    <th>
                                        Opening
                                    </th>

                                    <th>
                                        Amount
                                    </th>

                                    <th>
                                        Closing
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($rewardHistory as $reward)

                                    <tr>

                                        {{-- DATE --}}
                                        <td>

                                            <div class="fw-semibold">

                                                {{ optional($reward->created_at)->format('d M Y') }}

                                            </div>

                                            <small class="text-muted">

                                                {{ optional($reward->created_at)->format('h:i A') }}

                                            </small>

                                        </td>


                                        {{-- DESCRIPTION --}}
                                        <td>

                                            <div class="fw-semibold">

                                                {{ $reward->description ?? 'Reward' }}

                                            </div>

                                            @if($reward->source_type)

                                                <small class="text-muted">

                                                    {{ ucwords(str_replace('_', ' ', $reward->source_type)) }}

                                                </small>

                                            @endif

                                        </td>


                                        {{-- REWARD TYPE --}}
                                        <td>

                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">

                                                {{ ucwords(str_replace('_', ' ', $reward->reward_type ?? 'Reward')) }}

                                            </span>

                                        </td>


                                        {{-- TRANSACTION TYPE --}}
                                        <td>

                                            @if($reward->transaction_type === 'credit')

                                                <span class="text-success fw-semibold">

                                                    <i class="bi bi-arrow-down-circle me-1"></i>
                                                    Credit

                                                </span>

                                            @elseif($reward->transaction_type === 'debit')

                                                <span class="text-danger fw-semibold">

                                                    <i class="bi bi-arrow-up-circle me-1"></i>
                                                    Debit

                                                </span>

                                            @else

                                                <span class="text-muted">

                                                    {{ ucfirst($reward->transaction_type ?? '-') }}

                                                </span>

                                            @endif

                                        </td>


                                        {{-- OPENING BALANCE --}}
                                        <td>

                                            ₹{{ number_format((float) ($reward->opening_balance ?? 0), 2) }}

                                        </td>


                                        {{-- AMOUNT --}}
                                        <td>

                                            @if($reward->transaction_type === 'credit')

                                                <strong class="text-success">

                                                    +₹{{ number_format((float) $reward->amount, 2) }}

                                                </strong>

                                            @else

                                                <strong class="text-danger">

                                                    -₹{{ number_format((float) $reward->amount, 2) }}

                                                </strong>

                                            @endif

                                        </td>


                                        {{-- CLOSING BALANCE --}}
                                        <td>

                                            <strong>

                                                ₹{{ number_format((float) ($reward->closing_balance ?? 0), 2) }}

                                            </strong>

                                        </td>


                                        {{-- STATUS --}}
                                        <td>

                                            @if($reward->status)

                                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">

                                                    {{ ucfirst($reward->status) }}

                                                </span>

                                            @else

                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">

                                                    Pending

                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="packages-empty">

                        <div class="empty-icon">

                            <i class="bi bi-gift"></i>

                        </div>

                        <h3>
                            No Rewards Yet
                        </h3>

                        <p>
                            Your reward history will appear here after you earn rewards.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection