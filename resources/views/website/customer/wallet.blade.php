@extends('layouts.website')

@section('title', 'My Wallet')

@section('content')
    <style>
        .wallet-alerts .alert {
            border: 0;
            padding: 15px 18px;
        }

        .wallet-alerts .alert-success {
            border-left: 4px solid #198754;
        }

        .wallet-alerts .alert-danger {
            border-left: 4px solid #dc3545;
        }

        .wallet-alerts .alert-warning {
            border-left: 4px solid #ffc107;
        }

        .wallet-alerts .alert-info {
            border-left: 4px solid #0dcaf0;
        }

        .wallet-alerts ul {
            margin-top: 5px;
        }
    </style>
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
            {{-- ALERT MESSAGES --}}
            <div class="wallet-alerts mb-4">

                {{-- SUCCESS --}}
                @if(session('success'))

                    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">

                        <i class="bi bi-check-circle-fill me-2"></i>

                        <strong>Success!</strong>

                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>

                @endif


                {{-- ERROR --}}
                @if(session('error'))

                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">

                        <i class="bi bi-x-circle-fill me-2"></i>

                        <strong>Error!</strong>

                        {{ session('error') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>

                @endif


                {{-- WARNING --}}
                @if(session('warning'))

                    <div class="alert alert-warning alert-dismissible fade show rounded-3 shadow-sm" role="alert">

                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        <strong>Warning!</strong>

                        {{ session('warning') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>

                @endif


                {{-- INFO --}}
                @if(session('info'))

                    <div class="alert alert-info alert-dismissible fade show rounded-3 shadow-sm" role="alert">

                        <i class="bi bi-info-circle-fill me-2"></i>

                        <strong>Info!</strong>

                        {{ session('info') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>

                @endif


                {{-- VALIDATION ERRORS --}}
                @if($errors->any())

                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">

                        <div class="fw-bold mb-2">

                            <i class="bi bi-exclamation-octagon-fill me-2"></i>

                            Please fix the following errors:

                        </div>

                        <ul class="mb-0 ps-4">

                            @foreach($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                        </button>

                    </div>

                @endif

            </div>

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

            {{-- WALLET TABS --}}
            <div class="customer-content-card mt-4">

                {{-- TAB HEADERS --}}
                <div class="wallet-tabs">

                    <button type="button" class="wallet-tab active" data-tab="rewards-history">

                        <i class="bi bi-gift me-1"></i>

                        Rewards History

                    </button>


                    <button type="button" class="wallet-tab" data-tab="withdraw-rewards">

                        <i class="bi bi-cash-coin me-1"></i>

                        Withdraw Rewards

                    </button>


                    <button type="button" class="wallet-tab" data-tab="withdrawal-history">

                        <i class="bi bi-clock-history me-1"></i>

                        Withdrawal Requests

                    </button>

                </div>


                {{-- TAB CONTENT --}}
                <div class="wallet-tab-content">


                    {{-- ====================================================== --}}
                    {{-- 1. REWARDS HISTORY --}}
                    {{-- ====================================================== --}}

                    <div id="rewards-history" class="wallet-tab-pane active">

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

                                            <th>Date</th>

                                            <th>Description</th>

                                            <th>Type</th>

                                            <th>Transaction</th>

                                            <th>Opening</th>

                                            <th>Amount</th>

                                            <th>Closing</th>

                                            <th>Status</th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach($rewardHistory as $reward)

                                                                    <tr>

                                                                        {{-- DATE --}}
                                                                        <td>

                                                                            <div class="fw-semibold">

                                                                                {{ optional($reward->created_at)
                                                ->format('d M Y') }}

                                                                            </div>

                                                                            <small class="text-muted">

                                                                                {{ optional($reward->created_at)
                                                ->format('h:i A') }}

                                                                            </small>

                                                                        </td>


                                                                        {{-- DESCRIPTION --}}
                                                                        <td>

                                                                            <div class="fw-semibold">

                                                                                {{ $reward->description ?? 'Reward' }}

                                                                            </div>

                                                                            @if($reward->source_type)

                                                                                                            <small class="text-muted">

                                                                                                                {{ ucwords(
                                                                                    str_replace(
                                                                                        '_',
                                                                                        ' ',
                                                                                        $reward->source_type
                                                                                    )
                                                                                ) }}

                                                                                                            </small>

                                                                            @endif

                                                                        </td>


                                                                        {{-- REWARD TYPE --}}
                                                                        <td>

                                                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">

                                                                                {{ ucwords(
                                                str_replace(
                                                    '_',
                                                    ' ',
                                                    $reward->reward_type ?? 'Reward'
                                                )
                                            ) }}

                                                                            </span>

                                                                        </td>


                                                                        {{-- TRANSACTION --}}
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

                                                                                                                {{ ucfirst(
                                                                                    $reward->transaction_type ?? '-'
                                                                                ) }}

                                                                                                            </span>

                                                                            @endif

                                                                        </td>


                                                                        {{-- OPENING --}}
                                                                        <td>

                                                                            ₹{{ number_format(
                                                (float) ($reward->opening_balance ?? 0),
                                                2
                                            ) }}

                                                                        </td>


                                                                        {{-- AMOUNT --}}
                                                                        <td>

                                                                            @if($reward->transaction_type === 'credit')

                                                                                                            <strong class="text-success">

                                                                                                                +₹{{ number_format(
                                                                                    (float) $reward->amount,
                                                                                    2
                                                                                ) }}

                                                                                                            </strong>

                                                                            @else

                                                                                                            <strong class="text-danger">

                                                                                                                -₹{{ number_format(
                                                                                    (float) $reward->amount,
                                                                                    2
                                                                                ) }}

                                                                                                            </strong>

                                                                            @endif

                                                                        </td>


                                                                        {{-- CLOSING --}}
                                                                        <td>

                                                                            <strong>

                                                                                ₹{{ number_format(
                                                (float) ($reward->closing_balance ?? 0),
                                                2
                                            ) }}

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


                    {{-- ====================================================== --}}
                    {{-- 2. WITHDRAW REWARDS --}}
                    {{-- ====================================================== --}}

                    <div id="withdraw-rewards" class="wallet-tab-pane">

                        <div class="customer-content-card-header">

                            <div>

                                <h3>
                                    Withdraw Rewards
                                </h3>

                                <p class="text-muted mb-0">
                                    Request withdrawal from your available reward balance.
                                </p>

                            </div>

                            <span class="page-label">
                                18% DEDUCTION
                            </span>

                        </div>


                        <form action="{{ route('customer.rewards.withdraw') }}" method="POST">

                            @csrf


                            <div class="row g-3">


                                {{-- AVAILABLE --}}
                                <div class="col-md-4">

                                    <label class="form-label">
                                        Available Rewards
                                    </label>

                                    <div class="form-control bg-light">

                                        ₹{{ number_format(
        (float) ($customer->rewards ?? 0),
        2
    ) }}

                                    </div>

                                </div>


                                {{-- AMOUNT --}}
                                <div class="col-md-4">

                                    <label class="form-label">
                                        Withdrawal Amount
                                    </label>

                                    <input type="number" name="amount" id="withdrawAmount" class="form-control" min="1000"
                                        max="{{ $customer->rewards ?? 0 }}" step="0.01" placeholder="Enter amount" required>

                                </div>


                                {{-- RECEIVE --}}
                                <div class="col-md-4">

                                    <label class="form-label">
                                        You Will Receive
                                    </label>

                                    <div class="form-control bg-light text-success fw-bold">

                                        ₹<span id="withdrawPayable">
                                            0.00
                                        </span>

                                    </div>

                                </div>

                            </div>


                            {{-- CALCULATION --}}
                            <div class="row mt-4">


                                <div class="col-md-4">

                                    <div class="border rounded-3 p-3">

                                        <small class="text-muted">
                                            Withdrawal Amount
                                        </small>

                                        <div class="fw-bold">

                                            ₹<span id="withdrawRequested">
                                                0.00
                                            </span>

                                        </div>

                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <div class="border rounded-3 p-3">

                                        <small class="text-muted">
                                            18% Deduction
                                        </small>

                                        <div class="fw-bold text-danger">

                                            -₹<span id="withdrawDeduction">
                                                0.00
                                            </span>

                                        </div>

                                    </div>

                                </div>


                                <div class="col-md-4">

                                    <div class="border rounded-3 p-3">

                                        <small class="text-muted">
                                            Final Amount
                                        </small>

                                        <div class="fw-bold text-success">

                                            ₹<span id="withdrawFinal">
                                                0.00
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="alert alert-warning mt-4">

                                <i class="bi bi-info-circle me-1"></i>

                                An 18% deduction will be applied to every reward withdrawal.

                            </div>


                            <button type="submit" class="btn btn-primary">

                                <i class="bi bi-cash-coin me-1"></i>

                                Request Withdrawal

                            </button>

                        </form>

                    </div>


                    {{-- ====================================================== --}}
                    {{-- 3. WITHDRAWAL HISTORY --}}
                    {{-- ====================================================== --}}

                    <div id="withdrawal-history" class="wallet-tab-pane">

                        <div class="customer-content-card-header">

                            <div>

                                <h3>
                                    Withdrawal Requests
                                </h3>

                                <p class="text-muted mb-0">
                                    View your reward withdrawal requests.
                                </p>

                            </div>

                            <span class="page-label">
                                WITHDRAWALS
                            </span>

                        </div>


                        @if($withdrawals->count())

                            <div class="table-responsive">

                                <table class="table align-middle mb-0">

                                    <thead>

                                        <tr>

                                            <th>Date</th>

                                            <th>Requested</th>

                                            <th>Deduction</th>

                                            <th>You Receive</th>

                                            <th>Status</th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach($withdrawals as $withdrawal)

                                                                    <tr>

                                                                        {{-- DATE --}}
                                                                        <td>

                                                                            <div class="fw-semibold">

                                                                                {{ $withdrawal->created_at
                                                ->format('d M Y') }}

                                                                            </div>

                                                                            <small class="text-muted">

                                                                                {{ $withdrawal->created_at
                                                ->format('h:i A') }}

                                                                            </small>

                                                                        </td>


                                                                        {{-- REQUEST --}}
                                                                        <td>

                                                                            <strong>

                                                                                ₹{{ number_format(
                                                (float) $withdrawal->requested_amount,
                                                2
                                            ) }}

                                                                            </strong>

                                                                        </td>


                                                                        {{-- DEDUCTION --}}
                                                                        <td>

                                                                            <span class="text-danger fw-semibold">

                                                                                -₹{{ number_format(
                                                (float) $withdrawal->deduction_amount,
                                                2
                                            ) }}

                                                                            </span>

                                                                            <small class="d-block text-muted">

                                                                                {{ number_format(
                                                (float) $withdrawal->deduction_percentage,
                                                2
                                            ) }}%

                                                                            </small>

                                                                        </td>


                                                                        {{-- PAYABLE --}}
                                                                        <td>

                                                                            <strong class="text-success">

                                                                                ₹{{ number_format(
                                                (float) $withdrawal->payable_amount,
                                                2
                                            ) }}

                                                                            </strong>

                                                                        </td>


                                                                        {{-- STATUS --}}
                                                                        <td>

                                                                            @if($withdrawal->status === 'approved')

                                                                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">

                                                                                    <i class="bi bi-check-circle me-1"></i>

                                                                                    Approved

                                                                                </span>

                                                                            @elseif($withdrawal->status === 'rejected')

                                                                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                                                                                    <i class="bi bi-x-circle me-1"></i>

                                                                                    Rejected

                                                                                </span>

                                                                                @if($withdrawal->admin_remark)

                                                                                    <small class="d-block text-muted mt-1">

                                                                                        {{ $withdrawal->admin_remark }}

                                                                                    </small>

                                                                                @endif

                                                                            @else

                                                                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">

                                                                                    <i class="bi bi-clock me-1"></i>

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

                                    <i class="bi bi-wallet2"></i>

                                </div>

                                <h3>
                                    No Withdrawal Requests
                                </h3>

                                <p>
                                    Your reward withdrawal requests will appear here.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
    <style>
        .wallet-tabs {
            display: flex;
            gap: 8px;
            padding: 6px;
            background: #f5f6f8;
            border-radius: 12px;
            margin-bottom: 25px;
            overflow-x: auto;
        }

        .wallet-tab {
            border: 0;
            background: transparent;
            padding: 11px 18px;
            border-radius: 9px;
            font-weight: 600;
            color: #6c757d;
            white-space: nowrap;
            transition: all .2s ease;
        }

        .wallet-tab:hover {
            color: #212529;
            background: #ffffff;
        }

        .wallet-tab.active {
            background: #ffffff;
            color: #0d6efd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        .wallet-tab-content {
            width: 100%;
        }

        .wallet-tab-pane {
            display: none;
        }

        .wallet-tab-pane.active {
            display: block;
        }

        @media(max-width: 767px) {

            .wallet-tabs {
                gap: 4px;
            }

            .wallet-tab {
                font-size: 13px;
                padding: 9px 12px;
            }

        }
    </style>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const input = document.getElementById('withdrawAmount');

            if (!input) {
                return;
            }

            input.addEventListener('input', function () {

                const amount = parseFloat(this.value) || 0;

                const deduction = amount * 18 / 100;

                const payable = amount - deduction;


                document.getElementById('withdrawRequested')
                    .innerText = amount.toFixed(2);


                document.getElementById('withdrawDeduction')
                    .innerText = deduction.toFixed(2);


                document.getElementById('withdrawFinal')
                    .innerText = payable.toFixed(2);


                document.getElementById('withdrawPayable')
                    .innerText = payable.toFixed(2);

            });

        });

    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Wallet Tabs
            |--------------------------------------------------------------------------
            */

            const tabs = document.querySelectorAll('.wallet-tab');

            const panes = document.querySelectorAll('.wallet-tab-pane');


            tabs.forEach(function (tab) {

                tab.addEventListener('click', function () {

                    const target =
                        this.getAttribute('data-tab');


                    /*
                    | Remove active
                    */

                    tabs.forEach(function (item) {

                        item.classList.remove('active');

                    });


                    panes.forEach(function (pane) {

                        pane.classList.remove('active');

                    });


                    /*
                    | Activate selected tab
                    */

                    this.classList.add('active');


                    const targetPane =
                        document.getElementById(target);


                    if (targetPane) {

                        targetPane.classList.add('active');

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Withdrawal Calculation
            |--------------------------------------------------------------------------
            */

            const input =
                document.getElementById('withdrawAmount');


            if (input) {

                input.addEventListener('input', function () {

                    const amount =
                        parseFloat(this.value) || 0;


                    const deduction =
                        amount * 18 / 100;


                    const payable =
                        amount - deduction;


                    document.getElementById(
                        'withdrawRequested'
                    ).innerText =
                        amount.toFixed(2);


                    document.getElementById(
                        'withdrawDeduction'
                    ).innerText =
                        deduction.toFixed(2);


                    document.getElementById(
                        'withdrawFinal'
                    ).innerText =
                        payable.toFixed(2);


                    document.getElementById(
                        'withdrawPayable'
                    ).innerText =
                        payable.toFixed(2);

                });

            }

        });

    </script>

@endsection