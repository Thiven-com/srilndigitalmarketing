@extends('admin.customers.customer_menu')

@section('customer')

<div class="card border-0 shadow-sm">

    <div class="card-body">

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success mt-2">
                <i class="ti ti-check-circle me-1"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if(session('error'))
            <div class="alert alert-danger mt-2">
                <i class="ti ti-alert-circle me-1"></i>
                {{ session('error') }}
            </div>
        @endif


        {{-- ========================================================= --}}
        {{-- KYC HEADER --}}
        {{-- ========================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h5 class="fw-bold mb-1">
                    KYC Verification
                </h5>

                <p class="text-muted mb-0">
                    Customer KYC details and verification status
                </p>
            </div>

            @if($kyc)

                @php
                    $allApproved =
                        $kyc->aadhar_status === 'approved' &&
                        $kyc->pan_status === 'approved' &&
                        $kyc->gst_status === 'approved';
                @endphp

                @if($allApproved)

                    <span class="badge bg-success px-3 py-2">
                        <i class="ti ti-circle-check me-1"></i>
                        KYC Verified
                    </span>

                @else

                    <span class="badge bg-warning text-dark px-3 py-2">
                        <i class="ti ti-clock me-1"></i>
                        KYC Pending
                    </span>

                @endif

            @else

                <span class="badge bg-secondary px-3 py-2">
                    No KYC Submitted
                </span>

            @endif

        </div>


        @if($kyc)

            {{-- ===================================================== --}}
            {{-- AADHAAR --}}
            {{-- ===================================================== --}}

            <div class="card border rounded-4 mb-4">

                <div class="card-header bg-light border-0 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-2">

                            <div class="kyc-icon bg-primary-subtle text-primary">
                                <i class="ti ti-id"></i>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-0">
                                    Aadhaar Verification
                                </h6>

                                <small class="text-muted">
                                    Aadhaar identity verification
                                </small>
                            </div>

                        </div>


                        @if($kyc->aadhar_status === 'approved')

                            <span class="badge bg-success">
                                <i class="ti ti-check me-1"></i>
                                Approved
                            </span>

                        @elseif($kyc->aadhar_status === 'rejected')

                            <span class="badge bg-danger">
                                <i class="ti ti-x me-1"></i>
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


                <div class="card-body">

                    <div class="row g-4">

                        {{-- Aadhaar Number --}}
                        <div class="col-md-6">

                            <label class="text-muted small">
                                Aadhaar Number
                            </label>

                            <div class="fw-semibold mt-1">

                                @if($kyc->aadhaar_no)

                                    {{ substr($kyc->aadhaar_no, 0, 4) }}
                                    ****
                                    {{ substr($kyc->aadhaar_no, -4) }}

                                @else
                                    -
                                @endif

                            </div>

                        </div>


                        {{-- Verified Date --}}
                        <div class="col-md-6">

                            <label class="text-muted small">
                                Verified At
                            </label>

                            <div class="fw-semibold mt-1">

                                @if($kyc->aadhaar_verified_at)
                                    {{ $kyc->aadhaar_verified_at->format('d M Y, h:i A') }}
                                @else
                                    -
                                @endif

                            </div>

                        </div>


                        {{-- Aadhaar Image --}}
                        <div class="col-md-12">

                            <label class="text-muted small d-block mb-2">
                                Aadhaar Document
                            </label>

                            @if($kyc->aadhaar_image)

                                <a href="{{ asset('storage/' . $kyc->aadhaar_image) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">

                                    <i class="ti ti-eye me-1"></i>
                                    View Aadhaar Document

                                </a>

                            @else

                                <span class="text-muted">
                                    No document uploaded
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- PAN --}}
            {{-- ===================================================== --}}

            <div class="card border rounded-4 mb-4">

                <div class="card-header bg-light border-0 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-2">

                            <div class="kyc-icon bg-warning-subtle text-warning">
                                <i class="ti ti-file-text"></i>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-0">
                                    PAN Verification
                                </h6>

                                <small class="text-muted">
                                    Permanent Account Number verification
                                </small>
                            </div>

                        </div>


                        @if($kyc->pan_status === 'approved')

                            <span class="badge bg-success">
                                <i class="ti ti-check me-1"></i>
                                Approved
                            </span>

                        @elseif($kyc->pan_status === 'rejected')

                            <span class="badge bg-danger">
                                <i class="ti ti-x me-1"></i>
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


                <div class="card-body">

                    <div class="row g-4">

                        {{-- PAN Number --}}
                        <div class="col-md-6">

                            <label class="text-muted small">
                                PAN Number
                            </label>

                            <div class="fw-semibold mt-1">

                                {{ $kyc->pan_no ?? '-' }}

                            </div>

                        </div>


                        {{-- PAN Verified --}}
                        <div class="col-md-6">

                            <label class="text-muted small">
                                Verified At
                            </label>

                            <div class="fw-semibold mt-1">

                                @if($kyc->pan_verified_at)
                                    {{ $kyc->pan_verified_at->format('d M Y, h:i A') }}
                                @else
                                    -
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>




            {{-- ===================================================== --}}
            {{-- KYC META --}}
            {{-- ===================================================== --}}

            <div class="card border rounded-4">

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-4">

                            <span class="text-muted small d-block">
                                Customer ID
                            </span>

                            <strong>
                                #{{ $customer->id }}
                            </strong>

                        </div>


                        <div class="col-md-4">

                            <span class="text-muted small d-block">
                                KYC ID
                            </span>

                            <strong>
                                #{{ $kyc->id }}
                            </strong>

                        </div>


                        <div class="col-md-4">

                            <span class="text-muted small d-block">
                                Submitted On
                            </span>

                            <strong>
                                {{ $kyc->created_at->format('d M Y, h:i A') }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>


        @else

            {{-- ===================================================== --}}
            {{-- NO KYC --}}
            {{-- ===================================================== --}}

            <div class="text-center py-5">

                <div class="mb-3">

                    <i class="ti ti-file-certificate fs-1 text-muted"></i>

                </div>

                <h5 class="fw-bold">
                    No KYC Details Found
                </h5>

                <p class="text-muted mb-0">
                    This customer has not submitted any KYC information yet.
                </p>

            </div>

        @endif

    </div>

</div>


<style>

.kyc-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;
}

.card-header {
    background: #f8f9fa !important;
}

</style>

@endsection