@extends('admin.customers.customer_menu')

@section('customer')

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="tab-content">

                <div class="tab-pane fade show active">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <h5 class="mb-1">Bank Details</h5>

                            <p class="text-muted mb-0">
                                Customer bank account and UPI information
                            </p>
                        </div>

                        @if($bankAccount)

                            @if($bankAccount->bank_status === 'approved')

                                <span class="badge bg-success px-3 py-2">
                                    <i class="ti ti-circle-check me-1"></i>
                                    Bank Verified
                                </span>

                            @elseif($bankAccount->bank_status === 'rejected')

                                <span class="badge bg-danger px-3 py-2">
                                    <i class="ti ti-circle-x me-1"></i>
                                    Bank Rejected
                                </span>

                            @else

                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="ti ti-clock me-1"></i>
                                    Bank Pending
                                </span>

                            @endif

                        @else

                            <span class="badge bg-secondary px-3 py-2">
                                No Bank Details
                            </span>

                        @endif

                    </div>


                    @if($bankAccount)

                                {{-- ================================================= --}}
                                {{-- BANK ACCOUNT --}}
                                {{-- ================================================= --}}

                                <div class="card border mb-4">

                                    <div class="card-header bg-light">

                                        <h6 class="mb-0 fw-semibold">
                                            <i class="ti ti-building-bank me-2"></i>
                                            Bank Account Information
                                        </h6>

                                    </div>

                                    <div class="card-body">

                                        <div class="row">

                                            {{-- User ID --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    User ID
                                                </div>

                                                <div class="fw-semibold">
                                                    {{ $bankAccount->user_id ?? '—' }}
                                                </div>

                                            </div>


                                            {{-- User Role --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    User Role
                                                </div>

                                                <div class="fw-semibold text-capitalize">
                                                    {{ $bankAccount->user_role ?? '—' }}
                                                </div>

                                            </div>


                                            {{-- Account Holder Name --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    Account Holder Name
                                                </div>

                                                <div class="fw-semibold">
                                                    {{ $bankAccount->account_name ?? '—' }}
                                                </div>

                                            </div>


                                            {{-- Bank Name --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    Bank Name
                                                </div>

                                                <div class="fw-semibold">
                                                    {{ $bankAccount->bank_name ?? '—' }}
                                                </div>

                                            </div>


                                            {{-- Account Number --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    Account Number
                                                </div>

                                                <div class="fw-semibold">

                                                    @if($bankAccount->account_number)

                                                        {{ $bankAccount->account_number }}

                                                    @else

                                                        —

                                                    @endif

                                                </div>

                                            </div>


                                            {{-- Account Type --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    Account Type
                                                </div>

                                                <div class="fw-semibold text-capitalize">
                                                    {{ $bankAccount->account_type ?? '—' }}
                                                </div>

                                            </div>


                                            {{-- IFSC --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    IFSC Code
                                                </div>

                                                <div class="fw-semibold text-uppercase">
                                                    {{ $bankAccount->ifsc_code ?? '—' }}
                                                </div>

                                            </div>


                                            {{-- Branch --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    Branch Name
                                                </div>

                                                <div class="fw-semibold">
                                                    {{ $bankAccount->branch_name ?? '—' }}
                                                </div>

                                            </div>


                                            {{-- Bank Status --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    Bank Status
                                                </div>

                                                <div class="mt-1">

                                                    @if($bankAccount->bank_status === 'approved')

                                                        <span class="badge bg-success">
                                                            <i class="ti ti-circle-check me-1"></i>
                                                            Approved
                                                        </span>

                                                    @elseif($bankAccount->bank_status === 'rejected')

                                                        <span class="badge bg-danger">
                                                            <i class="ti ti-circle-x me-1"></i>
                                                            Rejected
                                                        </span>

                                                    @else

                                                        <span class="badge bg-warning text-dark">
                                                            <i class="ti ti-clock me-1"></i>
                                                            Pending
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- UPI INFORMATION --}}
                                {{-- ================================================= --}}

                                <div class="card border mb-4">

                                    <div class="card-header bg-light">

                                        <h6 class="mb-0 fw-semibold">

                                            <i class="ti ti-brand-google me-2"></i>

                                            UPI Information

                                        </h6>

                                    </div>

                                    <div class="card-body">

                                        <div class="row">

                                            {{-- UPI ID --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    UPI ID
                                                </div>

                                                <div class="fw-semibold">

                                                    {{ $bankAccount->upi_id ?? '—' }}

                                                </div>

                                            </div>


                                            {{-- UPI Status --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    UPI Status
                                                </div>

                                                <div class="mt-1">

                                                    @if($bankAccount->upi_status === 'approved')

                                                        <span class="badge bg-success">

                                                            <i class="ti ti-circle-check me-1"></i>

                                                            Approved

                                                        </span>

                                                    @elseif($bankAccount->upi_status === 'rejected')

                                                        <span class="badge bg-danger">

                                                            <i class="ti ti-circle-x me-1"></i>

                                                            Rejected

                                                        </span>

                                                    @else

                                                        <span class="badge bg-warning text-dark">

                                                            <i class="ti ti-clock me-1"></i>

                                                            Pending

                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- RECORD INFORMATION --}}
                                {{-- ================================================= --}}

                                <div class="card border">

                                    <div class="card-header bg-light">

                                        <h6 class="mb-0 fw-semibold">

                                            <i class="ti ti-info-circle me-2"></i>

                                            Record Information

                                        </h6>

                                    </div>

                                    <div class="card-body">

                                        <div class="row">

                                            {{-- Created --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    Created At
                                                </div>

                                                <div class="fw-semibold">

                                                    {{ $bankAccount->created_at
                        ? $bankAccount->created_at->format('d M Y, h:i A')
                        : '—'
                                                        }}

                                                </div>

                                            </div>


                                            {{-- Updated --}}
                                            <div class="col-md-6 mb-3">

                                                <div class="text-muted small">
                                                    Last Updated
                                                </div>

                                                <div class="fw-semibold">

                                                    {{ $bankAccount->updated_at
                        ? $bankAccount->updated_at->format('d M Y, h:i A')
                        : '—'
                                                        }}

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>


                    @else

                        {{-- NO BANK DETAILS --}}

                        <div class="text-center py-5">

                            <div class="mb-3">

                                <i class="ti ti-building-bank" style="font-size: 60px; color: #adb5bd;">
                                </i>

                            </div>

                            <h5 class="fw-semibold">
                                No Bank Details Found
                            </h5>

                            <p class="text-muted mb-0">

                                This customer has not added bank account
                                or UPI details yet.

                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection