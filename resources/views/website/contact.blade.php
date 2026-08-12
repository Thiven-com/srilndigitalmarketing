@extends('layouts.website')

@section('title', 'Contact Us')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/contact.css') }}">
@endsection

@section('content')

{{-- =========================================================
    CONTACT HERO
========================================================= --}}

<section class="contact-hero">

    <div class="contact-container">

        <span class="contact-badge">
            <i class="bi bi-chat-dots-fill"></i>
            CONTACT US
        </span>

        <h1>
            We're Here To
            <span>Help You.</span>
        </h1>

        <p>
            Have a question about our packages or platform?
            Send us a message and our team will be happy to help.
        </p>

    </div>

</section>


{{-- =========================================================
    CONTACT CONTENT
========================================================= --}}

<section class="contact-section">

    <div class="contact-container">

        <div class="contact-grid">


            {{-- =================================================
                LEFT INFORMATION
            ================================================== --}}

            <div class="contact-info">

                <span class="contact-small-title">
                    GET IN TOUCH
                </span>

                <h2>
                    Let's start a
                    <strong>conversation.</strong>
                </h2>

                <p class="contact-description">
                    Whether you need help understanding a package,
                    have a general question or need assistance with
                    your account, we're here to support you.
                </p>


                {{-- EMAIL --}}

                <div class="contact-info-card">

                    <div class="contact-info-icon">
                        <i class="bi bi-envelope"></i>
                    </div>

                    <div>
                        <span>Email Us</span>

                        <a href="mailto:support@example.com">
                            support@example.com
                        </a>
                    </div>

                </div>


                {{-- PHONE --}}

                <div class="contact-info-card">

                    <div class="contact-info-icon">
                        <i class="bi bi-telephone"></i>
                    </div>

                    <div>
                        <span>Call Us</span>

                        <a href="tel:+919999999999">
                            +91 99999 99999
                        </a>
                    </div>

                </div>


                {{-- OFFICE --}}

                <div class="contact-info-card">

                    <div class="contact-info-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>

                    <div>
                        <span>Our Office</span>

                        <p>
                            Your Office Address,<br>
                            City, State - 000000
                        </p>
                    </div>

                </div>


                {{-- WORKING HOURS --}}

                <div class="contact-info-card">

                    <div class="contact-info-icon">
                        <i class="bi bi-clock"></i>
                    </div>

                    <div>
                        <span>Working Hours</span>

                        <p>
                            Monday - Saturday<br>
                            9:00 AM - 6:00 PM
                        </p>
                    </div>

                </div>


                {{-- SOCIAL --}}

                <div class="contact-social">

                    <span>
                        FOLLOW US
                    </span>

                    <div>

                        <a href="#">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="#">
                            <i class="bi bi-instagram"></i>
                        </a>

                        <a href="#">
                            <i class="bi bi-youtube"></i>
                        </a>

                        <a href="#">
                            <i class="bi bi-whatsapp"></i>
                        </a>

                    </div>

                </div>

            </div>


            {{-- =================================================
                CONTACT FORM
            ================================================== --}}

            <div class="contact-form-wrapper">

                <div class="contact-form-header">

                    <div>

                        <span>
                            SEND A MESSAGE
                        </span>

                        <h3>
                            How can we help?
                        </h3>

                    </div>

                    <div class="contact-form-header-icon">
                        <i class="bi bi-send"></i>
                    </div>

                </div>


                @if(session('success'))

                    <div class="contact-success">

                        <i class="bi bi-check-circle-fill"></i>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                @endif


                @if($errors->any())

                    <div class="contact-error">

                        <i class="bi bi-exclamation-circle-fill"></i>

                        <div>

                            @foreach($errors->all() as $error)

                                <div>
                                    {{ $error }}
                                </div>

                            @endforeach

                        </div>

                    </div>

                @endif


                <form
                    action="{{ route('contact.store') }}"
                    method="POST"
                >

                    @csrf


                    {{-- NAME + MOBILE --}}

                    <div class="contact-form-row">

                        <div class="contact-field">

                            <label>
                                Your Name
                                <span>*</span>
                            </label>

                            <div class="contact-input">

                                <i class="bi bi-person"></i>

                                <input
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter your name"
                                    required
                                >

                            </div>

                        </div>


                        <div class="contact-field">

                            <label>
                                Mobile Number
                                <span>*</span>
                            </label>

                            <div class="contact-input">

                                <i class="bi bi-phone"></i>

                                <input
                                    type="text"
                                    name="mobile"
                                    value="{{ old('mobile') }}"
                                    placeholder="Enter mobile number"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    {{-- EMAIL + SUBJECT --}}

                    <div class="contact-form-row">

                        <div class="contact-field">

                            <label>
                                Email Address
                            </label>

                            <div class="contact-input">

                                <i class="bi bi-envelope"></i>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter your email"
                                >

                            </div>

                        </div>


                        <div class="contact-field">

                            <label>
                                Subject
                            </label>

                            <div class="contact-input">

                                <i class="bi bi-bookmark"></i>

                                <input
                                    type="text"
                                    name="subject"
                                    value="{{ old('subject') }}"
                                    placeholder="What is this about?"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- MESSAGE --}}

                    <div class="contact-field">

                        <label>
                            Message
                            <span>*</span>
                        </label>

                        <div class="contact-input contact-textarea">

                            <i class="bi bi-chat-left-text"></i>

                            <textarea
                                name="message"
                                rows="6"
                                placeholder="Write your message..."
                                required
                            >{{ old('message') }}</textarea>

                        </div>

                    </div>


                    {{-- SUBMIT --}}

                    <button
                        type="submit"
                        class="contact-submit"
                    >

                        Send Message

                        <i class="bi bi-arrow-right"></i>

                    </button>


                    <p class="contact-form-note">

                        <i class="bi bi-shield-check"></i>

                        Your information is safe and will only be
                        used to respond to your enquiry.

                    </p>

                </form>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
    FAQ CTA
========================================================= --}}

<section class="contact-bottom">

    <div class="contact-container">

        <div class="contact-bottom-box">

            <div class="contact-bottom-icon">
                <i class="bi bi-question-circle"></i>
            </div>

            <div>

                <span>
                    HAVE A QUICK QUESTION?
                </span>

                <h2>
                    Check our frequently asked questions.
                </h2>

            </div>

            <a href="{{ route('faq') }}">

                View FAQ

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>

    </div>

</section>

@endsection