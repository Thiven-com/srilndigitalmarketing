@extends('layout.mainlayout')

@section('title', 'Customer Package Details')

@section('content')

<div class="page-wrapper">

    <div class="content">

        {{-- PAGE HEADER --}}
        <div class="page-header d-flex justify-content-between align-items-center">

            <div class="page-title">

                <h4>Customer Package Details</h4>

                <h6>
                    Review package purchase and payment receipt
                </h6>

            </div>

            <div class="page-btn">

                <a
                    href="{{ route('admin.customer-packages.index') }}"
                    class="btn btn-secondary"
                >

                    <i class="ti ti-arrow-left me-1"></i>

                    Back

                </a>

            </div>

        </div>


        {{-- ALERTS --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <i class="ti ti-check me-1"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show">

                <i class="ti ti-alert-circle me-1"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        {{-- =========================================================
            STATUS HEADER
        ========================================================== --}}

        <div class="card">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <div class="d-flex align-items-center">

                            <div
                                class="avatar avatar-lg bg-primary-subtle text-primary me-3"
                            >

                                <i class="ti ti-package fs-24"></i>

                            </div>

                            <div>

                                <h4 class="mb-1">

                                    {{ $customerPackage->package->name ?? 'Package' }}

                                </h4>

                                <p class="mb-0 text-muted">

                                    Order:
                                    <strong>
                                        {{ $customerPackage->order_number }}
                                    </strong>

                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4 text-md-end mt-3 mt-md-0">

                        @if($customerPackage->package_status === 'active')

                            <span class="badge bg-success fs-6 px-3 py-2">

                                <i class="ti ti-circle-check me-1"></i>

                                Active

                            </span>

                        @elseif($customerPackage->package_status === 'rejected')

                            <span class="badge bg-danger fs-6 px-3 py-2">

                                <i class="ti ti-circle-x me-1"></i>

                                Rejected

                            </span>

                        @else

                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">

                                <i class="ti ti-clock me-1"></i>

                                Pending Approval

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        <div class="row">


            {{-- =====================================================
                LEFT SIDE
            ====================================================== --}}

            <div class="col-lg-8">


                {{-- CUSTOMER DETAILS --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">

                            <i class="ti ti-user me-2"></i>

                            Customer Details

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-md-6">

                                <label class="text-muted mb-1">
                                    Customer Name
                                </label>

                                <h6 class="mb-0">

                                    {{ $customerPackage->customer->name ?? '-' }}

                                </h6>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted mb-1">
                                    Mobile
                                </label>

                                <h6 class="mb-0">

                                    {{ $customerPackage->customer->mobile ?? '-' }}

                                </h6>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted mb-1">
                                    Email
                                </label>

                                <h6 class="mb-0">

                                    {{ $customerPackage->customer->email ?? '-' }}

                                </h6>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted mb-1">
                                    Customer ID
                                </label>

                                <h6 class="mb-0">

                                    #{{ $customerPackage->customer_id }}

                                </h6>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- PACKAGE DETAILS --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">

                            <i class="ti ti-box me-2"></i>

                            Package Details

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-borderless mb-0">

                                <tbody>

                                    <tr>

                                        <td class="text-muted">
                                            Package
                                        </td>

                                        <td class="text-end fw-semibold">

                                            {{ $customerPackage->package->name ?? '-' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <td class="text-muted">
                                            Package Code
                                        </td>

                                        <td class="text-end">

                                            {{ $customerPackage->package->code ?? '-' }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <td class="text-muted">
                                            Package Amount
                                        </td>

                                        <td class="text-end">

                                            ₹{{ number_format($customerPackage->package_amount ?? 0, 2) }}

                                        </td>

                                    </tr>


                                    <tr>

                                        <td class="text-muted">
                                            Joining Amount
                                        </td>

                                        <td class="text-end">

                                            ₹{{ number_format($customerPackage->joining_amount ?? 0, 2) }}

                                        </td>

                                    </tr>


                                    <tr class="border-top">

                                        <td class="fw-bold">
                                            Total Amount
                                        </td>

                                        <td class="text-end">

                                            <h5 class="mb-0 text-primary">

                                                ₹{{ number_format($customerPackage->total_amount ?? 0, 2) }}

                                            </h5>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- PAYMENT DETAILS --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">

                            <i class="ti ti-credit-card me-2"></i>

                            Payment Details

                        </h5>

                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-md-6">

                                <label class="text-muted mb-1">
                                    Payment Method
                                </label>

                                <h6 class="mb-0">

                                    {{ strtoupper($customerPackage->payment_method ?? '-') }}

                                </h6>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted mb-1">
                                    Payment Status
                                </label>

                                <div>

                                    @if($customerPackage->payment_status === 'approved')

                                        <span class="badge bg-success">

                                            Approved

                                        </span>

                                    @elseif($customerPackage->payment_status === 'rejected')

                                        <span class="badge bg-danger">

                                            Rejected

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            Pending

                                        </span>

                                    @endif

                                </div>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted mb-1">
                                    Payment Reference / UTR
                                </label>

                                <h6 class="mb-0">

                                    {{ $customerPackage->payment_reference ?? '-' }}

                                </h6>

                            </div>


                            <div class="col-md-6">

                                <label class="text-muted mb-1">
                                    Purchase Date
                                </label>

                                <h6 class="mb-0">

                                    {{ optional($customerPackage->created_at)->format('d M Y h:i A') }}

                                </h6>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ADMIN REMARK --}}
                @if($customerPackage->admin_remark)

                    <div class="card">

                        <div class="card-header">

                            <h5 class="card-title mb-0">

                                <i class="ti ti-message me-2"></i>

                                Admin Remark

                            </h5>

                        </div>

                        <div class="card-body">

                            <div class="alert alert-light mb-0">

                                {{ $customerPackage->admin_remark }}

                            </div>

                        </div>

                    </div>

                @endif


            </div>


            {{-- =====================================================
                RIGHT SIDE
            ====================================================== --}}

            <div class="col-lg-4">


                {{-- RECEIPT --}}
                <div class="card">

                    <div class="card-header">

                        <h5 class="card-title mb-0">

                            <i class="ti ti-file-invoice me-2"></i>

                            Payment Receipt

                        </h5>

                    </div>

                    <div class="card-body text-center">

                        @if($customerPackage->payment_receipt)

                            <div class="border rounded p-2 bg-light">

                                <a
                                    href="{{ asset($customerPackage->payment_receipt) }}"
                                    target="_blank"
                                >

                                    <img
                                        src="{{ asset($customerPackage->payment_receipt) }}"
                                        alt="Payment Receipt"
                                        class="img-fluid rounded"
                                        style="max-height:450px; object-fit:contain;"
                                    >

                                </a>

                            </div>

                            <a
                                href="{{ asset($customerPackage->payment_receipt) }}"
                                target="_blank"
                                class="btn btn-outline-primary w-100 mt-3"
                            >

                                <i class="ti ti-external-link me-1"></i>

                                View Full Receipt

                            </a>

                        @else

                            <div class="py-5 text-muted">

                                <i class="ti ti-file-off fs-1 d-block mb-2"></i>

                                Payment receipt not uploaded.

                            </div>

                        @endif

                    </div>

                </div>


                {{-- APPROVAL --}}
                @if($customerPackage->payment_status === 'pending')

                    <div class="card">

                        <div class="card-header">

                            <h5 class="card-title mb-0">

                                <i class="ti ti-shield-check me-2"></i>

                                Payment Verification

                            </h5>

                        </div>

                        <div class="card-body">

                            <p class="text-muted">

                                Verify the payment receipt and UTR before
                                approving this package.

                            </p>


                            {{-- APPROVE --}}
                            <form
                                action="{{ route('admin.customer-packages.approve', $customerPackage->id) }}"
                                method="POST"
                                class="mb-2"
                            >

                                @csrf
                                <button
                                    type="submit"
                                    class="btn btn-success w-100"
                                    onclick="return confirm('Are you sure you want to approve this package?')"
                                >

                                    <i class="ti ti-check me-1"></i>

                                    Approve & Activate Package

                                </button>

                            </form>


                            {{-- REJECT --}}
                            <button
                                type="button"
                                class="btn btn-outline-danger w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#rejectModal"
                            >

                                <i class="ti ti-x me-1"></i>

                                Reject Payment

                            </button>

                        </div>

                    </div>

                @endif


                {{-- APPROVED INFORMATION --}}
                @if($customerPackage->payment_status === 'approved')

                    <div class="card border-success">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="avatar avatar-md bg-success-subtle text-success me-3">

                                    <i class="ti ti-circle-check fs-20"></i>

                                </div>

                                <div>

                                    <h6 class="mb-1">
                                        Payment Approved
                                    </h6>

                                    <small class="text-muted">

                                        Approved on

                                        {{ optional($customerPackage->approved_at)->format('d M Y h:i A') }}

                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- REJECTED INFORMATION --}}
                @if($customerPackage->payment_status === 'rejected')

                    <div class="card border-danger">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                <div class="avatar avatar-md bg-danger-subtle text-danger me-3">

                                    <i class="ti ti-circle-x fs-20"></i>

                                </div>

                                <div>

                                    <h6 class="mb-1">
                                        Payment Rejected
                                    </h6>

                                    <small class="text-muted">

                                        Rejected on

                                        {{ optional($customerPackage->rejected_at)->format('d M Y h:i A') }}

                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                @endif


            </div>

        </div>

    </div>

</div>


{{-- =============================================================
    REJECT MODAL
============================================================= --}}

@if($customerPackage->payment_status === 'pending')

<div
    class="modal fade"
    id="rejectModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Reject Package Payment

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="{{ route('admin.customer-packages.reject', $customerPackage->id) }}"
                method="POST"
            >

                @csrf

                <div class="modal-body">

                    <div class="alert alert-warning">

                        <i class="ti ti-alert-triangle me-1"></i>

                        The package will not be activated after rejection.

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Rejection Remark

                            <span class="text-danger">*</span>

                        </label>

                        <textarea
                            name="admin_remark"
                            class="form-control"
                            rows="4"
                            placeholder="Enter reason for rejecting this payment..."
                            required
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-danger"
                    >

                        <i class="ti ti-x me-1"></i>

                        Reject Payment

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif

@endsection