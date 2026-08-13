@extends('layouts.website')

@section('content')

@php

    $kycStatus = $customer->kyc_status ?? 'pending';

    $aadhaarStatus = $kyc->aadhar_status ?? 'pending';

    $panStatus = $kyc->pan_status ?? 'pending';

    $aadhaarVerified = $aadhaarStatus === 'approved';

    $panVerified = $panStatus === 'approved';

@endphp


<div class="container py-5">


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            KYC Verification
        </h2>

        <p class="text-muted mb-0">
            Complete your identity verification step by step.
        </p>

    </div>



    {{-- =========================================================
        ALERTS
    ========================================================== --}}

    @if(session('success'))

        <div class="alert alert-success border-0 rounded-3 mb-4">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger border-0 rounded-3 mb-4">

            <i class="bi bi-exclamation-circle me-2"></i>

            {{ session('error') }}

        </div>

    @endif


    @if(session('status'))

        <div class="alert alert-success border-0 rounded-3 mb-4">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('status') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger border-0 rounded-3 mb-4">

            <div class="fw-semibold mb-2">
                Please check the following:
            </div>

            <ul class="mb-0 ps-3">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- =========================================================
        OVERALL KYC STATUS
    ========================================================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">


                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-circle d-flex align-items-center justify-content-center
                        @if($aadhaarVerified && $panVerified)
                            bg-success-subtle text-success
                        @elseif($aadhaarStatus === 'rejected' || $panStatus === 'rejected')
                            bg-danger-subtle text-danger
                        @else
                            bg-warning-subtle text-warning
                        @endif"
                        style="width:56px;height:56px;"
                    >

                        @if($aadhaarVerified && $panVerified)

                            <i class="bi bi-shield-check fs-4"></i>

                        @elseif($aadhaarStatus === 'rejected' || $panStatus === 'rejected')

                            <i class="bi bi-shield-x fs-4"></i>

                        @else

                            <i class="bi bi-shield-exclamation fs-4"></i>

                        @endif

                    </div>


                    <div>

                        <h5 class="fw-bold mb-1">
                            KYC Verification
                        </h5>

                        <p class="text-muted mb-0">
                            Verify your Aadhaar and PAN to complete KYC.
                        </p>

                    </div>

                </div>



                @if($aadhaarVerified && $panVerified)

                    <span class="badge bg-success-subtle text-success rounded-pill px-4 py-2">

                        <i class="bi bi-check-circle me-1"></i>

                        KYC Verified

                    </span>

                @elseif($aadhaarStatus === 'rejected' || $panStatus === 'rejected')

                    <span class="badge bg-danger-subtle text-danger rounded-pill px-4 py-2">

                        <i class="bi bi-x-circle me-1"></i>

                        KYC Rejected

                    </span>

                @else

                    <span class="badge bg-warning-subtle text-warning rounded-pill px-4 py-2">

                        <i class="bi bi-clock me-1"></i>

                        Verification Pending

                    </span>

                @endif

            </div>

        </div>

    </div>



    {{-- =========================================================
        PROGRESS
    ========================================================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="row g-3">


                {{-- STEP 1 --}}

                <div class="col-md-6">

                    <div
                        class="d-flex align-items-center gap-3 p-3 rounded-3
                        @if($aadhaarVerified)
                            bg-success-subtle
                        @else
                            bg-light
                        @endif"
                    >

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center
                            @if($aadhaarVerified)
                                bg-success text-white
                            @else
                                bg-secondary text-white
                            @endif"
                            style="width:40px;height:40px;"
                        >

                            @if($aadhaarVerified)

                                <i class="bi bi-check-lg"></i>

                            @else

                                1

                            @endif

                        </div>


                        <div>

                            <div class="fw-semibold">
                                Aadhaar
                            </div>

                            <small class="text-muted">

                                @if($aadhaarVerified)

                                    Verified

                                @else

                                    Required first

                                @endif

                            </small>

                        </div>

                    </div>

                </div>



                {{-- STEP 2 --}}

                <div class="col-md-6">

                    <div
                        class="d-flex align-items-center gap-3 p-3 rounded-3
                        @if($panVerified)
                            bg-success-subtle
                        @elseif($aadhaarVerified)
                            bg-primary-subtle
                        @else
                            bg-light
                        @endif"
                    >

                        <div
                            class="rounded-circle d-flex align-items-center justify-content-center
                            @if($panVerified)
                                bg-success text-white
                            @elseif($aadhaarVerified)
                                bg-primary text-white
                            @else
                                bg-secondary text-white
                            @endif"
                            style="width:40px;height:40px;"
                        >

                            @if($panVerified)

                                <i class="bi bi-check-lg"></i>

                            @elseif(!$aadhaarVerified)

                                <i class="bi bi-lock"></i>

                            @else

                                2

                            @endif

                        </div>


                        <div>

                            <div class="fw-semibold">
                                PAN
                            </div>

                            <small class="text-muted">

                                @if($panVerified)

                                    Verified

                                @elseif($aadhaarVerified)

                                    Ready to verify

                                @else

                                    Complete Aadhaar first

                                @endif

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        STEP 1 - AADHAAR
    ========================================================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4 p-lg-5">


            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">


                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                        style="width:50px;height:50px;"
                    >

                        <i class="bi bi-person-vcard fs-4"></i>

                    </div>


                    <div>

                        <h5 class="fw-bold mb-1">
                            Step 1 — Aadhaar Verification
                        </h5>

                        <p class="text-muted mb-0">
                            Verify your Aadhaar before continuing.
                        </p>

                    </div>

                </div>



                @if($aadhaarStatus === 'approved')

                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">

                        <i class="bi bi-check-circle me-1"></i>

                        Verified

                    </span>

                @elseif($aadhaarStatus === 'rejected')

                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                        <i class="bi bi-x-circle me-1"></i>

                        Rejected

                    </span>

                @else

                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">

                        <i class="bi bi-clock me-1"></i>

                        Pending

                    </span>

                @endif

            </div>



            @if($aadhaarVerified)

                <div class="alert alert-success border-0 rounded-3 mb-0">

                    <div class="d-flex gap-3">

                        <i class="bi bi-shield-check fs-4"></i>

                        <div>

                            <div class="fw-semibold">
                                Aadhaar Verified Successfully
                            </div>

                            <small>
                                Your Aadhaar verification is complete.
                            </small>

                        </div>

                    </div>

                </div>

            @else

                <form
                    action="{{ route('customer.kyc.aadhaar.verify') }}"
                    method="POST"
                >

                    @csrf


                    <div class="row g-3">


                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                Aadhaar Number
                            </label>

                            <input
                                type="text"
                                name="aadhaar_no"
                                class="form-control form-control-lg"
                                placeholder="Enter Aadhaar number"
                                value="{{ old('aadhaar_no', $kyc->aadhaar_no ?? '') }}"
                                maxlength="12"
                                minlength="12"
                                inputmode="numeric"
                                pattern="[0-9]{12}"
                                required
                            >

                            <small class="text-muted">
                                Enter your 12-digit Aadhaar number.
                            </small>

                        </div>



                        <div class="col-lg-6 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-primary btn-lg w-100 rounded-3"
                            >

                                <i class="bi bi-shield-check me-2"></i>

                                Verify Aadhaar

                            </button>

                        </div>

                    </div>

                </form>

            @endif

        </div>

    </div>



    {{-- =========================================================
        STEP 2 - PAN
    ========================================================== --}}

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4 p-lg-5">


            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">


                <div class="d-flex align-items-center gap-3">

                    <div
                        class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center"
                        style="width:50px;height:50px;"
                    >

                        <i class="bi bi-card-text fs-4"></i>

                    </div>


                    <div>

                        <h5 class="fw-bold mb-1">
                            Step 2 — PAN Verification
                        </h5>

                        <p class="text-muted mb-0">
                            PAN verification is available after Aadhaar.
                        </p>

                    </div>

                </div>



                @if($panStatus === 'approved')

                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">

                        <i class="bi bi-check-circle me-1"></i>

                        Verified

                    </span>

                @elseif($panStatus === 'rejected')

                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                        <i class="bi bi-x-circle me-1"></i>

                        Rejected

                    </span>

                @elseif(!$aadhaarVerified)

                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">

                        <i class="bi bi-lock me-1"></i>

                        Locked

                    </span>

                @else

                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">

                        <i class="bi bi-clock me-1"></i>

                        Pending

                    </span>

                @endif

            </div>



            @if(!$aadhaarVerified)

                <div class="alert alert-light border rounded-3 mb-0">

                    <i class="bi bi-lock me-2"></i>

                    Please complete Aadhaar verification first.

                </div>


            @elseif($panVerified)

                <div class="alert alert-success border-0 rounded-3 mb-0">

                    <div class="d-flex gap-3">

                        <i class="bi bi-shield-check fs-4"></i>

                        <div>

                            <div class="fw-semibold">
                                PAN Verified Successfully
                            </div>

                            <small>
                                Your PAN verification is complete.
                            </small>

                        </div>

                    </div>

                </div>


            @else

                <form
                    action="{{ route('customer.kyc.pan.verify') }}"
                    method="POST"
                >

                    @csrf


                    <div class="row g-3">


                        <div class="col-lg-6">

                            <label class="form-label fw-semibold">
                                PAN Number
                            </label>

                            <input
                                type="text"
                                name="pan_no"
                                class="form-control form-control-lg text-uppercase"
                                placeholder="ABCDE1234F"
                                value="{{ old('pan_no', $kyc->pan_no ?? '') }}"
                                maxlength="10"
                                minlength="10"
                                style="text-transform: uppercase;"
                                required
                            >

                            <small class="text-muted">
                                Enter your 10-character PAN number.
                            </small>

                        </div>



                        <div class="col-lg-6 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-success btn-lg w-100 rounded-3"
                            >

                                <i class="bi bi-shield-check me-2"></i>

                                Verify PAN

                            </button>

                        </div>

                    </div>



                    <div class="alert alert-light border rounded-3 mt-3 mb-0">

                        <small class="text-muted">

                            Your PAN details will be verified through the
                            verification service.

                        </small>

                    </div>

                </form>

            @endif

        </div>

    </div>



    {{-- =========================================================
        KYC COMPLETION
    ========================================================== --}}

    @if($aadhaarVerified && $panVerified)

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-5 text-center">


                <div
                    class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width:70px;height:70px;"
                >

                    <i class="bi bi-shield-check fs-1"></i>

                </div>


                <h4 class="fw-bold">
                    KYC Completed
                </h4>


                <p class="text-muted mb-0">

                    Your Aadhaar and PAN verification have been
                    completed successfully.

                </p>

            </div>

        </div>

    @endif


</div>

@endsection