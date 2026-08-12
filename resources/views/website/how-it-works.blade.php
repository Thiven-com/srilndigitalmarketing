@extends('layouts.website')

@section('title', 'How It Works')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/how-it-works.css') }}">
@endsection

@section('content')

{{-- =========================================================
    HERO
========================================================= --}}

<section class="how-hero">

    <div class="how-container">

        <div class="how-hero-content">

            <span class="how-badge">
                <i class="bi bi-lightning-charge-fill"></i>
                HOW IT WORKS
            </span>

            <h1>
                Start Simple.
                <span>Grow Step by Step.</span>
            </h1>

            <p>
                Our platform is designed to make your journey
                simple and easy to understand. Follow the steps,
                choose your package and start building your journey.
            </p>

            <div class="how-hero-buttons">

                <a href="{{ route('packages') }}" class="how-primary-btn">
                    Explore Packages
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="{{ route('login') }}" class="how-outline-btn">
                    Get Started
                </a>

            </div>

        </div>


        <div class="how-hero-visual">

            <div class="hero-orbit orbit-one"></div>
            <div class="hero-orbit orbit-two"></div>

            <div class="how-hero-card">

                <div class="hero-card-icon">
                    <i class="bi bi-rocket-takeoff"></i>
                </div>

                <span>
                    YOUR JOURNEY
                </span>

                <h3>
                    From Joining
                    <strong>to Growing</strong>
                </h3>

                <div class="hero-flow">

                    <div class="hero-flow-item active">
                        <i class="bi bi-phone"></i>
                    </div>

                    <div class="hero-flow-line"></div>

                    <div class="hero-flow-item">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="hero-flow-line"></div>

                    <div class="hero-flow-item">
                        <i class="bi bi-people"></i>
                    </div>

                    <div class="hero-flow-line"></div>

                    <div class="hero-flow-item">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                </div>

                <div class="hero-flow-labels">
                    <span>Join</span>
                    <span>Choose</span>
                    <span>Connect</span>
                    <span>Grow</span>
                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
    MAIN STEPS
========================================================= --}}

<section class="how-steps">

    <div class="how-container">

        <div class="how-heading">

            <span>
                SIMPLE PROCESS
            </span>

            <h2>
                How your journey
                <strong>works</strong>
            </h2>

            <p>
                Everything is organized into simple steps so
                you can understand the process before getting started.
            </p>

        </div>


        <div class="steps-wrapper">

            {{-- STEP 01 --}}
            <div class="step-card">

                <div class="step-number">
                    01
                </div>

                <div class="step-icon">
                    <i class="bi bi-phone"></i>
                </div>

                <div class="step-content">

                    <span class="step-label">
                        STEP ONE
                    </span>

                    <h3>
                        Enter Your Mobile Number
                    </h3>

                    <p>
                        Start by entering your mobile number.
                        Your number will be checked to determine
                        whether you are an existing member or a new member.
                    </p>

                </div>

            </div>


            <div class="step-connector">
                <span></span>
            </div>


            {{-- STEP 02 --}}
            <div class="step-card">

                <div class="step-number">
                    02
                </div>

                <div class="step-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div class="step-content">

                    <span class="step-label">
                        STEP TWO
                    </span>

                    <h3>
                        Verify With OTP
                    </h3>

                    <p>
                        Verify your mobile number using the OTP
                        sent to your registered mobile number.
                    </p>

                </div>

            </div>


            <div class="step-connector">
                <span></span>
            </div>


            {{-- STEP 03 --}}
            <div class="step-card">

                <div class="step-number">
                    03
                </div>

                <div class="step-icon">
                    <i class="bi bi-person-plus"></i>
                </div>

                <div class="step-content">

                    <span class="step-label">
                        STEP THREE
                    </span>

                    <h3>
                        Complete Your Profile
                    </h3>

                    <p>
                        New members can provide their basic
                        information and complete the registration process.
                    </p>

                </div>

            </div>


            <div class="step-connector">
                <span></span>
            </div>


            {{-- STEP 04 --}}
            <div class="step-card">

                <div class="step-number">
                    04
                </div>

                <div class="step-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div class="step-content">

                    <span class="step-label">
                        STEP FOUR
                    </span>

                    <h3>
                        Choose Your Package
                    </h3>

                    <p>
                        Explore the available packages and
                        select the package that suits your journey.
                    </p>

                    <a href="{{ route('packages') }}">
                        View Packages
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>


            <div class="step-connector">
                <span></span>
            </div>


            {{-- STEP 05 --}}
            <div class="step-card">

                <div class="step-number">
                    05
                </div>

                <div class="step-icon">
                    <i class="bi bi-people"></i>
                </div>

                <div class="step-content">

                    <span class="step-label">
                        STEP FIVE
                    </span>

                    <h3>
                        Build Your Community
                    </h3>

                    <p>
                        Connect with people, introduce your
                        community and participate in the platform.
                    </p>

                </div>

            </div>


            <div class="step-connector">
                <span></span>
            </div>


            {{-- STEP 06 --}}
            <div class="step-card final-step">

                <div class="step-number">
                    06
                </div>

                <div class="step-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>

                <div class="step-content">

                    <span class="step-label">
                        STEP SIX
                    </span>

                    <h3>
                        Grow With Your Journey
                    </h3>

                    <p>
                        Continue your journey by participating
                        consistently and working towards your goals.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
    PACKAGE FLOW
