@extends('layout.mainlayout')

@section('title', 'Reward Withdrawals')

@section('content')

<div class="page-wrapper">

    <div class="content">


        {{-- ===================================================== --}}
        {{-- PAGE HEADER --}}
        {{-- ===================================================== --}}

        <div class="page-header d-flex justify-content-between align-items-center">

            <div class="page-title">

                <h4>
                    Reward Withdrawals
                </h4>

                <h6>
                    Manage customer reward withdrawal requests
                </h6>

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
        {{-- STATISTICS --}}
        {{-- ===================================================== --}}

        <div class="row">

            {{-- PENDING --}}
            <div class="col-xl-3 col-sm-6 col-12">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <span class="text-muted">
                                    Pending
                                </span>

                                <h3 class="mb-0 mt-1">
                                    {{ $pendingCount }}
                                </h3>

                            </div>

                            <div
                                class="avatar avatar-md bg-warning-subtle rounded">

                                <i class="ti ti-clock text-warning fs-24"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- APPROVED --}}
            <div class="col-xl-3 col-sm-6 col-12">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <span class="text-muted">
                                    Approved
                                </span>

                                <h3 class="mb-0 mt-1">
                                    {{ $approvedCount }}
                                </h3>

                            </div>

                            <div
                                class="avatar avatar-md bg-primary-subtle rounded">

                                <i class="ti ti-check text-primary fs-24"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- SETTLED --}}
            <div class="col-xl-3 col-sm-6 col-12">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <span class="text-muted">
                                    Settled
                                </span>

                                <h3 class="mb-0 mt-1">
                                    {{ $settledCount }}
                                </h3>

                            </div>

                            <div
                                class="avatar avatar-md bg-success-subtle rounded">

                                <i class="ti ti-circle-check text-success fs-24"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- REJECTED --}}
            <div class="col-xl-3 col-sm-6 col-12">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <span class="text-muted">
                                    Rejected
                                </span>

                                <h3 class="mb-0 mt-1">
                                    {{ $rejectedCount }}
                                </h3>

                            </div>

                            <div
                                class="avatar avatar-md bg-danger-subtle rounded">

                                <i class="ti ti-x text-danger fs-24"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- FILTER --}}
        {{-- ===================================================== --}}

        <div class="card">

            <div class="card-body">

                <form
                    method="GET"
                    action="{{ route('admin.reward-withdrawals.index') }}">

                    <div class="row g-3">


                        {{-- SEARCH --}}
                        <div class="col-md-5">

                            <label class="form-label">
                                Search Customer
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>

                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    value="{{ request('search') }}"
                                    placeholder="Name, User ID, Mobile or Email">

                            </div>

                        </div>


                        {{-- STATUS --}}
                        <div class="col-md-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select">

                                <option value="">
                                    All Status
                                </option>

                                <option
                                    value="pending"
                                    @selected(request('status') === 'pending')>

                                    Pending

                                </option>

                                <option
                                    value="approved"
                                    @selected(request('status') === 'approved')>

                                    Approved

                                </option>

                                <option
                                    value="settled"
                                    @selected(request('status') === 'settled')>

                                    Settled

                                </option>

                                <option
                                    value="rejected"
                                    @selected(request('status') === 'rejected')>

                                    Rejected

                                </option>

                            </select>

                        </div>


                        {{-- BUTTONS --}}
                        <div class="col-md-4 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-primary me-2">

                                <i class="ti ti-search me-1"></i>

                                Search

                            </button>


                            <a
                                href="{{ route('admin.reward-withdrawals.index') }}"
                                class="btn btn-light">

                                <i class="ti ti-refresh me-1"></i>

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- WITHDRAWAL TABLE --}}
        {{-- ===================================================== --}}

        <div class="card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table">

                        <thead class="thead-light">

                            <tr>

                                <th>
                                    #
                                </th>

                                <th>
                                    Customer
                                </th>

                                <th>
                                    Requested
                                </th>

                                <th>
                                    Deduction
                                </th>

                                <th>
                                    Payable
                                </th>

                                <th>
                                    Reward Balance
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Requested On
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($withdrawals as $key => $withdrawal)

                                <tr>


                                    {{-- NUMBER --}}
                                    <td>

                                        {{ $withdrawals->firstItem() + $key }}

                                    </td>


                                    {{-- CUSTOMER --}}
                                    <td>

                                        @if($withdrawal->customer)

                                            <div>

                                                <strong>

                                                    {{ $withdrawal->customer->name }}

                                                </strong>

                                                <small class="d-block text-muted">

                                                    {{ $withdrawal->customer->userid }}

                                                </small>

                                                <small class="d-block text-muted">

                                                    {{ $withdrawal->customer->mobile }}

                                                </small>

                                            </div>

                                        @else

                                            <span class="text-muted">
                                                Customer not found
                                            </span>

                                        @endif

                                    </td>


                                    {{-- REQUESTED --}}
                                    <td>

                                        <strong>

                                            ₹{{ number_format(
                                                $withdrawal->requested_amount,
                                                2
                                            ) }}

                                        </strong>

                                    </td>


                                    {{-- DEDUCTION --}}
                                    <td>

                                        <span class="text-danger">

                                            -₹{{ number_format(
                                                $withdrawal->deduction_amount,
                                                2
                                            ) }}

                                        </span>

                                        <small class="d-block text-muted">

                                            {{ $withdrawal->deduction_percentage }}%

                                        </small>

                                    </td>


                                    {{-- PAYABLE --}}
                                    <td>

                                        <strong class="text-success">

                                            ₹{{ number_format(
                                                $withdrawal->payable_amount,
                                                2
                                            ) }}

                                        </strong>

                                    </td>


                                    {{-- REWARD BALANCE --}}
                                    <td>

                                        ₹{{ number_format(
                                            $withdrawal->customer->rewards ?? 0,
                                            2
                                        ) }}

                                    </td>


                                    {{-- STATUS --}}
                                    <td>

                                        @if($withdrawal->status === 'pending')

                                            <span class="badge bg-warning">

                                                <i class="ti ti-clock me-1"></i>

                                                Pending

                                            </span>


                                        @elseif($withdrawal->status === 'approved')

                                            <span class="badge bg-primary">

                                                <i class="ti ti-check me-1"></i>

                                                Approved

                                            </span>


                                        @elseif($withdrawal->status === 'settled')

                                            <span class="badge bg-success">

                                                <i class="ti ti-circle-check me-1"></i>

                                                Settled

                                            </span>


                                        @elseif($withdrawal->status === 'rejected')

                                            <span class="badge bg-danger">

                                                <i class="ti ti-x me-1"></i>

                                                Rejected

                                            </span>

                                        @else

                                            <span class="badge bg-secondary">

                                                {{ ucfirst($withdrawal->status) }}

                                            </span>

                                        @endif

                                    </td>


                                    {{-- DATE --}}
                                    <td>

                                        <span>

                                            {{ $withdrawal->created_at
                                                ->format('d M Y') }}

                                        </span>

                                        <small class="d-block text-muted">

                                            {{ $withdrawal->created_at
                                                ->format('h:i A') }}

                                        </small>

                                    </td>


                                    {{-- ACTION --}}
                                    <td>

                                        <div
                                            class="d-flex align-items-center gap-1">


                                            {{-- VIEW --}}
                                            <a
                                                href="{{ route(
                                                    'admin.reward-withdrawals.show',
                                                    $withdrawal->id
                                                ) }}"
                                                class="btn btn-info btn-sm text-white"
                                                title="View">

                                                <i class="ti ti-eye"></i>

                                            </a>


                                            {{-- PENDING ACTIONS --}}
                                            @if($withdrawal->status === 'pending')


                                                {{-- APPROVE --}}
                                                <form
                                                    action="{{ route(
                                                        'admin.reward-withdrawals.approve',
                                                        $withdrawal->id
                                                    ) }}"
                                                    method="POST"
                                                    class="d-inline">

                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="btn btn-success btn-sm"
                                                        title="Approve"
                                                        onclick="return confirm('Are you sure you want to approve this withdrawal?')">

                                                        <i class="ti ti-check"></i>

                                                    </button>

                                                </form>


                                                {{-- REJECT --}}
                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm"
                                                    title="Reject"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $withdrawal->id }}">

                                                    <i class="ti ti-x"></i>

                                                </button>

                                            @endif


                                            {{-- APPROVED --}}
                                            {{-- @if($withdrawal->status === 'approved')

                                                <a
                                                    href="{{ route(
                                                        'admin.reward-withdrawals.show',
                                                        $withdrawal->id
                                                    ) }}"
                                                    class="btn btn-warning btn-sm"
                                                    title="Settle">

                                                    <i class="ti ti-cash"></i>

                                                </a>

                                            @endif --}}


                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- REJECT MODAL --}}
                                        {{-- ================================================= --}}

                                        @if($withdrawal->status === 'pending')

                                            <div
                                                class="modal fade"
                                                id="rejectModal{{ $withdrawal->id }}"
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


                                                            {{-- HEADER --}}
                                                            <div class="modal-header">

                                                                <h5 class="modal-title">

                                                                    <i class="ti ti-x text-danger me-1"></i>

                                                                    Reject Withdrawal

                                                                </h5>

                                                                <button
                                                                    type="button"
                                                                    class="btn-close"
                                                                    data-bs-dismiss="modal">
                                                                </button>

                                                            </div>


                                                            {{-- BODY --}}
                                                            <div class="modal-body">


                                                                <div class="alert alert-warning">

                                                                    <div>

                                                                        Customer:

                                                                        <strong>

                                                                            {{ $withdrawal->customer->name ?? '-' }}

                                                                        </strong>

                                                                    </div>


                                                                    <div class="mt-1">

                                                                        Requested:

                                                                        <strong>

                                                                            ₹{{ number_format(
                                                                                $withdrawal->requested_amount,
                                                                                2
                                                                            ) }}

                                                                        </strong>

                                                                    </div>

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
                                                                        placeholder="Enter reason for rejecting this withdrawal"></textarea>

                                                                </div>

                                                            </div>


                                                            {{-- FOOTER --}}
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

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="9"
                                        class="text-center py-5">

                                        <div class="py-4">

                                            <i
                                                class="ti ti-wallet-off fs-40 text-muted">
                                            </i>

                                            <h5 class="mt-3">
                                                No Withdrawal Requests
                                            </h5>

                                            <p class="text-muted mb-0">

                                                No reward withdrawal requests
                                                match your search.

                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- ================================================= --}}
                {{-- PAGINATION --}}
                {{-- ================================================= --}}

                @if($withdrawals->hasPages())

                    <div class="p-3 border-top">

                        {{ $withdrawals->links('pagination::bootstrap-5') }}

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection