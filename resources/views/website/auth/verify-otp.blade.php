@extends('layouts.website')

@section('title', 'Verify OTP')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/verify-otp.css') }}">
@endsection

@section('content')

<section class="otp-page">

    <div class="otp-card">

        {{-- LOGO --}}
        <div class="otp-logo">

            <a href="{{ route('home') }}">

                <img
                    src="{{ asset('website/images/logo.png') }}"
                    alt="Logo"
                >

            </a>

        </div>


        {{-- ICON --}}
        <div class="otp-icon">

            <i class="bi bi-shield-lock"></i>

        </div>


        {{-- HEADING --}}
        <div class="otp-heading">

            <span class="otp-badge">
                VERIFY MOBILE
            </span>

            <h1>
                Enter Your
                <span>OTP</span>
            </h1>

            <p>

                We have sent a 6-digit verification code to

                @if(session('otp_mobile'))
                    <strong>
                        +91 {{ session('otp_mobile') }}
                    </strong>
                @elseif(session('register_mobile'))
                    <strong>
                        +91 {{ session('register_mobile') }}
                    </strong>
                @endif

            </p>

        </div>


        {{-- SUCCESS --}}
        @if(session('success'))

            <div class="otp-alert success">

                <i class="bi bi-check-circle-fill"></i>

                <span>
                    {{ session('success') }}
                </span>

            </div>

        @endif


        {{-- ERROR --}}
        @if(session('error'))

            <div class="otp-alert error">

                <i class="bi bi-exclamation-circle-fill"></i>

                <span>
                    {{ session('error') }}
                </span>

            </div>

        @endif


        {{-- DEVELOPMENT OTP --}}
        @if(session('development_otp'))

            <div class="otp-development">

                <i class="bi bi-info-circle"></i>

                <span>
                    Development OTP:
                    <strong>{{ session('development_otp') }}</strong>
                </span>

            </div>

        @endif


        {{-- OTP FORM --}}
        <form
            action="{{ route('verify.otp.post') }}"
            method="POST"
            id="otpForm"
        >

            @csrf

            <input
                type="hidden"
                name="otp"
                id="otpInput"
            >


            {{-- OTP BOXES --}}

            <div class="otp-boxes">

                <input
                    type="text"
                    class="otp-box"
                    maxlength="1"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    autofocus
                >

                <input
                    type="text"
                    class="otp-box"
                    maxlength="1"
                    inputmode="numeric"
                >

                <input
                    type="text"
                    class="otp-box"
                    maxlength="1"
                    inputmode="numeric"
                >

                <input
                    type="text"
                    class="otp-box"
                    maxlength="1"
                    inputmode="numeric"
                >

                <input
                    type="text"
                    class="otp-box"
                    maxlength="1"
                    inputmode="numeric"
                >

                <input
                    type="text"
                    class="otp-box"
                    maxlength="1"
                    inputmode="numeric"
                >

            </div>


            @error('otp')

                <div class="otp-validation-error">

                    <i class="bi bi-exclamation-circle"></i>

                    {{ $message }}

                </div>

            @enderror


            {{-- VERIFY BUTTON --}}

            <button
                type="submit"
                class="otp-submit"
                id="verifyButton"
            >

                <span>
                    Verify & Continue
                </span>

                <i class="bi bi-arrow-right"></i>

            </button>

        </form>


        {{-- RESEND --}}

        <div class="otp-resend">

            <span>
                Didn't receive the code?
            </span>

            <button
                type="button"
                id="resendButton"
                disabled
            >
                Resend OTP
            </button>

            <div class="otp-timer" id="otpTimer">
                Resend in <strong>30</strong>s
            </div>

        </div>


        {{-- CHANGE MOBILE --}}

        <div class="otp-change">

            <a href="{{ route('login') }}">

                <i class="bi bi-arrow-left"></i>

                Change Mobile Number

            </a>

        </div>


        {{-- SECURITY --}}

        <div class="otp-security">

            <i class="bi bi-shield-check"></i>

            <span>
                Your verification is secure and encrypted.
            </span>

        </div>

    </div>

</section>

@endsection


@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const boxes = document.querySelectorAll('.otp-box');

    const otpInput = document.getElementById('otpInput');

    const form = document.getElementById('otpForm');

    const resendButton = document.getElementById('resendButton');

    const timerElement = document.getElementById('otpTimer');

    let timeLeft = 30;


    /*
    |--------------------------------------------------------------------------
    | OTP BOX INPUT
    |--------------------------------------------------------------------------
    */

    boxes.forEach((box, index) => {

        box.addEventListener('input', function (event) {

            let value = event.target.value
                .replace(/[^0-9]/g, '');

            event.target.value = value;

            if (value && index < boxes.length - 1) {

                boxes[index + 1].focus();

            }

            updateOtp();

        });


        /*
        |--------------------------------------------------------------------------
        | BACKSPACE
        |--------------------------------------------------------------------------
        */

        box.addEventListener('keydown', function (event) {

            if (
                event.key === 'Backspace' &&
                !box.value &&
                index > 0
            ) {

                boxes[index - 1].focus();

            }

        });


        /*
        |--------------------------------------------------------------------------
        | PASTE OTP
        |--------------------------------------------------------------------------
        */

        box.addEventListener('paste', function (event) {

            event.preventDefault();

            const pastedData =
                event.clipboardData
                    .getData('text')
                    .replace(/[^0-9]/g, '')
                    .substring(0, 6);


            pastedData.split('').forEach((digit, i) => {

                if (boxes[i]) {

                    boxes[i].value = digit;

                }

            });


            updateOtp();


            if (pastedData.length === 6) {

                boxes[5].focus();

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | UPDATE OTP
    |--------------------------------------------------------------------------
    */

    function updateOtp() {

        let otp = '';

        boxes.forEach(box => {

            otp += box.value;

        });

        otpInput.value = otp;

    }


    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    form.addEventListener('submit', function (event) {

        updateOtp();

        if (otpInput.value.length !== 6) {

            event.preventDefault();

            alert('Please enter the complete 6-digit OTP.');

            return false;

        }

    });


    /*
    |--------------------------------------------------------------------------
    | TIMER
    |--------------------------------------------------------------------------
    */

    function startTimer() {

        timeLeft = 30;

        resendButton.disabled = true;

        timerElement.style.display = 'block';

        const timer = setInterval(function () {

            timeLeft--;

            timerElement.innerHTML =
                'Resend in <strong>' +
                timeLeft +
                '</strong>s';


            if (timeLeft <= 0) {

                clearInterval(timer);

                resendButton.disabled = false;

                timerElement.style.display = 'none';

            }

        }, 1000);

    }


    startTimer();


    /*
    |--------------------------------------------------------------------------
    | RESEND
    |--------------------------------------------------------------------------
    */

    resendButton.addEventListener('click', function () {

        /*
        |--------------------------------------------------------------------------
        | For now reloads the OTP page.
        | Later connect this to a resend OTP endpoint.
        |--------------------------------------------------------------------------
        */

        window.location.reload();

    });

});

</script>

@endsection