========================================================= --}}

<section class="package-flow">

    <div class="how-container">

        <div class="how-heading center">

            <span>
                PACKAGE JOURNEY
            </span>

            <h2>
                Understand your
                <strong>package</strong>
            </h2>

            <p>
                Each package can have its own levels and
                components based on your platform configuration.
            </p>

        </div>


        <div class="package-flow-grid">

            <div class="package-flow-card">

                <div class="package-flow-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <h3>
                    Select Package
                </h3>

                <p>
                    Choose one of the available packages.
                </p>

            </div>


            <div class="package-arrow">
                <i class="bi bi-arrow-right"></i>
            </div>


            <div class="package-flow-card">

                <div class="package-flow-icon">
                    <i class="bi bi-diagram-3"></i>
                </div>

                <h3>
                    Package Levels
                </h3>

                <p>
                    Your selected package can contain
                    multiple configured levels.
                </p>

            </div>


            <div class="package-arrow">
                <i class="bi bi-arrow-right"></i>
            </div>


            <div class="package-flow-card">

                <div class="package-flow-icon">
                    <i class="bi bi-layers"></i>
                </div>

                <h3>
                    Package Components
                </h3>

                <p>
                    Components can define different
                    configured benefits and calculations.
                </p>

            </div>

        </div>


        <div class="component-list">

            <div class="component-item">
                <i class="bi bi-person-plus"></i>
                <span>Direct</span>
            </div>

            <div class="component-item">
                <i class="bi bi-building"></i>
                <span>Company</span>
            </div>

            <div class="component-item">
                <i class="bi bi-wallet2"></i>
                <span>Expense</span>
            </div>

            <div class="component-item">
                <i class="bi bi-share"></i>
                <span>Sharing</span>
            </div>

            <div class="component-item">
                <i class="bi bi-gift"></i>
                <span>Bonus</span>
            </div>

        </div>

    </div>

</section>


{{-- =========================================================
    LEVEL SYSTEM
========================================================= --}}

<section class="levels-section">

    <div class="how-container">

        <div class="levels-grid">

            <div class="levels-content">

                <span>
                    LEVEL STRUCTURE
                </span>

                <h2>
                    Grow through
                    <strong>multiple levels</strong>
                </h2>

                <p>
                    Packages can be configured with different
                    levels. Each level can have its own business,
                    income and calculation rules.
                </p>

                <a
                    href="{{ route('packages') }}"
                    class="levels-btn"
                >
                    Explore Packages
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            <div class="levels-visual">

                @for($level = 1; $level <= 6; $level++)

                    <div class="level-row">

                        <div class="level-circle">
                            {{ $level }}
                        </div>

                        <div class="level-line-content">

                            <span>
                                LEVEL {{ $level }}
                            </span>

                            <div class="level-line">
                                <span
                                    style="width: {{ 35 + ($level * 9) }}%"
                                ></span>
                            </div>

                        </div>

                    </div>

                @endfor

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
    CTA
========================================================= --}}

<section class="how-cta">

    <div class="how-container">

        <div class="how-cta-box">

            <div>

                <span>
                    READY TO BEGIN?
                </span>

                <h2>
                    Start your journey
                    <strong>today.</strong>
                </h2>

                <p>
                    Explore the packages and find the right
                    starting point for your journey.
                </p>

            </div>

            <div class="how-cta-buttons">

                <a
                    href="{{ route('packages') }}"
                    class="cta-white"
                >
                    Explore Packages
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a
                    href="{{ route('login') }}"
                    class="cta-transparent"
                >
                    Get Started
                </a>

            </div>

        </div>

    </div>

</section>

@endsection