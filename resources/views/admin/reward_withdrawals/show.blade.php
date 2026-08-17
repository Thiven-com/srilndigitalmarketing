@extends('layout.mainlayout')

@section('title', 'Withdrawal Details')

@section('content')

<div class="page-wrapper">

    <div class="content">


        {{-- ===================================================== --}}
        {{-- PAGE HEADER --}}
        {{-- ===================================================== --}}

        <div class="page-header d-flex justify-content-between align-items-center">

            <div class="page-title">

                <h4>
                    Reward Withdrawal Details
                </h4>

                <h6>
                    View customer withdrawal and settlement information
                </h6>

            </div>


            <div>

                <a
                    href="{{ route('admin.reward-withdrawals.index') }}"
                    class="btn btn-light">

                    <i class="ti ti-arrow-left me-1"></i>

                    Back

                </a>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- ALERTS --}}
        {{-- ===================================================== --}}

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <i class="ti ti-check me-1"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show">

                <i class="ti ti-alert-circle me-1"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        @if(session('warning'))

            <div class="alert alert-warning alert-dismissible fade show">

                <i class="ti ti-alert-triangle me-1"></i>

                {{ session('warning') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger alert-dismissible fade show">

                <strong>
                    Please fix the following errors:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ===================================================== --}}
        {{-- STATUS + REQUEST ID --}}
        {{-- ===================================================== --}}

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-1">
                            Withdrawal #{{ $withdrawal->id }}
                        </h5>

                        <span class="text-muted">

                            Requested on
                            {{ $withdrawal->created_at->format('d M Y, h:i A') }}

                        </span>

                    </div>


                    <div>

                        @if($withdrawal->status === 'pending')

                            <span class="badge bg-warning fs-12 px-3 py-2">

                                <i class="ti ti-clock me-1"></i>

                                Pending

                            </span>

                        @elseif($withdrawal->status === 'approved')

                            <span class="badge bg-primary fs-12 px-3 py-2">

                                <i class="ti ti-check me-1"></i>

                                Approved

                            </span>

                        @elseif($withdrawal->status === 'settled')

                            <span class="badge bg-success fs-12 px-3 py-2">

                                <i class="ti ti-circle-check me-1"></i>

                                Settled

                            </span>

                        @elseif($withdrawal->status === 'rejected')

                            <span class="badge bg-danger fs-12 px-3 py-2">

                                <i class="ti ti-x me-1"></i>

                                Rejected

                            </span>

                        @else

                            <span class="badge bg-secondary fs-12 px-3 py-2">

                                {{ ucfirst($withdrawal->status) }}

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- CUSTOMER DETAILS --}}
        {{-- ===================================================== --}}

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="ti ti-user me-1"></i>

                    Customer Details

                </h5>

            </div>


            <div class="card-body">

                <div class="row g-4">


                    <div class="col-md-3">

                        <div class="text-muted small">
                            Customer Name
                        </div>

                        <div class="fw-semibold mt-1">

                            {{ $customer->name ?? '-' }}

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="text-muted small">
                            User ID
                        </div>

                        <div class="fw-semibold mt-1">

                            {{ $customer->userid ?? '-' }}

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="text-muted small">
                            Mobile
                        </div>

                        <div class="fw-semibold mt-1">

                            {{ $customer->mobile ?? '-' }}

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="text-muted small">
                            Email
                        </div>

                        <div class="fw-semibold mt-1">

                            {{ $customer->email ?? '-' }}

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="text-muted small">
                            Account Status
                        </div>

                        <div class="fw-semibold mt-1">

                            {{ ucfirst($customer->account_status ?? '-') }}

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="text-muted small">
                            Rewards Balance
                        </div>

                        <div class="fw-bold text-success mt-1">

                            ₹{{ number_format(
                                $customer->rewards ?? 0,
                                2
                            ) }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- WITHDRAWAL AMOUNT --}}
        {{-- ===================================================== --}}

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="ti ti-wallet me-1"></i>

                    Withdrawal Amount

                </h5>

            </div>


            <div class="card-body">

                <div class="row g-3">


                    {{-- REQUESTED --}}
                    <div class="col-xl-3 col-md-6">

                        <div class="border rounded p-3 h-100">

                            <span class="text-muted d-block">
                                Requested Amount
                            </span>

                            <h4 class="mb-0 mt-2">

                                ₹{{ number_format(
                                    $withdrawal->requested_amount,
                                    2
                                ) }}

                            </h4>

                        </div>

                    </div>


                    {{-- DEDUCTION --}}
                    <div class="col-xl-3 col-md-6">

                        <div class="border rounded p-3 h-100">

                            <span class="text-muted d-block">
                                Deduction
                            </span>

                            <h4 class="mb-0 mt-2 text-danger">

                                -₹{{ number_format(
                                    $withdrawal->deduction_amount,
                                    2
                                ) }}

                            </h4>

                            <small class="text-muted">

                                {{ $withdrawal->deduction_percentage }}%

                            </small>

                        </div>

                    </div>


                    {{-- PAYABLE --}}
                    <div class="col-xl-3 col-md-6">

                        <div class="border border-success rounded p-3 h-100">

                            <span class="text-muted d-block">
                                Payable Amount
                            </span>

                            <h4 class="mb-0 mt-2 text-success">

                                ₹{{ number_format(
                                    $withdrawal->payable_amount,
                                    2
                                ) }}

                            </h4>

                        </div>

                    </div>


                    {{-- CURRENT BALANCE --}}
                    <div class="col-xl-3 col-md-6">

                        <div class="border rounded p-3 h-100">

                            <span class="text-muted d-block">
                                Current Rewards
                            </span>

                            <h4 class="mb-0 mt-2">

                                ₹{{ number_format(
                                    $customer->rewards ?? 0,
                                    2
                                ) }}

                            </h4>

                        </div>

                    </div>

                </div>


                <hr>


                <div class="row g-4">

                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            Opening Rewards
                        </span>

                        <strong>

                            ₹{{ number_format(
                                $withdrawal->opening_rewards ?? 0,
                                2
                            ) }}

                        </strong>

                    </div>


                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            Closing Rewards
                        </span>

                        <strong>

                            @if($withdrawal->closing_rewards !== null)

                                ₹{{ number_format(
                                    $withdrawal->closing_rewards,
                                    2
                                ) }}

                            @else

                                -

                            @endif

                        </strong>

                    </div>


                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            Payment Method
                        </span>

                        <strong>

                            {{ ucfirst(
                                $withdrawal->payment_method ?? 'Bank Transfer'
                            ) }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- BANK DETAILS --}}
        {{-- ===================================================== --}}

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">

                    <i class="ti ti-building-bank me-1"></i>

                    Customer Bank Account Details

                </h5>

            </div>


            <div class="card-body">

                <div class="row g-4">


                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            Account Holder Name
                        </span>

                        <strong>

                            {{ $customer->account_holder_name ?? '-' }}

                        </strong>

                    </div>


                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            Bank Name
                        </span>

                        <strong>

                            {{ $customer->bank_name ?? '-' }}

                        </strong>

                    </div>


                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            Account Number
                        </span>

                        <strong>

                            {{ $customer->account_number ?? '-' }}

                        </strong>

                    </div>


                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            IFSC Code
                        </span>

                        <strong>

                            {{ $customer->ifsc_code ?? '-' }}

                        </strong>

                    </div>


                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            Branch
                        </span>

                        <strong>

                            {{ $customer->bank_branch ?? '-' }}

                        </strong>

                    </div>


                    <div class="col-md-4">

                        <span class="text-muted d-block">
                            Account Type
                        </span>

                        <strong>

                            {{ $customer->account_type ?? '-' }}

                        </strong>

                    </div>

                </div>


                @if(
                    empty($customer->account_number) ||
                    empty($customer->ifsc_code)
                )

                    <div class="alert alert-warning mt-4 mb-0">

                        <i class="ti ti-alert-triangle me-1"></i>

                        <strong>
                            Bank details incomplete.
                        </strong>

                        Please verify the customer's bank account
                        details before making the payment.

                    </div>

                @else

                    <div class="alert alert-success mt-4 mb-0">

                        <i class="ti ti-check-circle me-1"></i>

                        Bank account details are available for settlement.

                    </div>

                @endif

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- PENDING ACTIONS --}}
        {{-- ===================================================== --}}

        @if($withdrawal->status === 'pending')

            <div class="card border-warning">

                <div class="card-header">

                    <h5 class="mb-0 text-warning">

                        <i class="ti ti-alert-triangle me-1"></i>

                        Admin Action

                    </h5>

                </div>


                <div class="card-body">

                    <div class="alert alert-warning">

                        <strong>
                            Review before approval:
                        </strong>

                        <ul class="mb-0 mt-2">

                            <li>
                                Verify customer identity.
                            </li>

                            <li>
                                Verify bank account and IFSC.
                            </li>

                            <li>
                                Confirm reward balance.
                            </li>

                            <li>
                                Requested amount:
                                <strong>
                                    ₹{{ number_format(
                                        $withdrawal->requested_amount,
                                        2
                                    ) }}
                                </strong>
                            </li>

                            <li>
                                Payable amount:
                                <strong>
                                    ₹{{ number_format(
                                        $withdrawal->payable_amount,
                                        2
                                    ) }}
                                </strong>
                            </li>

                        </ul>

                    </div>


                    <div class="d-flex gap-2">


                        {{-- APPROVE --}}
                        <form
                            action="{{ route(
                                'admin.reward-withdrawals.approve',
                                $withdrawal->id
                            ) }}"
                            method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success"
                                onclick="return confirm('Are you sure you want to approve this withdrawal?')">

                                <i class="ti ti-check me-1"></i>

                                Approve Withdrawal

                            </button>

                        </form>


                        {{-- REJECT --}}
                        <button
                            type="button"
                            class="btn btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#rejectWithdrawalModal">

                            <i class="ti ti-x me-1"></i>

                            Reject Withdrawal

                        </button>

                    </div>

                </div>

            </div>


            {{-- REJECT MODAL --}}
            <div
                class="modal fade"
                id="rejectWithdrawalModal"
                tabindex="-1"
                aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">

                        <form
                            action="{{ route(
                                'admin.reward-withdrawals.reject',
                                $withdrawal->id
                            ) }}"
                            method="POST">

                            @csrf


                            <div class="modal-header">

                                <h5 class="modal-title text-danger">

                                    Reject Withdrawal

                                </h5>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>

                            </div>


                            <div class="modal-body">

                                <div class="alert alert-warning">

                                    Requested Amount:

                                    <strong>

                                        ₹{{ number_format(
                                            $withdrawal->requested_amount,
                                            2
                                        ) }}

                                    </strong>

                                </div>


                                <div class="mb-3">

                                    <label class="form-label">

                                        Rejection Reason

                                        <span class="text-danger">
                                            *
                                        </span>

                                    </label>

                                    <textarea
                                        name="admin_remark"
                                        class="form-control"
                                        rows="4"
                                        required
                                        placeholder="Enter reason for rejection"></textarea>

                                </div>

                            </div>


                            <div class="modal-footer">

                                <button
                                    type="button"
                                    class="btn btn-light"
                                    data-bs-dismiss="modal">

                                    Cancel

                                </button>


                                <button
                                    type="submit"
                                    class="btn btn-danger">

                                    <i class="ti ti-x me-1"></i>

                                    Reject Withdrawal

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        @endif


        {{-- ===================================================== --}}
        {{-- APPROVED / SETTLEMENT --}}
        {{-- ===================================================== --}}

        @if($withdrawal->status === 'approved')

            <div class="card border-success">

                <div class="card-header">

                    <h5 class="mb-0 text-success">

                        <i class="ti ti-cash me-1"></i>

                        Settle Withdrawal

                    </h5>

                </div>


                <div class="card-body">


                    <div class="alert alert-success">

                        <div class="row">

                            <div class="col-md-6">

                                <span class="d-block">
                                    Amount to Transfer
                                </span>

                                <h3 class="mb-0">

                                    ₹{{ number_format(
                                        $withdrawal->payable_amount,
                                        2
                                    ) }}

                                </h3>

                            </div>


                            <div class="col-md-6">

                                <span class="d-block">
                                    Customer Bank Account
                                </span>

                                <strong>

                                    {{ $customer->bank_name ?? '-' }}

                                </strong>

                                <small class="d-block">

                                    A/C:
                                    {{ $customer->account_number ?? '-' }}

                                </small>

                                <small class="d-block">

                                    IFSC:
                                    {{ $customer->ifsc_code ?? '-' }}

                                </small>

                            </div>

                        </div>

                    </div>


                    <form
                        action="{{ route(
                            'admin.reward-withdrawals.settle',
                            $withdrawal->id
                        ) }}"
                        method="POST">

                        @csrf


                        <div class="row g-3">


                            {{-- SETTLED AMOUNT --}}
                            <div class="col-md-4">

                                <label class="form-label">

                                    Settlement Amount

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="number"
                                    name="settled_amount"
                                    class="form-control"
                                    value="{{ number_format(
                                        $withdrawal->payable_amount,
                                        2,
                                        '.',
                                        ''
                                    ) }}"
                                    min="0"
                                    step="0.01"
                                    required>

                                <small class="text-muted">

                                    Must equal the payable amount.

                                </small>

                            </div>


                            {{-- UTR --}}
                            <div class="col-md-4">

                                <label class="form-label">

                                    UTR / Transaction Reference

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="text"
                                    name="settlement_reference"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="Enter UTR / transaction number"
                                    required>

                            </div>


                            {{-- REMARK --}}
                            <div class="col-md-4">

                                <label class="form-label">

                                    Settlement Remark

                                </label>

                                <input
                                    type="text"
                                    name="settlement_remark"
                                    class="form-control"
                                    maxlength="1000"
                                    placeholder="Optional remark">

                            </div>

                        </div>


                        <div class="mt-4">

                            <button
                                type="submit"
                                class="btn btn-success"
                                onclick="return confirm('Confirm that the bank transfer has been completed?')">

                                <i class="ti ti-circle-check me-1"></i>

                                Settle Amount

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        @endif


        {{-- ===================================================== --}}
        {{-- REJECTED DETAILS --}}
        {{-- ===================================================== --}}

        @if($withdrawal->status === 'rejected')

            <div class="card border-danger">

                <div class="card-header">

                    <h5 class="mb-0 text-danger">

                        <i class="ti ti-x me-1"></i>

                        Rejection Details

                    </h5>

                </div>


                <div class="card-body">

                    <div class="alert alert-danger mb-0">

                        <strong>
                            Admin Remark:
                        </strong>

                        <div class="mt-2">

                            {{ $withdrawal->admin_remark ?? 'No rejection remark provided.' }}

                        </div>

                    </div>

                </div>

            </div>

        @endif


        {{-- ===================================================== --}}
        {{-- SETTLED DETAILS --}}
        {{-- ===================================================== --}}

        @if($withdrawal->status === 'settled')

            <div class="card border-success">

                <div class="card-header">

                    <h5 class="mb-0 text-success">

                        <i class="ti ti-circle-check me-1"></i>

                        Settlement Completed

                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-4">


                        {{-- SETTLED AMOUNT --}}
                        <div class="col-md-3">

                            <span class="text-muted d-block">
                                Settled Amount
                            </span>

                            <h4 class="text-success">

                                ₹{{ number_format(
                                    $withdrawal->settled_amount ?? 0,
                                    2
                                ) }}

                            </h4>

                        </div>


                        {{-- REFERENCE --}}
                        <div class="col-md-3">

                            <span class="text-muted d-block">
                                UTR / Transaction Reference
                            </span>

                            <strong>

                                {{ $withdrawal->settlement_reference ?? '-' }}

                            </strong>

                        </div>


                        {{-- DATE --}}
                        <div class="col-md-3">

                            <span class="text-muted d-block">
                                Settled At
                            </span>

                            <strong>

                                @if($withdrawal->settled_at)

                                    {{ $withdrawal->settled_at
                                        ->format('d M Y, h:i A') }}

                                @else

                                    -

                                @endif

                            </strong>

                        </div>


                        {{-- SETTLEMENT REMARK --}}
                        <div class="col-md-3">

                            <span class="text-muted d-block">
                                Settlement Remark
                            </span>

                            <strong>

                                {{ $withdrawal->settlement_remark ?? '-' }}

                            </strong>

                        </div>

                    </div>


                    <hr>


                    <div class="alert alert-success mb-0">

                        <i class="ti ti-check-circle me-1"></i>

                        This withdrawal has been successfully settled.

                    </div>

                </div>

            </div>

        @endif


        {{-- ===================================================== --}}
        {{-- ADMIN REMARK --}}
        {{-- ===================================================== --}}

        @if(
            $withdrawal->admin_remark &&
            $withdrawal->status !== 'rejected'
        )

            <div class="card">

                <div class="card-header">

                    <h5 class="mb-0">
                        Admin Remark
                    </h5>

                </div>

                <div class="card-body">

                    {{ $withdrawal->admin_remark }}

                </div>

            </div>

        @endif


    </div>

</div>

@endsection