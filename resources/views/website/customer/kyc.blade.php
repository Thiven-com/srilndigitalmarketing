@extends('layouts.website')

@section('title', 'KYC Verification')

@section('content')

<div class="customer-kyc-page">

    <div class="container py-5">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <span class="text-uppercase small fw-bold text-success">
                    KYC Verification
                </span>

                <h1 class="fw-bold mb-1">
                    Complete Your KYC
                </h1>

                <p class="text-muted mb-0">
                    Verify your Aadhaar and PAN to complete your account verification.
                </p>
            </div>

            <a href="{{ route('customer.dashboard') }}"
               class="btn btn-light border rounded-3">

                <i class="bi bi-arrow-left me-1"></i>
                Dashboard

            </a>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show rounded-3">

                <i class="bi bi-check-circle me-2"></i>

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- ERROR MESSAGE --}}
        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show rounded-3">

                <i class="bi bi-exclamation-circle me-2"></i>

                {{ session('error') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        {{-- VALIDATION ERRORS --}}
        @if($errors->any())

            <div class="alert alert-danger rounded-3">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- OVERALL KYC STATUS --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <span class="text-muted small">
                            KYC STATUS
                        </span>

                        <h4 class="fw-bold mb-0 mt-1">
                            Account Verification
                        </h4>

                    </div>


                    @if($user->kyc_status == 'approved')

                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                            <i class="bi bi-check-circle me-1"></i>
                            KYC Verified
                        </span>

                    @else

                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                            <i class="bi bi-clock me-1"></i>
                            KYC Pending
                        </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="row g-4">


            {{-- ===================================================== --}}
            {{-- AADHAAR VERIFICATION --}}
            {{-- ===================================================== --}}

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start mb-4">

                            <div>

                                <div class="kyc-icon bg-success-subtle text-success">

                                    <i class="bi bi-person-vcard"></i>

                                </div>

                                <h4 class="fw-bold mt-3 mb-1">
                                    Aadhaar Verification
                                </h4>

                                <p class="text-muted mb-0">
                                    Verify your Aadhaar number using OTP.
                                </p>

                            </div>


                            @if(isset($kyc) && $kyc->aadhar_status === 'approved')

                                <span class="badge bg-success rounded-pill">
                                    Verified
                                </span>

                            @elseif(isset($kyc) && $kyc->aadhar_status === 'rejected')

                                <span class="badge bg-danger rounded-pill">
                                    Rejected
                                </span>

                            @else

                                <span class="badge bg-warning text-dark rounded-pill">
                                    Pending
                                </span>

                            @endif

                        </div>


                        {{-- AADHAAR VERIFIED --}}
                        @if(isset($kyc) && $kyc->aadhar_status === 'approved')

                            <div class="verification-success">

                                <div class="verification-success-icon">

                                    <i class="bi bi-check-circle-fill"></i>

                                </div>

                                <div>

                                    <strong>
                                        Aadhaar Verified
                                    </strong>

                                    <p class="mb-0 text-muted small">

                                        Aadhaar ending with
                                        <strong>
                                            {{ substr($kyc->aadhaar_no, -4) }}
                                        </strong>
                                        has been verified successfully.

                                    </p>

                                </div>

                            </div>

                        @else

                            {{-- AADHAAR FORM --}}
                            <form action="{{ route('customer.kyc.aadhaar.verify') }}"
                                  method="POST">

                                @csrf


                                <div class="mb-3">

                                    <label class="form-label fw-semibold">
                                        Aadhaar Number
                                    </label>

                                    <input type="text"
                                           name="aadhaar_no"
                                           class="form-control form-control-lg rounded-3"
                                           placeholder="Enter 12 digit Aadhaar number"
                                           maxlength="12"
                                           inputmode="numeric"
                                           value="{{ old('aadhaar_no', $kyc->aadhaar_no ?? '') }}">

                                    <small class="text-muted">
                                        Enter your 12 digit Aadhaar number.
                                    </small>

                                </div>


                                <button type="submit"
                                        class="btn btn-success w-100 rounded-3 py-2">

                                    <i class="bi bi-shield-check me-1"></i>

                                    Send Aadhaar OTP

                                </button>

                            </form>


                            {{-- OTP FORM --}}
                            @if(session('aadhaar_otp'))

                                <hr class="my-4">


                                <div class="otp-box">

                                    <div class="text-center mb-3">

                                        <div class="otp-icon">

                                            <i class="bi bi-phone"></i>

                                        </div>

                                        <h5 class="fw-bold mt-2">
                                            Enter Aadhaar OTP
                                        </h5>

                                        <p class="text-muted small mb-0">
                                            OTP has been sent to your Aadhaar registered mobile number.
                                        </p>

                                    </div>


                                    <form action="{{ route('customer.kyc.aadhaar.verify.otp') }}"
                                          method="POST">

                                        @csrf


                                        <div class="mb-3">

                                            <input type="text"
                                                   name="otp"
                                                   class="form-control form-control-lg text-center rounded-3"
                                                   placeholder="Enter OTP"
                                                   maxlength="6"
                                                   inputmode="numeric">

                                        </div>


                                        <button type="submit"
                                                class="btn btn-primary w-100 rounded-3 py-2">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Verify Aadhaar OTP

                                        </button>

                                    </form>

                                </div>

                            @endif

                        @endif

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- PAN VERIFICATION --}}
            {{-- ===================================================== --}}

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start mb-4">

                            <div>

                                <div class="kyc-icon bg-primary-subtle text-primary">

                                    <i class="bi bi-credit-card-2-front"></i>

                                </div>

                                <h4 class="fw-bold mt-3 mb-1">
                                    PAN Verification
                                </h4>

                                <p class="text-muted mb-0">
                                    Verify your PAN after Aadhaar verification.
                                </p>

                            </div>


                            @if(isset($kyc) && $kyc->pan_status === 'approved')

                                <span class="badge bg-success rounded-pill">
                                    Verified
                                </span>

                            @elseif(isset($kyc) && $kyc->pan_status === 'rejected')

                                <span class="badge bg-danger rounded-pill">
                                    Rejected
                                </span>

                            @else

                                <span class="badge bg-warning text-dark rounded-pill">
                                    Pending
                                </span>

                            @endif

                        </div>


                        {{-- PAN VERIFIED --}}
                        @if(isset($kyc) && $kyc->pan_status === 'approved')

                            <div class="verification-success">

                                <div class="verification-success-icon">

                                    <i class="bi bi-check-circle-fill"></i>

                                </div>

                                <div>

                                    <strong>
                                        PAN Verified
                                    </strong>

                                    <p class="mb-0 text-muted small">

                                        PAN ending with
                                        <strong>
                                            {{ substr($kyc->pan_no, -4) }}
                                        </strong>
                                        has been verified successfully.

                                    </p>

                                </div>

                            </div>

                        @else


                            {{-- PAN FORM --}}
                            @if(isset($kyc) && $kyc->aadhar_status === 'approved')

                                <form action="{{ route('customer.kyc.pan.verify') }}"
                                      method="POST">

                                    @csrf


                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">
                                            PAN Number
                                        </label>

                                        <input type="text"
                                               name="pan_no"
                                               class="form-control form-control-lg rounded-3 text-uppercase"
                                               placeholder="Enter PAN number"
                                               maxlength="10"
                                               value="{{ old('pan_no', $kyc->pan_no ?? '') }}">

                                        <small class="text-muted">
                                            Example: ABCDE1234F
                                        </small>

                                    </div>


                                    <button type="submit"
                                            class="btn btn-primary w-100 rounded-3 py-2">

                                        <i class="bi bi-shield-check me-1"></i>

                                        Verify PAN

                                    </button>

                                </form>

                            @else

                                <div class="kyc-disabled-box">

                                    <div class="kyc-disabled-icon">

                                        <i class="bi bi-lock"></i>

                                    </div>

                                    <h6 class="fw-bold">
                                        Aadhaar Verification Required
                                    </h6>

                                    <p class="text-muted small mb-0">

                                        Please complete Aadhaar verification before
                                        verifying your PAN.

                                    </p>

                                </div>

                            @endif

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- KYC INFORMATION --}}
        <div class="card border-0 shadow-sm rounded-4 mt-4">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">
                    Why complete KYC?
                </h5>

                <div class="row g-3">

                    <div class="col-md-4">

                        <div class="d-flex gap-3">

                            <i class="bi bi-shield-check fs-3 text-success"></i>

                            <div>

                                <strong>
                                    Secure Account
                                </strong>

                                <p class="text-muted small mb-0">
                                    Helps keep your account secure.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="d-flex gap-3">

                            <i class="bi bi-check-circle fs-3 text-primary"></i>

                            <div>

                                <strong>
                                    Verified Identity
                                </strong>

                                <p class="text-muted small mb-0">
                                    Confirms your identity.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="d-flex gap-3">

                            <i class="bi bi-wallet2 fs-3 text-warning"></i>

                            <div>

                                <strong>
                                    Account Benefits
                                </strong>

                                <p class="text-muted small mb-0">
                                    Access account features after verification.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

.customer-kyc-page {
    background: #f8f9fa;
    min-height: 100vh;
}

.kyc-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.verification-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 14px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.verification-success-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #dcfce7;
    color: #16a34a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.otp-box {
    background: #f8fafc;
    border-radius: 15px;
    padding: 20px;
}

.otp-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #e0e7ff;
    color: #4f46e5;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.kyc-disabled-box {
    background: #f8f9fa;
    border: 1px dashed #ced4da;
    border-radius: 14px;
    padding: 30px 20px;
    text-align: center;
}

.kyc-disabled-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 12px;
}

.form-control:focus {
    box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
}

@media (max-width: 767px) {

    .customer-kyc-page .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .customer-kyc-page h1 {
        font-size: 26px;
    }

}

</style>

@endsection