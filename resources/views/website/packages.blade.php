@extends('layouts.website')

@section('title', 'Packages')

@section('styles')
    <link rel="stylesheet" href="{{ asset('website/css/packages.css') }}">
@endsection

@section('content')

    <section class="packages-page">

        {{-- HERO --}}
        <div class="packages-hero">

            <div class="packages-container">

                <span class="packages-badge">
                    <i class="bi bi-grid"></i>
                    OUR PACKAGES
                </span>

                <h1>
                    Choose Your
                    <span>Growth Package</span>
                </h1>

                <p>
                    Explore our packages and choose the plan that
                    best matches your goals and journey.
                </p>

            </div>

        </div>


        {{-- PACKAGES --}}
        <section class="packages-section">

            <div class="packages-container">

                @if($packages->count())

                    <div class="packages-grid">

                        @foreach($packages as $package)

                            <div class="package-card
                                        {{ $package->is_popular ? 'popular' : '' }}">

                                {{-- Popular --}}
                                @if($package->is_popular)

                                    <div class="popular-badge">
                                        <i class="bi bi-star-fill"></i>
                                        Most Popular
                                    </div>

                                @endif


                                {{-- Image --}}
                                <div class="package-image">

                                    @if($package->image)

                                        <img src="{{ asset($package->image) }}" alt="{{ $package->name }}">

                                    @else

                                        <div class="package-image-placeholder">

                                            @if($package->icon)

                                                <i class="{{ $package->icon }}"></i>

                                            @else

                                                <i class="bi bi-box-seam"></i>

                                            @endif

                                        </div>

                                    @endif

                                </div>


                                {{-- Content --}}
                                <div class="package-content">

                                    <div class="package-top">

                                        <div>

                                            <span class="package-code">
                                                {{ $package->code }}
                                            </span>

                                            <h2>
                                                {{ $package->name }}
                                            </h2>

                                        </div>

                                    </div>


                                    {{-- Price --}}
                                    <div class="package-price">

                                        <span class="price-symbol">
                                            ₹
                                        </span>

                                        <span class="price-value">
                                            {{ number_format($package->price, 0) }}
                                        </span>

                                    </div>


                                    {{-- Short Description --}}
                                    @if($package->short_description)

                                        <p class="package-description">
                                            {{ $package->short_description }}
                                        </p>

                                    @endif


                                    {{-- Joining / Renewal --}}
                                    <div class="package-meta">

                                        <div>

                                            <span>
                                                Joining
                                            </span>

                                            <strong>
                                                ₹{{ number_format($package->joining_amount, 0) }}
                                            </strong>

                                        </div>

                                        <div>

                                            <span>
                                                Renewal
                                            </span>

                                            <strong>
                                                ₹{{ number_format($package->renewal_amount, 0) }}
                                            </strong>

                                        </div>

                                    </div>


                                    {{-- Button --}}
                                    <a href="{{ route('package.details', $package->slug) }}" class="package-btn">

                                        View Package

                                        <i class="bi bi-arrow-right"></i>

                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="no-packages">

                        <div class="no-packages-icon">
                            <i class="bi bi-box"></i>
                        </div>

                        <h3>
                            No Packages Available
                        </h3>

                        <p>
                            Packages will appear here once they are
                            available.
                        </p>

                    </div>

                @endif

            </div>

        </section>


        {{-- BOTTOM CTA --}}
        <section class="packages-cta">

            <div class="packages-container">

                <div class="packages-cta-box">

                    <div>

                        <span>
                            READY TO START?
                        </span>

                        <h2>
                            Find the package
                            <strong>that's right for you.</strong>
                        </h2>

                    </div>

                    <a href="{{ route('login') }}" class="packages-cta-btn">

                        Get Started

                        <i class="bi bi-arrow-right"></i>

                    </a>

                </div>

            </div>

        </section>

    </section>

@endsection