@extends('layouts.website')

@section('title', 'Bank Verification')

@section('content')

    <div class="customer-bank-page">

        <div class="container py-5">

            {{-- =========================================================
            PAGE HEADER
            ========================================================== --}}

            <div class="d-flex justify-content-between align-items-center mb-4 page-header">

                <div>
                    <span class="text-uppercase small fw-bold text-success">
                        Bank Verification
                    </span>

                    <h1 class="fw-bold mb-1">
                        Verify Your Bank Account
                    </h1>

                    <p class="text-muted mb-0">
                        Add and verify your bank account and UPI details securely.
                    </p>
                </div>

                <a href="{{ route('customer.dashboard') }}" class="btn btn-light border rounded-3 dashboard-btn">

                    <i class="bi bi-arrow-left me-1"></i>
                    Dashboard

                </a>

            </div>


            {{-- =========================================================
            SESSION SUCCESS
            ========================================================== --}}

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show rounded-3">

                    <i class="bi bi-check-circle me-2"></i>

                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- =========================================================
            SESSION ERROR
            ========================================================== --}}

            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show rounded-3">

                    <i class="bi bi-exclamation-circle me-2"></i>

                    {{ session('error') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            {{-- =========================================================
            VALIDATION ERRORS
            ========================================================== --}}

            @if($errors->any())

                <div class="alert alert-danger rounded-3">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =========================================================
            OVERALL BANK STATUS
            ========================================================== --}}

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <span class="text-muted small">
                                BANK STATUS
                            </span>

                            <h4 class="fw-bold mb-0 mt-1">
                                Account Verification
                            </h4>

                        </div>


                        @if(isset($bankAccount) && $bankAccount->bank_status === 'approved')

                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">

                                <i class="bi bi-check-circle me-1"></i>

                                Bank Verified

                            </span>

                        @elseif(isset($bankAccount) && $bankAccount->bank_status === 'rejected')

                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                                <i class="bi bi-x-circle me-1"></i>

                                Bank Rejected

                            </span>

                        @else

                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">

                                <i class="bi bi-clock me-1"></i>

                                Bank Pending

                            </span>

                        @endif

                    </div>

                </div>

            </div>


            {{-- =========================================================
            MAIN ROW
            ========================================================== --}}

            <div class="row g-4">


                {{-- =====================================================
                BANK ACCOUNT
                ====================================================== --}}

                <div class="col-lg-7">

                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <div class="card-body p-4">

                            {{-- HEADER --}}

                            <div class="d-flex justify-content-between align-items-start mb-4">

                                <div>

                                    <div class="bank-icon bg-success-subtle text-success">

                                        <i class="bi bi-bank"></i>

                                    </div>

                                    <h4 class="fw-bold mt-3 mb-1">
                                        Bank Account
                                    </h4>

                                    <p class="text-muted mb-0">
                                        Verify your bank account using your account number and IFSC.
                                    </p>

                                </div>


                                @if(isset($bankAccount) && $bankAccount->bank_status === 'approved')

                                    <span class="badge bg-success rounded-pill">
                                        Verified
                                    </span>

                                @elseif(isset($bankAccount) && $bankAccount->bank_status === 'rejected')

                                    <span class="badge bg-danger rounded-pill">
                                        Rejected
                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark rounded-pill">
                                        Pending
                                    </span>

                                @endif

                            </div>


                            {{-- =================================================
                            VERIFIED BANK ACCOUNT
                            ================================================== --}}

                            @if(isset($bankAccount) && $bankAccount->bank_status === 'approved')

                                <div class="verification-success">

                                    <div class="verification-success-icon">

                                        <i class="bi bi-check-circle-fill"></i>

                                    </div>

                                    <div class="flex-grow-1">

                                        <strong>
                                            Bank Account Verified
                                        </strong>

                                        <p class="mb-1 text-muted small">

                                            Account ending with

                                            <strong>
                                                {{ substr($bankAccount->account_number, -4) }}
                                            </strong>

                                            has been verified successfully.

                                        </p>

                                        <div class="verified-bank-info">

                                            <span>
                                                <i class="bi bi-bank me-1"></i>
                                                {{ $bankAccount->bank_name ?? '-' }}
                                            </span>

                                            <span>
                                                <i class="bi bi-person me-1"></i>
                                                {{ $bankAccount->account_name ?? '-' }}
                                            </span>

                                            <span>
                                                <i class="bi bi-geo-alt me-1"></i>
                                                {{ $bankAccount->branch_name ?? '-' }}
                                            </span>

                                        </div>

                                    </div>

                                </div>


                            @else


                                {{-- =================================================
                                BANK VERIFICATION FORM
                                ================================================== --}}

                                <form id="bankVerificationForm">

                                    @csrf


                                    {{-- ACCOUNT NUMBER --}}

                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">

                                            Account Number

                                            <span class="text-danger">*</span>

                                        </label>

                                        <input type="text" name="account_number" id="account_number"
                                            class="form-control form-control-lg rounded-3" placeholder="Enter account number"
                                            inputmode="numeric" autocomplete="off" maxlength="20" required>

                                    </div>


                                    {{-- CONFIRM ACCOUNT NUMBER --}}

                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">

                                            Confirm Account Number

                                            <span class="text-danger">*</span>

                                        </label>

                                        <input type="text" name="account_number_confirmation" id="account_number_confirmation"
                                            class="form-control form-control-lg rounded-3" placeholder="Re-enter account number"
                                            inputmode="numeric" autocomplete="off" maxlength="20" required>

                                    </div>


                                    <div class="row">


                                        {{-- ACCOUNT TYPE --}}

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">

                                                Account Type

                                                <span class="text-danger">*</span>

                                            </label>

                                            <select name="account_type" id="account_type"
                                                class="form-select form-select-lg rounded-3" required>

                                                <option value="">
                                                    Select Account Type
                                                </option>

                                                <option value="savings">
                                                    Savings
                                                </option>

                                                <option value="current">
                                                    Current
                                                </option>

                                            </select>

                                        </div>


                                        {{-- IFSC --}}

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">

                                                IFSC Code

                                                <span class="text-danger">*</span>

                                            </label>

                                            <input type="text" name="ifsc" id="ifsc"
                                                class="form-control form-control-lg rounded-3 text-uppercase"
                                                placeholder="Example: SBIN0001234" maxlength="11" autocomplete="off" required>

                                        </div>

                                    </div>


                                    {{-- INFORMATION --}}

                                    <div class="alert alert-info rounded-3 small mb-3">

                                        <i class="bi bi-info-circle me-1"></i>

                                        Your account holder name, bank name and branch will
                                        be automatically retrieved from the bank verification service.

                                    </div>


                                    {{-- VERIFY BUTTON --}}

                                    <button type="submit" id="verifyBankBtn" class="btn btn-success w-100 rounded-3 py-2">

                                        <i class="bi bi-shield-check me-1"></i>

                                        Verify Bank Account

                                    </button>

                                </form>


                                {{-- =================================================
                                BANK VERIFICATION RESULT
                                ================================================== --}}

                                <div id="bankVerificationResult" class="verification-result d-none mt-4">

                                    <div class="result-header">

                                        <div class="result-success-icon">

                                            <i class="bi bi-check-lg"></i>

                                        </div>

                                        <div>

                                            <h6 class="fw-bold mb-1">
                                                Bank Account Verified
                                            </h6>

                                            <p class="text-muted small mb-0">
                                                The following details were returned by the bank.
                                            </p>

                                        </div>

                                    </div>


                                    <div class="result-details">

                                        <div class="result-item">

                                            <span>
                                                Account Holder
                                            </span>

                                            <strong id="verifiedAccountName">
                                                -
                                            </strong>

                                        </div>


                                        <div class="result-item">

                                            <span>
                                                Account Number
                                            </span>

                                            <strong id="verifiedAccountNumber">
                                                -
                                            </strong>

                                        </div>


                                        <div class="result-item">

                                            <span>
                                                Bank Name
                                            </span>

                                            <strong id="verifiedBankName">
                                                -
                                            </strong>

                                        </div>


                                        <div class="result-item">

                                            <span>
                                                IFSC
                                            </span>

                                            <strong id="verifiedIfsc">
                                                -
                                            </strong>

                                        </div>


                                        <div class="result-item">

                                            <span>
                                                Branch
                                            </span>

                                            <strong id="verifiedBranchName">
                                                -
                                            </strong>

                                        </div>


                                        <div class="result-item">

                                            <span>
                                                Account Status
                                            </span>

                                            <strong id="verifiedAccountStatus">
                                                -
                                            </strong>

                                        </div>

                                    </div>


                                    <button type="button" id="saveBankBtn" class="btn btn-success w-100 rounded-3 py-2 mt-3">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Confirm & Save Bank Account

                                    </button>

                                </div>


                                {{-- BANK ERROR --}}

                                <div id="bankVerificationError" class="alert alert-danger rounded-3 d-none mt-3">

                                    <i class="bi bi-exclamation-circle me-1"></i>

                                    <span id="bankErrorMessage"></span>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                UPI
                ====================================================== --}}

                <div class="col-lg-5">

                    <div class="card border-0 shadow-sm rounded-4 h-100">

                        <div class="card-body p-4">


                            {{-- HEADER --}}

                            <div class="d-flex justify-content-between align-items-start mb-4">

                                <div>

                                    <div class="bank-icon bg-primary-subtle text-primary">

                                        <i class="bi bi-phone"></i>

                                    </div>

                                    <h4 class="fw-bold mt-3 mb-1">
                                        UPI Verification
                                    </h4>

                                    <p class="text-muted mb-0">
                                        Verify your UPI ID for account transactions.
                                    </p>

                                </div>


                                @if(isset($bankAccount) && $bankAccount->upi_status === 'approved')

                                    <span class="badge bg-success rounded-pill">
                                        Verified
                                    </span>

                                @elseif(isset($bankAccount) && $bankAccount->upi_status === 'rejected')

                                    <span class="badge bg-danger rounded-pill">
                                        Rejected
                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark rounded-pill">
                                        Pending
                                    </span>

                                @endif

                            </div>


                            {{-- =================================================
                            VERIFIED UPI
                            ================================================== --}}

                            @if(isset($bankAccount) && $bankAccount->upi_status === 'approved')

                                <div class="verification-success">

                                    <div class="verification-success-icon">

                                        <i class="bi bi-check-circle-fill"></i>

                                    </div>

                                    <div class="flex-grow-1">

                                        <strong>
                                            UPI Verified
                                        </strong>

                                        <p class="mb-1 text-muted small">

                                            UPI ID

                                            <strong>
                                                {{ $bankAccount->upi_id }}
                                            </strong>

                                            has been verified successfully.

                                        </p>

                                    </div>

                                </div>


                            @else


                                {{-- =================================================
                                UPI FORM
                                ================================================== --}}

                                <form id="upiVerificationForm">

                                    @csrf

                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">

                                            UPI ID

                                            <span class="text-danger">*</span>

                                        </label>

                                        <input type="text" name="upi_id" id="upi_id"
                                            class="form-control form-control-lg rounded-3" placeholder="example@upi"
                                            autocomplete="off" required>

                                        <small class="text-muted">
                                            Example: yourname@oksbi
                                        </small>

                                    </div>


                                    <button type="submit" id="verifyUpiBtn" class="btn btn-primary w-100 rounded-3 py-2">

                                        <i class="bi bi-shield-check me-1"></i>

                                        Verify UPI

                                    </button>

                                </form>


                                {{-- UPI RESULT --}}

                                <div id="upiVerificationResult" class="verification-result d-none mt-4">

                                    <div class="result-header">

                                        <div class="result-success-icon">

                                            <i class="bi bi-check-lg"></i>

                                        </div>

                                        <div>

                                            <h6 class="fw-bold mb-1">
                                                UPI Verified
                                            </h6>

                                            <p class="text-muted small mb-0">
                                                UPI details verified successfully.
                                            </p>

                                        </div>

                                    </div>


                                    <div class="result-details">

                                        <div class="result-item">

                                            <span>
                                                UPI ID
                                            </span>

                                            <strong id="verifiedUpiId">
                                                -
                                            </strong>

                                        </div>


                                        <div class="result-item">

                                            <span>
                                                Account Name
                                            </span>

                                            <strong id="verifiedUpiName">
                                                -
                                            </strong>

                                        </div>

                                    </div>


                                    <button type="button" id="saveUpiBtn" class="btn btn-primary w-100 rounded-3 py-2 mt-3">

                                        <i class="bi bi-check-circle me-1"></i>

                                        Confirm & Save UPI

                                    </button>

                                </div>


                                {{-- UPI ERROR --}}

                                <div id="upiVerificationError" class="alert alert-danger rounded-3 d-none mt-3">

                                    <i class="bi bi-exclamation-circle me-1"></i>

                                    <span id="upiErrorMessage"></span>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
            BANK INFORMATION
            ========================================================== --}}

            <div class="card border-0 shadow-sm rounded-4 mt-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Why verify your bank account?
                    </h5>

                    <div class="row g-3">


                        <div class="col-md-4">

                            <div class="d-flex gap-3">

                                <i class="bi bi-shield-check fs-3 text-success"></i>

                                <div>

                                    <strong>
                                        Secure Payments
                                    </strong>

                                    <p class="text-muted small mb-0">
                                        Keep your banking information verified and secure.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="d-flex gap-3">

                                <i class="bi bi-bank fs-3 text-primary"></i>

                                <div>

                                    <strong>
                                        Bank Verification
                                    </strong>

                                    <p class="text-muted small mb-0">
                                        Verify your account before withdrawals.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="d-flex gap-3">

                                <i class="bi bi-wallet2 fs-3 text-warning"></i>

                                <div>

                                    <strong>
                                        Easy Withdrawals
                                    </strong>

                                    <p class="text-muted small mb-0">
                                        Use your verified bank account for withdrawals.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =============================================================
    STYLES
    ============================================================== --}}

    <style>
        .customer-bank-page {
            background: #f8f9fa;
            min-height: 100vh;
        }

        .customer-bank-page .card {
            background: #ffffff;
        }

        .bank-icon {
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
            align-items: flex-start;
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

        .verified-bank-info {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .verified-bank-info span {
            background: #ffffff;
            border: 1px solid #d1fae5;
            border-radius: 8px;

            padding: 6px 10px;

            font-size: 12px;
            color: #475569;
        }

        .verification-result {
            background: #f0fdf4;

            border: 1px solid #86efac;

            border-radius: 14px;

            padding: 18px;
        }

        .result-header {
            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 18px;
        }

        .result-success-icon {
            width: 42px;
            height: 42px;

            border-radius: 50%;

            background: #22c55e;
            color: #ffffff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;

            flex-shrink: 0;
        }

        .result-details {
            background: #ffffff;

            border: 1px solid #dcfce7;

            border-radius: 12px;

            overflow: hidden;
        }

        .result-item {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            padding: 12px 14px;

            border-bottom: 1px solid #f1f5f9;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-item span {
            color: #64748b;
            font-size: 13px;
        }

        .result-item strong {
            color: #1e293b;
            font-size: 14px;
            text-align: right;
        }

        .form-control,
        .form-select {
            border-color: #dee2e6;
        }

        .form-control:focus,
        .form-select:focus {

            border-color: #198754;

            box-shadow:
                0 0 0 .2rem rgba(25, 135, 84, .12);
        }

        .btn {
            transition: all .2s ease;
        }

        .btn:disabled {
            cursor: not-allowed;
            opacity: .75;
        }

        .dashboard-btn {
            white-space: nowrap;
        }

        @media (max-width: 991px) {

            .page-header {
                align-items: flex-start !important;
                gap: 20px;
            }

        }

        @media (max-width: 767px) {

            .customer-bank-page .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            .customer-bank-page h1 {
                font-size: 26px;
            }

            .page-header {
                flex-direction: column;
            }

            .dashboard-btn {
                width: 100%;
            }

            .result-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .result-item strong {
                text-align: left;
            }

            .verified-bank-info {
                flex-direction: column;
            }

            .verified-bank-info span {
                width: 100%;
            }

        }
    </style>


    {{-- =============================================================
    JAVASCRIPT
    ============================================================== --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>

        $(document).ready(function () {


            /*
            |--------------------------------------------------------------------------
            | BANK VERIFICATION
            |--------------------------------------------------------------------------
            */

            let verifiedBankData = null;


            $('#bankVerificationForm').on('submit', function (e) {

                e.preventDefault();


                let form = $(this);

                let button = $('#verifyBankBtn');


                let accountNumber =
                    $('#account_number').val().trim();

                let confirmAccountNumber =
                    $('#account_number_confirmation').val().trim();

                let ifsc =
                    $('#ifsc').val().trim().toUpperCase();


                /*
                |--------------------------------------------------------------------------
                | Client-side validation
                |--------------------------------------------------------------------------
                */

                if (accountNumber !== confirmAccountNumber) {

                    showBankError(
                        'Account Number and Confirm Account Number must match.'
                    );

                    return;
                }


                if (ifsc.length !== 11) {

                    showBankError(
                        'Please enter a valid 11-character IFSC code.'
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Reset UI
                |--------------------------------------------------------------------------
                */

                hideBankError();

                $('#bankVerificationResult')
                    .addClass('d-none');


                /*
                |--------------------------------------------------------------------------
                | Loading
                |--------------------------------------------------------------------------
                */

                button.prop('disabled', true);

                button.html(`
                <span class="spinner-border spinner-border-sm me-2"></span>
                Verifying Bank...
            `);


                /*
                |--------------------------------------------------------------------------
                | AJAX
                |--------------------------------------------------------------------------
                */

                $.ajax({

                    url: "{{ route('customer.kyc.bank.verify') }}",

                    type: "POST",

                    data: form.serialize(),

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },


                    success: function (response) {

                        if (response.success == 1) {


                            /*
                            |--------------------------------------------------------------------------
                            | Store response temporarily
                            |--------------------------------------------------------------------------
                            */

                            verifiedBankData = {

                                account:
                                    response.account || accountNumber,

                                ifsc:
                                    response.ifsc || ifsc,

                                account_name:
                                    response.account_name || '-',

                                bank_name:
                                    response.bank_name || '-',

                                branch_name:
                                    response.branch_name || '-',

                                account_status:
                                    response.account_status || '-',

                                account_type:
                                    $('#account_type').val()

                            };


                            /*
                            |--------------------------------------------------------------------------
                            | Display response
                            |--------------------------------------------------------------------------
                            */

                            $('#verifiedAccountName')
                                .text(verifiedBankData.account_name);

                            $('#verifiedAccountNumber')
                                .text(maskAccountNumber(
                                    verifiedBankData.account
                                ));

                            $('#verifiedBankName')
                                .text(verifiedBankData.bank_name);

                            $('#verifiedIfsc')
                                .text(verifiedBankData.ifsc);

                            $('#verifiedBranchName')
                                .text(verifiedBankData.branch_name);

                            $('#verifiedAccountStatus')
                                .text(verifiedBankData.account_status);


                            /*
                            |--------------------------------------------------------------------------
                            | Show result
                            |--------------------------------------------------------------------------
                            */

                            $('#bankVerificationResult')
                                .removeClass('d-none');


                            /*
                            |--------------------------------------------------------------------------
                            | Scroll to result
                            |--------------------------------------------------------------------------
                            */

                            $('html, body').animate({

                                scrollTop:
                                    $('#bankVerificationResult').offset().top - 120

                            }, 400);


                        } else {

                            showBankError(
                                response.message ||
                                'Bank verification failed.'
                            );

                        }

                    },


                    error: function (xhr) {

                        let message =
                            'Bank verification failed. Please try again.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Validation errors
                        |--------------------------------------------------------------------------
                        */

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            let errors =
                                xhr.responseJSON.errors;

                            let firstError = null;

                            Object.keys(errors).forEach(function (key) {

                                if (!firstError && errors[key].length) {

                                    firstError =
                                        errors[key][0];

                                }

                            });


                            if (firstError) {

                                message = firstError;

                            }

                        }


                        showBankError(message);

                    },


                    complete: function () {

                        button.prop('disabled', false);

                        button.html(`
                        <i class="bi bi-shield-check me-1"></i>
                        Verify Bank Account
                    `);

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | SAVE VERIFIED BANK
            |--------------------------------------------------------------------------
            |
            | This uses your existing customer.bank.store route.
            |
            */

            $('#saveBankBtn').on('click', function () {

                if (!verifiedBankData) {

                    showBankError(
                        'Please verify your bank account first.'
                    );

                    return;
                }


                let button = $(this);

                button.prop('disabled', true);

                button.html(`
                <span class="spinner-border spinner-border-sm me-2"></span>
                Saving...
            `);


                /*
                |--------------------------------------------------------------------------
                | Create temporary form
                |--------------------------------------------------------------------------
                */

                let form = $('<form>', {

                    method: 'POST',

                    action: "{{ route('customer.bank.store') }}"

                });


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: "{{ csrf_token() }}"
                    })
                );


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'account_number',
                        value: verifiedBankData.account
                    })
                );


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'account_number_confirmation',
                        value: verifiedBankData.account
                    })
                );


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'ifsc_code',
                        value: verifiedBankData.ifsc
                    })
                );


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'account_name',
                        value: verifiedBankData.account_name
                    })
                );


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'bank_name',
                        value: verifiedBankData.bank_name
                    })
                );


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'branch_name',
                        value: verifiedBankData.branch_name
                    })
                );


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'account_type',
                        value: verifiedBankData.account_type
                    })
                );


                $('body').append(form);

                form.submit();

            });


            /*
            |--------------------------------------------------------------------------
            | UPI VERIFICATION
            |--------------------------------------------------------------------------
            */

            let verifiedUpiData = null;


            $('#upiVerificationForm').on('submit', function (e) {

                e.preventDefault();


                let form = $(this);

                let button = $('#verifyUpiBtn');


                let upiId =
                    $('#upi_id').val().trim();


                if (!upiId) {

                    showUpiError(
                        'Please enter your UPI ID.'
                    );

                    return;
                }


                hideUpiError();

                $('#upiVerificationResult')
                    .addClass('d-none');


                button.prop('disabled', true);

                button.html(`
                <span class="spinner-border spinner-border-sm me-2"></span>
                Verifying UPI...
            `);


                $.ajax({

                    url: "{{ route('customer.kyc.upi.verify') }}",

                    type: "POST",

                    data: form.serialize(),

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },


                    success: function (response) {

                        if (response.success == 1) {


                            verifiedUpiData = {

                                upi_id:
                                    response.upi_id || upiId,

                                name:
                                    response.name || '-'

                            };


                            $('#verifiedUpiId')
                                .text(verifiedUpiData.upi_id);

                            $('#verifiedUpiName')
                                .text(verifiedUpiData.name);


                            $('#upiVerificationResult')
                                .removeClass('d-none');


                            $('html, body').animate({

                                scrollTop:
                                    $('#upiVerificationResult').offset().top - 120

                            }, 400);


                        } else {

                            showUpiError(
                                response.message ||
                                'UPI verification failed.'
                            );

                        }

                    },


                    error: function (xhr) {

                        let message =
                            'UPI verification failed. Please try again.';


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }


                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.errors
                        ) {

                            let errors =
                                xhr.responseJSON.errors;

                            let firstError = null;

                            Object.keys(errors).forEach(function (key) {

                                if (!firstError && errors[key].length) {

                                    firstError =
                                        errors[key][0];

                                }

                            });


                            if (firstError) {

                                message = firstError;

                            }

                        }


                        showUpiError(message);

                    },


                    complete: function () {

                        button.prop('disabled', false);

                        button.html(`
                        <i class="bi bi-shield-check me-1"></i>
                        Verify UPI
                    `);

                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | SAVE VERIFIED UPI
            |--------------------------------------------------------------------------
            */

            $('#saveUpiBtn').on('click', function () {

                if (!verifiedUpiData) {

                    showUpiError(
                        'Please verify your UPI ID first.'
                    );

                    return;
                }


                let button = $(this);

                button.prop('disabled', true);

                button.html(`
                <span class="spinner-border spinner-border-sm me-2"></span>
                Saving...
            `);


                let form = $('<form>', {

                    method: 'POST',

                    action: "{{ route('customer.bank.upi.store') }}"

                });


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: "{{ csrf_token() }}"
                    })
                );


                form.append(
                    $('<input>', {
                        type: 'hidden',
                        name: 'upi_id',
                        value: verifiedUpiData.upi_id
                    })
                );


                $('body').append(form);

                form.submit();

            });


            /*
            |--------------------------------------------------------------------------
            | HELPER: MASK ACCOUNT NUMBER
            |--------------------------------------------------------------------------
            */

            function maskAccountNumber(account) {

                if (!account) {
                    return '-';
                }


                let value = String(account);


                if (value.length <= 4) {
                    return value;
                }


                return 'XXXXXX' +
                    value.slice(-4);

            }


            /*
            |--------------------------------------------------------------------------
            | HELPER: BANK ERROR
            |--------------------------------------------------------------------------
            */

            function showBankError(message) {

                $('#bankErrorMessage')
                    .text(message);

                $('#bankVerificationError')
                    .removeClass('d-none');

            }


            function hideBankError() {

                $('#bankVerificationError')
                    .addClass('d-none');

                $('#bankErrorMessage')
                    .text('');

            }


            /*
            |--------------------------------------------------------------------------
            | HELPER: UPI ERROR
            |--------------------------------------------------------------------------
            */

            function showUpiError(message) {

                $('#upiErrorMessage')
                    .text(message);

                $('#upiVerificationError')
                    .removeClass('d-none');

            }


            function hideUpiError() {

                $('#upiVerificationError')
                    .addClass('d-none');

                $('#upiErrorMessage')
                    .text('');

            }


            /*
            |--------------------------------------------------------------------------
            | IFSC AUTO UPPERCASE
            |--------------------------------------------------------------------------
            */

            $('#ifsc').on('input', function () {

                this.value =
                    this.value.toUpperCase();

            });


            /*
            |--------------------------------------------------------------------------
            | ACCOUNT NUMBER ONLY DIGITS
            |--------------------------------------------------------------------------
            */

            $('#account_number, #account_number_confirmation')
                .on('input', function () {

                    this.value =
                        this.value.replace(/\D/g, '');

                });

        });

    </script>

@endsection