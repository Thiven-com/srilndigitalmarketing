@extends('layouts.website')

@section('title', 'Home')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/home.css') }}">
@endsection

@section('content')

    {{-- =========================================================
    HERO
    ========================================================= --}}

    <section class="hero-section">

        <div class="hero-bg-circle circle-one"></div>
        <div class="hero-bg-circle circle-two"></div>

        <div class="container-custom">

            <div class="row align-items-center">

                {{-- LEFT --}}
                <div class="col-lg-6">

                    <div class="hero-content">

                        <div class="hero-badge">

                            <span class="hero-badge-icon">
                                <i class="bi bi-stars"></i>
                            </span>

                            Trusted Membership Platform

                        </div>

                        <h1 class="hero-title">

                            Build Your

                            <br>

                            <span>Network.</span>

                            <br>

                            Grow Together.

                        </h1>

                        <p class="hero-description">

                            Connect with people, build a strong community
                            and explore structured membership opportunities
                            through our powerful platform.

                        </p>

                        <div class="hero-buttons">

                            <a href="{{ url('/register') }}" class="btn-primary-custom hero-btn">

                                Get Started

                                <i class="bi bi-arrow-right"></i>

                            </a>

                            <a href="#packages" class="btn-outline-custom hero-btn">

                                Explore Packages

                                <i class="bi bi-grid"></i>

                            </a>

                        </div>

                        <div class="hero-trust">

                            <div class="hero-trust-item">

                                <span>
                                    <i class="bi bi-shield-check"></i>
                                </span>

                                Secure Platform

                            </div>

                            <div class="hero-trust-item">

                                <span>
                                    <i class="bi bi-patch-check"></i>
                                </span>

                                Transparent Plan

                            </div>

                            <div class="hero-trust-item">

                                <span>
                                    <i class="bi bi-headset"></i>
                                </span>

                                Support

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RIGHT --}}
                <div class="col-lg-6">

                    <div class="hero-network-area">

                        <div class="network-circle">

                            <span class="network-line line-one"></span>
                            <span class="network-line line-two"></span>
                            <span class="network-line line-three"></span>
                            <span class="network-line line-four"></span>
                            <span class="network-line line-five"></span>
                            <span class="network-line line-six"></span>

                            <div class="network-center">

                                <i class="bi bi-person-fill"></i>

                            </div>

                            @for($i = 1; $i <= 6; $i++)

                                <div class="network-node node-{{ $i }}">

                                    <i class="bi bi-person"></i>

                                </div>

                            @endfor

                        </div>


                        <div class="floating-income-card">

                            <div class="floating-income-icon">

                                <i class="bi bi-graph-up-arrow"></i>

                            </div>

                            <div>

                                <span>
                                    Network Growth
                                </span>

                                <strong>
                                    Growing Together
                                </strong>

                            </div>

                        </div>


                        <div class="floating-member-card">

                            <div class="floating-member-icon">

                                <i class="bi bi-people-fill"></i>

                            </div>

                            <div>

                                <span>
                                    Community
                                </span>

                                <strong>
                                    Strong Network
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    FEATURE CARDS
    ========================================================= --}}

    <section class="feature-section">

        <div class="container-custom">

            <div class="row g-3">

                <div class="col-lg-3 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon pink">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div>

                            <h4>
                                Strong Community
                            </h4>

                            <p>
                                Connect with a growing community
                                and build meaningful relationships.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon yellow">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>

                        <div>

                            <h4>
                                Multiple Opportunities
                            </h4>

                            <p>
                                Explore structured opportunities
                                based on your selected package.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon teal">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <div>

                            <h4>
                                Transparent System
                            </h4>

                            <p>
                                Clear packages, plans and
                                transaction information.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="col-lg-3 col-md-6">

                    <div class="feature-card">

                        <div class="feature-icon purple">
                            <i class="bi bi-headset"></i>
                        </div>

                        <div>

                            <h4>
                                Dedicated Support
                            </h4>

                            <p>
                                Get assistance whenever
                                you need help.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    DYNAMIC STATS
    ========================================================= --}}

    <section class="stats-section">

        <div class="container-custom">

            <div class="stats-wrapper">

                <div class="row g-0">

                    <div class="col-lg-3 col-6">

                        <div class="stat-item">

                            <div class="stat-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>

                            <div>

                                <strong>
                                    {{ $packages->count() }}
                                </strong>

                                <span>
                                    Packages
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-6">

                        <div class="stat-item">

                            <div class="stat-icon">
                                <i class="bi bi-diagram-3"></i>
                            </div>

                            <div>

                                <strong>
                                    2
                                </strong>

                                <span>
                                    Team Models
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-6">

                        <div class="stat-item">

                            <div class="stat-icon">
                                <i class="bi bi-layers"></i>
                            </div>

                            <div>

                                <strong>
                                    {{ $packages->max(
        fn($package) =>
        $package->levels->count()
    ) ?? 0 }}
                                </strong>

                                <span>
                                    Levels
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-3 col-6">

                        <div class="stat-item">

                            <div class="stat-icon">
                                <i class="bi bi-headset"></i>
                            </div>

                            <div>

                                <strong>
                                    24/7
                                </strong>

                                <span>
                                    Support
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    DYNAMIC PACKAGES
    ========================================================= --}}

    <section class="growth-packages-section" id="packages">

        <div class="packages-container">

            {{-- Section Header --}}
            <div class="packages-heading">

                <span class="packages-eyebrow">
                    <span class="eyebrow-line"></span>
                    GROW YOUR BUSINESS
                    <span class="eyebrow-line"></span>
                </span>

                <h2>
                    Choose Your
                    <span>Growth Package</span>
                </h2>

                <p>
                    Select the package structure that best matches your goals
                    and start building your growth journey.
                </p>

            </div>


            {{-- Packages --}}
            <div class="packages-grid">

                @forelse($packages as $package)

                    @php
                        $mainComponents = $package->components
                            ->whereNull('level')
                            ->where('status', 1)
                            ->keyBy('component_type');

                        $levelCount = $package->levels_count ?? $package->levels->count();
                    @endphp


                    <div class="growth-package-card
                            {{ $package->is_popular ? 'popular-package' : '' }}">

                        {{-- Popular --}}
                        @if($package->is_popular)

                            <div class="popular-badge">
                                <i class="fas fa-star"></i>
                                Most Popular
                            </div>

                        @endif


                        {{-- Card Top --}}
                        <div class="package-card-top">

                            <div class="package-number">
                                PACKAGE {{ $loop->iteration }}
                            </div>

                            <h3>
                                {{ $package->name }}
                            </h3>

                            @if($package->short_description)
                                <p class="package-short-description">
                                    {{ $package->short_description }}
                                </p>
                            @endif


                            <div class="package-price">

                                <span class="currency">₹</span>

                                <span class="price">
                                    {{ number_format($package->price) }}
                                </span>

                            </div>


                            <div class="level-badge">

                                <i class="fas fa-layer-group"></i>

                                {{ $levelCount }} Level Structure

                            </div>

                        </div>


                        {{-- Package Features --}}
                        <div class="package-card-body">

                            {{-- Direct --}}
                            <div class="package-feature">

                                <div class="feature-left">

                                    <span class="feature-icon direct-icon">
                                        <i class="fas fa-user-plus"></i>
                                    </span>

                                    <span>
                                        Direct Income
                                    </span>

                                </div>

                                <strong>
                                    ₹{{ number_format($mainComponents['direct']->amount ?? 0) }}
                                </strong>

                            </div>


                            {{-- Company --}}
                            <div class="package-feature">

                                <div class="feature-left">

                                    <span class="feature-icon company-icon">
                                        <i class="fas fa-building"></i>
                                    </span>

                                    <span>
                                        Company Income
                                    </span>

                                </div>

                                <strong>
                                    ₹{{ number_format($mainComponents['company']->amount ?? 0) }}
                                </strong>

                            </div>


                            {{-- Expense --}}
                            <div class="package-feature">

                                <div class="feature-left">

                                    <span class="feature-icon expense-icon">
                                        <i class="fas fa-receipt"></i>
                                    </span>

                                    <span>
                                        Expense
                                    </span>

                                </div>

                                <strong>
                                    ₹{{ number_format($mainComponents['expense']->amount ?? 0) }}
                                </strong>

                            </div>


                            {{-- Sharing --}}
                            <div class="package-feature">

                                <div class="feature-left">

                                    <span class="feature-icon sharing-icon">
                                        <i class="fas fa-share-nodes"></i>
                                    </span>

                                    <span>
                                        Sharing
                                    </span>

                                </div>

                                <strong>
                                    ₹{{ number_format($mainComponents['sharing']->amount ?? 0) }}
                                </strong>

                            </div>


                            {{-- Bonus --}}
                            <div class="package-feature">

                                <div class="feature-left">

                                    <span class="feature-icon bonus-icon">
                                        <i class="fas fa-gift"></i>
                                    </span>

                                    <span>
                                        Bonus
                                    </span>

                                </div>

                                <strong>
                                    ₹{{ number_format($mainComponents['bonus']->amount ?? 0) }}
                                </strong>

                            </div>


                            {{-- Levels --}}
                            <div class="package-feature levels-feature">

                                <div class="feature-left">

                                    <span class="feature-icon level-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </span>

                                    <span>
                                        Levels
                                    </span>

                                </div>

                                <strong>
                                    {{ $levelCount }}
                                </strong>

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="package-card-footer">

                            <a href="{{ route('package.details', $package->slug) }}" class="choose-package-btn">

                                <span>
                                    View Package
                                </span>

                                <i class="fas fa-arrow-right"></i>

                            </a>

                        </div>

                    </div>

                @empty

                    <div class="packages-empty">

                        <i class="fas fa-box-open"></i>

                        <h3>No Packages Available</h3>

                        <p>
                            Packages will be available soon.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- Bottom Link --}}
            {{-- @if($packages->count())

                <div class="packages-bottom">

                    <a href="{{ route('website.packages') }}" class="view-all-packages">

                        View All Packages

                        <i class="fas fa-arrow-right"></i>

                    </a>

                </div>

            @endif --}}

        </div>

    </section>


    {{-- =========================================================
    HOW IT WORKS
    ========================================================= --}}

    <section class="how-section">

        <div class="container-custom">

            <div class="section-heading">

                <span class="section-label">
                    How It Works
                </span>

                <h2>

                    Start Your Journey

                    <span>
                        In 4 Simple Steps
                    </span>

                </h2>

                <p>
                    Getting started is simple and straightforward.
                </p>

            </div>


            <div class="row g-4">

                @php

                    $steps = [

                        [
                            'number' => '01',
                            'icon' => 'bi-person-plus',
                            'class' => 'pink',
                            'title' => 'Create Account',
                            'description' =>
                                'Register your account and receive your unique referral ID.'
                        ],

                        [
                            'number' => '02',
                            'icon' => 'bi-box-seam',
                            'class' => 'blue',
                            'title' => 'Select Package',
                            'description' =>
                                'Choose one of the available packages based on your plan.'
                        ],

                        [
                            'number' => '03',
                            'icon' => 'bi-diagram-3',
                            'class' => 'teal',
                            'title' => 'Build Network',
                            'description' =>
                                'Share your referral link and build your community.'
                        ],

                        [
                            'number' => '04',
                            'icon' => 'bi-wallet2',
                            'class' => 'purple',
                            'title' => 'Track Everything',
                            'description' =>
                                'Manage your team, wallet, income and transactions.'
                        ],

                    ];

                @endphp


                @foreach($steps as $step)

                    <div class="col-lg-3 col-md-6">

                        <div class="step-card">

                            <div class="step-number">
                                {{ $step['number'] }}
                            </div>

                            <div class="step-icon {{ $step['class'] }}">

                                <i class="bi {{ $step['icon'] }}"></i>

                            </div>

                            <h4>
                                {{ $step['title'] }}
                            </h4>

                            <p>
                                {{ $step['description'] }}
                            </p>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>


    {{-- =========================================================
    DYNAMIC INCOME PLAN
    ========================================================= --}}

    <section class="income-section">

        <div class="container-custom">

            <div class="income-wrapper">

                <div class="row align-items-center g-5">

                    {{-- LEFT --}}
                    <div class="col-lg-4">

                        <span class="section-label">
                            Income Plan
                        </span>

                        <h2>

                            A Clear

                            <span>
                                {{ $featuredPackage?->levels->count() ?? 0 }}-Level
                            </span>

                            Structure

                        </h2>

                        <p>

                            Understand your package structure,
                            levels and configured opportunities
                            from one simple view.

                        </p>

                        {{-- <a href="{{ url('/income-plan') }}" class="btn-primary-custom">

                            View Income Plan

                            <i class="bi bi-arrow-right"></i>

                        </a> --}}

                    </div>


                    {{-- RIGHT --}}
                    <div class="col-lg-8">

                        @if($featuredPackage)

                            <div class="income-table-card">

                                <div class="income-table-header">

                                    <div>

                                        <strong>
                                            {{ $featuredPackage->name }}
                                        </strong>

                                        <span>
                                            {{ $featuredPackage->levels->count() }}
                                            Levels
                                        </span>

                                    </div>

                                    <span class="income-table-badge">

                                        {{ $featuredPackage->levels->count() }}
                                        Levels

                                    </span>

                                </div>


                                <div class="table-responsive">

                                    <table class="table income-table mb-0">

                                        <thead>

                                            <tr>

                                                <th>
                                                    Level
                                                </th>

                                                <th>
                                                    Team
                                                </th>

                                                <th>
                                                    Income
                                                </th>

                                                <th>
                                                    Total
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            @foreach(
                                                                                $featuredPackage->levels
                                                                                as $level
                                                                            )

                                                                            @php

                                                                                $teamCount =
                                                                                    pow(
                                                                                        3,
                                                                                        $level->level
                                                                                    );

                                                                                $income =
                                                                                    $level->calculation_type
                                                                                    === 'percentage'
                                                                                    ? $level->percentage . '%'
                                                                                    : '₹' .
                                                                                    number_format(
                                                                                        $level->amount ?? 0,
                                                                                        0
                                                                                    );

                                                                                $total =
                                                                                    $level->calculation_type
                                                                                    === 'fixed'
                                                                                    ? ($teamCount *
                                                                                        ($level->amount ?? 0))
                                                                                    : null;

                                                                            @endphp

                                                                            <tr>

                                                                                <td>
                                                                                    {{ $level->name
                                                    ?: 'Level ' .
                                                    $level->level }}
                                                                                </td>

                                                                                <td>
                                                                                    {{ number_format(
                                                    $teamCount
                                                ) }}
                                                                                </td>

                                                                                <td>
                                                                                    {{ $income }}
                                                                                </td>

                                                                                <td>

                                                                                    @if(!is_null($total))

                                                                                                                        ₹{{ number_format(
                                                                                            $total,
                                                                                            0
                                                                                        ) }}

                                                                                    @else

                                                                                        —

                                                                                    @endif

                                                                                </td>

                                                                            </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>


                                <div class="income-table-footer">

                                    <span>
                                        View complete plan
                                    </span>

                                    <a href="{{ url('/income-plan') }}">

                                        <i class="bi bi-arrow-right"></i>

                                    </a>

                                </div>

                            </div>

                        @else

                            <div class="empty-packages">

                                No income plan available.

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
    CTA
    ========================================================= --}}

    <section class="cta-section">

        <div class="container-custom">

            <div class="cta-wrapper">

                <div class="cta-decoration cta-decoration-one"></div>

                <div class="cta-decoration cta-decoration-two"></div>


                <div class="cta-content">

                    <span class="cta-label">
                        GET STARTED TODAY
                    </span>

                    <h2>
                        Ready to Build
                        Your Network?
                    </h2>

                    <p>
                        Create your account, choose a package
                        and begin your journey.
                    </p>


                    <div class="cta-buttons">

                        <a href="{{ url('/register') }}" class="cta-white-btn">

                            Join Now

                            <i class="bi bi-arrow-right"></i>

                        </a>


                        <a href="{{ url('/contact') }}" class="cta-outline-btn">

                            Contact Us

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection


@section('scripts')

    <script src="{{ asset('website/js/home.js') }}"></script>

@endsection