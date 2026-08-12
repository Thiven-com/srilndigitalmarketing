@extends('layouts.website')

@section('title', 'About Us')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/about.css') }}">
@endsection

@section('content')

    {{-- =========================================================
    HERO
    ========================================================= --}}

    <section class="about-hero">

        <div class="about-container">

            <div class="about-hero-content">

                <span class="about-badge">
                    <i class="bi bi-stars"></i>
                    ABOUT US
                </span>

                <h1>
                    Building Opportunities.
                    <span>Growing Together.</span>
                </h1>

                <p>
                    We are building a community-driven platform designed
                    to create opportunities, encourage growth and help
                    every member move forward with confidence.
                </p>

                <div class="about-hero-buttons">

                    <a href="{{ route('login') }}" class="about-primary-btn">
                        Get Started
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    <a href="{{ route('home') }}" class="about-secondary-btn">
                        Explore Packages
                    </a>

                </div>

            </div>

            <div class="about-hero-visual">

                <div class="about-circle circle-one"></div>
                <div class="about-circle circle-two"></div>

                <div class="about-main-card">

                    <div class="about-card-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <h3>
                        One Community
                    </h3>

                    <p>
                        One platform focused on growth,
                        opportunity and collaboration.
                    </p>

                    <div class="about-mini-stats">

                        <div>
                            <strong>4</strong>
                            <span>Packages</span>
                        </div>

                        <div>
                            <strong>6</strong>
                            <span>Levels</span>
                        </div>

                        <div>
                            <strong>∞</strong>
                            <span>Growth</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    INTRODUCTION
    ========================================================= --}}

    <section class="about-intro">

        <div class="about-container">

            <div class="about-section-heading">

                <span>
                    WHO WE ARE
                </span>

                <h2>
                    A platform designed
                    <strong>for growth</strong>
                </h2>

                <p>
                    Our platform brings together a structured package
                    system, community participation and rewarding
                    opportunities in one simple experience.
                </p>

            </div>


            <div class="about-intro-grid">

                <div class="about-intro-card">

                    <div class="about-number">
                        01
                    </div>

                    <div class="about-card-content">

                        <div class="about-icon">
                            <i class="bi bi-bullseye"></i>
                        </div>

                        <h3>
                            Our Mission
                        </h3>

                        <p>
                            To create a simple and transparent platform
                            where people can discover opportunities,
                            participate in a growing community and
                            work towards their goals.
                        </p>

                    </div>

                </div>


                <div class="about-intro-card">

                    <div class="about-number">
                        02
                    </div>

                    <div class="about-card-content">

                        <div class="about-icon">
                            <i class="bi bi-eye"></i>
                        </div>

                        <h3>
                            Our Vision
                        </h3>

                        <p>
                            To build a strong community where every
                            participant can grow through consistency,
                            collaboration and shared opportunities.
                        </p>

                    </div>

                </div>


                <div class="about-intro-card">

                    <div class="about-number">
                        03
                    </div>

                    <div class="about-card-content">

                        <div class="about-icon">
                            <i class="bi bi-heart"></i>
                        </div>

                        <h3>
                            Our Values
                        </h3>

                        <p>
                            We believe in simplicity, transparency,
                            trust, community and long-term relationships.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    WHY CHOOSE US
    ========================================================= --}}

    <section class="about-why">

        <div class="about-container">

            <div class="about-why-grid">

                <div class="about-why-content">

                    <span class="about-label">
                        WHY CHOOSE US
                    </span>

                    <h2>
                        Everything you need
                        <span>in one place.</span>
                    </h2>

                    <p>
                        We have designed the platform to keep the
                        experience simple and easy to understand,
                        whether you are joining for the first time
                        or growing your existing network.
                    </p>

                    <div class="about-check-list">

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Simple and easy-to-understand packages</span>
                        </div>

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Structured level-based opportunities</span>
                        </div>

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Secure mobile OTP authentication</span>
                        </div>

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Community-focused platform</span>
                        </div>

                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Transparent package information</span>
                        </div>

                    </div>

                </div>


                <div class="about-why-card">

                    <div class="why-card-top">

                        <span>
                            OUR APPROACH
                        </span>

                        <i class="bi bi-lightning-charge"></i>

                    </div>

                    <div class="why-progress-item">

                        <div class="why-progress-heading">
                            <span>Simplicity</span>
                            <strong>100%</strong>
                        </div>

                        <div class="why-progress">
                            <span style="width:100%"></span>
                        </div>

                    </div>

                    <div class="why-progress-item">

                        <div class="why-progress-heading">
                            <span>Community</span>
                            <strong>95%</strong>
                        </div>

                        <div class="why-progress">
                            <span style="width:95%"></span>
                        </div>

                    </div>

                    <div class="why-progress-item">

                        <div class="why-progress-heading">
                            <span>Transparency</span>
                            <strong>100%</strong>
                        </div>

                        <div class="why-progress">
                            <span style="width:100%"></span>
                        </div>

                    </div>

                    <div class="why-card-bottom">

                        <i class="bi bi-shield-check"></i>

                        <div>
                            <strong>
                                Built for trust
                            </strong>

                            <span>
                                Clear information at every step
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    HOW IT WORKS
    ========================================================= --}}

    <section class="about-process">

        <div class="about-container">

            <div class="about-section-heading center">

                <span>
                    HOW IT WORKS
                </span>

                <h2>
                    Simple steps.
                    <strong>Clear journey.</strong>
                </h2>

                <p>
                    Getting started is simple. Follow a few steps
                    and begin your journey with the platform.
                </p>

            </div>


            <div class="process-grid">

                <div class="process-card">

                    <div class="process-number">
                        01
                    </div>

                    <div class="process-icon">
                        <i class="bi bi-phone"></i>
                    </div>

                    <h3>
                        Create Your Account
                    </h3>

                    <p>
                        Enter your mobile number and verify it
                        securely using OTP.
                    </p>

                </div>


                <div class="process-line"></div>


                <div class="process-card">

                    <div class="process-number">
                        02
                    </div>

                    <div class="process-icon">
                        <i class="bi bi-grid"></i>
                    </div>

                    <h3>
                        Choose Your Package
                    </h3>

                    <p>
                        Explore the available packages and select
                        the one that matches your journey.
                    </p>

                </div>


                <div class="process-line"></div>


                <div class="process-card">

                    <div class="process-number">
                        03
                    </div>

                    <div class="process-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                    <h3>
                        Start Growing
                    </h3>

                    <p>
                        Participate in the community and work
                        towards your goals.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    CTA
    ========================================================= --}}

    <section class="about-cta">

        <div class="about-container">

            <div class="about-cta-box">

                <div class="about-cta-content">

                    <span>
                        READY TO BEGIN?
                    </span>

                    <h2>
                        Your journey starts
                        <strong>with one step.</strong>
                    </h2>

                    <p>
                        Create your account and explore the
                        opportunities available to you.
                    </p>

                </div>

                <a href="{{ route('login') }}" class="about-cta-btn">

                    Get Started

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

        </div>

    </section>

@endsection