@extends('layouts.website')

@section('title', $package->name . ' - Package Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/package-details.css') }}">
@endsection

@section('content')

<div class="package-page">

    {{-- =========================================================
        BREADCRUMB
    ========================================================== --}}
    <section class="package-breadcrumb-section">

        <div class="container">

            <div class="package-breadcrumb">

                <a href="{{ route('home') }}">
                    Home
                </a>

                <i class="bi bi-chevron-right"></i>

                <span>
                    {{ $package->name }}
                </span>

            </div>

        </div>

    </section>


    {{-- =========================================================
        1. PACKAGE OVERVIEW
    ========================================================== --}}
    <section class="package-hero">

        <div class="container">

            <div class="package-hero-card">

                {{-- LEFT CONTENT --}}
                <div class="package-hero-content">

                    <div class="package-label">
                        <span></span>
                        PACKAGE DETAILS
                    </div>

                    <h1>
                        {{ $package->name }}
                    </h1>

                    @if($package->short_description)
                        <p class="package-short-description">
                            {{ $package->short_description }}
                        </p>
                    @endif


                    <div class="package-highlights">

                        <div class="package-highlight">

                            <div class="highlight-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>

                            <div>
                                <strong>Direct Income</strong>
                                <span>Earn through direct referrals</span>
                            </div>

                        </div>


                        <div class="package-highlight">

                            <div class="highlight-icon">
                                <i class="bi bi-bar-chart"></i>
                            </div>

                            <div>
                                <strong>Level Income</strong>
                                <span>Multiple earning levels</span>
                            </div>

                        </div>


                        <div class="package-highlight">

                            <div class="highlight-icon">
                                <i class="bi bi-gift"></i>
                            </div>

                            <div>
                                <strong>Bonus Benefits</strong>
                                <span>Additional earning opportunities</span>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- PRICE --}}
                <div class="package-price-card">

                    <span class="price-heading">
                        PACKAGE PRICE
                    </span>

                    <div class="main-package-price">

                        <small>₹</small>

                        {{ number_format($package->price, 0) }}

                    </div>


                    <div class="package-price-details">

                        <div class="price-row">

                            <span>
                                Joining Fee
                            </span>

                            <strong>
                                ₹{{ number_format($package->joining_amount, 0) }}
                            </strong>

                        </div>


                        <div class="price-row">

                            <span>
                                Renewal Fee
                            </span>

                            <strong>
                                ₹{{ number_format($package->renewal_amount, 0) }}
                            </strong>

                        </div>

                    </div>


                    <a href="#" class="package-join-btn">

                        Join This Package

                        <i class="bi bi-arrow-right"></i>

                    </a>


                    <div class="price-note">

                        <i class="bi bi-shield-check"></i>

                        Simple & transparent pricing

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
        2. WHAT YOU GET
    ========================================================== --}}
    <section class="what-you-get-section">

        <div class="container">

            <div class="section-heading">

                <span>
                    WHAT YOU GET
                </span>

                <h2>
                    Benefits included in your package
                </h2>

                <p>
                    Explore the benefits and earning opportunities
                    available with this package.
                </p>

            </div>


            <div class="benefits-grid">

                @forelse($components as $component)

                    @php

                        $type = strtolower(trim($component->component_type));

                        $icons = [

                            'direct' => 'bi-person-plus',

                            'company' => 'bi-building',

                            'expense' => 'bi-wallet2',

                            'sharing' => 'bi-share',

                            'bonus' => 'bi-gift',

                        ];

                        $titles = [

                            'direct' => 'Direct Income',

                            'company' => 'Company Benefits',

                            'expense' => 'Package Expense',

                            'sharing' => 'Sharing Income',

                            'bonus' => 'Bonus',

                        ];

                        $descriptions = [

                            'direct' => 'Earn through your eligible direct referrals.',

                            'company' => 'Benefits provided through the company.',

                            'expense' => 'Amount allocated towards package expenses.',

                            'sharing' => 'Earn through eligible sharing opportunities.',

                            'bonus' => 'Additional rewards available with this package.',

                        ];

                        $icon = $icons[$type] ?? 'bi-stars';

                        $title = $titles[$type] ?? $component->name;

                        $description = $component->description
                            ?: ($descriptions[$type] ?? 'Package benefit');

                    @endphp


                    <div class="benefit-card {{ $type === 'expense' ? 'expense-card' : '' }}">

                        <div class="benefit-top">

                            <div class="benefit-icon">

                                <i class="bi {{ $icon }}"></i>

                            </div>

                            @if($component->is_mandatory)

                                <span class="mandatory-badge">
                                    Included
                                </span>

                            @endif

                        </div>


                        <h3>
                            {{ $title }}
                        </h3>


                        <p>
                            {{ $description }}
                        </p>


                        <div class="benefit-bottom">

                            @if($component->calculation_type === 'percentage')

                                <strong>
                                    {{ rtrim(rtrim(number_format($component->percentage, 2), '0'), '.') }}%
                                </strong>

                                <span>
                                    Income
                                </span>

                            @elseif($component->amount !== null)

                                <strong>
                                    ₹{{ number_format($component->amount, 0) }}
                                </strong>

                                <span>
                                    Amount
                                </span>

                            @elseif($component->minimum_amount !== null)

                                <strong>
                                    ₹{{ number_format($component->minimum_amount, 0) }}
                                </strong>

                                <span>
                                    Minimum
                                </span>

                            @else

                                <strong>
                                    Available
                                </strong>

                                <span>
                                    Benefit
                                </span>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <i class="bi bi-info-circle"></i>

                        <h3>
                            No Benefits Available
                        </h3>

                        <p>
                            Benefits have not been configured for this package yet.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>



    {{-- =========================================================
        3. HOW YOU CAN EARN
    ========================================================== --}}
    <section class="how-earn-section">

        <div class="container">

            <div class="section-heading center">

                <span>
                    HOW YOU CAN EARN
                </span>

                <h2>
                    Simple ways to grow your income
                </h2>

                <p>
                    Understand the different earning opportunities
                    available with your package.
                </p>

            </div>


            <div class="earning-flow">

                <div class="earning-step">

                    <div class="step-number">
                        01
                    </div>

                    <div class="step-icon">
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <h3>
                        Direct Income
                    </h3>

                    <p>
                        Earn when you directly refer eligible members.
                    </p>

                </div>


                <div class="flow-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>


                <div class="earning-step">

                    <div class="step-number">
                        02
                    </div>

                    <div class="step-icon">
                        <i class="bi bi-diagram-3"></i>
                    </div>

                    <h3>
                        Level Income
                    </h3>

                    <p>
                        Earn according to your eligible levels.
                    </p>

                </div>


                <div class="flow-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>


                <div class="earning-step">

                    <div class="step-number">
                        03
                    </div>

                    <div class="step-icon">
                        <i class="bi bi-share"></i>
                    </div>

                    <h3>
                        Sharing Income
                    </h3>

                    <p>
                        Receive eligible sharing benefits.
                    </p>

                </div>


                <div class="flow-arrow">
                    <i class="bi bi-arrow-right"></i>
                </div>


                <div class="earning-step">

                    <div class="step-number">
                        04
                    </div>

                    <div class="step-icon">
                        <i class="bi bi-gift"></i>
                    </div>

                    <h3>
                        Bonus
                    </h3>

                    <p>
                        Receive additional eligible rewards.
                    </p>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
        4. LEVEL INCOME
    ========================================================== --}}
    <section class="levels-section">

        <div class="container">

            <div class="section-heading">

                <span>
                    LEVEL INCOME
                </span>

                <h2>
                    Your earning levels
                </h2>

                <p>
                    See how the earning levels work for this package.
                </p>

            </div>


            <div class="levels-card">

                {{-- TABLE HEADER --}}
                <div class="levels-card-header">

                    <div>

                        <h3>
                            {{ $package->name }} Level Structure
                        </h3>

                        <p>
                            {{ $levels->count() }}
                            {{ $levels->count() == 1 ? 'earning level' : 'earning levels' }}
                        </p>

                    </div>


                    <div class="levels-count">

                        <i class="bi bi-diagram-3"></i>

                        {{ $levels->count() }} Levels

                    </div>

                </div>


                {{-- TABLE --}}
                <div class="table-responsive">

                    <table class="levels-table">

                        <thead>

                            <tr>

                                <th>
                                    Level
                                </th>

                                <th>
                                    You Earn
                                </th>

                                <th>
                                    Business Needed
                                </th>

                                <th>
                                    Maximum Income
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($levels as $level)

                                <tr>

                                    {{-- LEVEL --}}
                                    <td>

                                        <div class="level-info">

                                            <div class="level-number">
                                                {{ $level->level }}
                                            </div>

                                            <div>

                                                <strong>
                                                    {{ $level->name ?: 'Level '.$level->level }}
                                                </strong>

                                                <small>
                                                    Earning Level {{ $level->level }}
                                                </small>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- EARN --}}
                                    <td>

                                        @if($level->percentage !== null)

                                            <div class="earning-value">

                                                <strong>
                                                    {{ rtrim(rtrim(number_format($level->percentage, 2), '0'), '.') }}%
                                                </strong>

                                                <span>
                                                    Income
                                                </span>

                                            </div>

                                        @elseif($level->amount !== null)

                                            <div class="earning-value">

                                                <strong>
                                                    ₹{{ number_format($level->amount, 0) }}
                                                </strong>

                                                <span>
                                                    Income
                                                </span>

                                            </div>

                                        @else

                                            <span class="not-set">
                                                Not specified
                                            </span>

                                        @endif

                                    </td>


                                    {{-- BUSINESS --}}
                                    <td>

                                        @if($level->minimum_business !== null)

                                            <div class="business-value">

                                                ₹{{ number_format($level->minimum_business, 0) }}

                                            </div>

                                        @else

                                            <span class="not-set">
                                                Not specified
                                            </span>

                                        @endif

                                    </td>


                                    {{-- MAXIMUM --}}
                                    <td>

                                        @if($level->maximum_income !== null)

                                            <div class="maximum-value">

                                                ₹{{ number_format($level->maximum_income, 0) }}

                                            </div>

                                        @else

                                            <span class="unlimited-badge">

                                                <i class="bi bi-infinity"></i>

                                                Unlimited

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4">

                                        <div class="empty-state">

                                            <i class="bi bi-diagram-3"></i>

                                            <h3>
                                                No Levels Available
                                            </h3>

                                            <p>
                                                Level income has not been configured yet.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- HOW IT WORKS --}}
            <div class="how-it-works-box">

                <div class="how-it-works-icon">

                    <i class="bi bi-lightbulb"></i>

                </div>

                <div>

                    <h3>
                        How does it work?
                    </h3>

                    <p>
                        As you become eligible for different levels,
                        you can receive income according to the rules
                        of your selected package.
                    </p>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
        5. PACKAGE DESCRIPTION
    ========================================================== --}}
    @if($package->description)

        <section class="description-section">

            <div class="container">

                <div class="description-card">

                    <div class="description-icon">

                        <i class="bi bi-info-lg"></i>

                    </div>

                    <div>

                        <span>
                            ABOUT THIS PACKAGE
                        </span>

                        <h2>
                            {{ $package->name }}
                        </h2>

                        <div class="package-description">

                            {!! nl2br(e($package->description)) !!}

                        </div>

                    </div>

                </div>

            </div>

        </section>

    @endif



    {{-- =========================================================
        6. FINAL CTA
    ========================================================== --}}
    <section class="package-cta-section">

        <div class="container">

            <div class="package-cta">

                <div class="cta-content">

                    <span>
                        READY TO GET STARTED?
                    </span>

                    <h2>
                        Start with {{ $package->name }}
                    </h2>

                    <p>
                        Choose your package and begin your journey today.
                    </p>

                </div>


                <div class="cta-action">

                    <div class="cta-price">

                        <small>₹</small>

                        {{ number_format($package->price, 0) }}

                    </div>


                    <a href="#" class="cta-button">

                        Join This Package

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection