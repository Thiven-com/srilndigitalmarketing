@extends('layouts.website')

@section('title', 'My Referrals')

@section('content')

<div class="customer-referrals-page">

    <div class="container">

        {{-- =====================================================
            PAGE HEADER
        ====================================================== --}}

        <div class="customer-page-header">

            <div>

                <span class="page-label">
                    MY NETWORK
                </span>

                <h1>
                    My Referrals
                </h1>

                <p>
                    View your referral network package by package.
                </p>

            </div>


            <a
                href="{{ route('customer.dashboard') }}"
                class="back-dashboard-btn"
            >

                <i class="bi bi-arrow-left"></i>

                Dashboard

            </a>

        </div>


        {{-- =====================================================
            SUCCESS / ERROR MESSAGES
        ====================================================== --}}

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4">

                <i class="bi bi-check-circle me-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">

                <i class="bi bi-exclamation-circle me-2"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        {{-- =====================================================
            PACKAGE SELECTOR
        ====================================================== --}}

        <div class="customer-content-card">

            <div class="customer-content-card-header">

                <div>

                    <h3>
                        My Packages
                    </h3>

                    <small class="text-muted">
                        Select a package to view its referral network.
                    </small>

                </div>

                <span class="page-label">
                    MY PACKAGES
                </span>

            </div>


            @if(isset($packages) && $packages->count())


                <div class="row g-3">

                    @foreach($packages as $package)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | Customer Package ID
                            |--------------------------------------------------------------------------
                            */

                            $customerPackageId =
                                $package->customer_package_id
                                ?? $package->id;


                            /*
                            |--------------------------------------------------------------------------
                            | Selected Package
                            |--------------------------------------------------------------------------
                            */

                            $isSelected =
                                request('package') == $customerPackageId;

                        @endphp


                        <div class="col-md-6 col-lg-4">

                            <a
                                href="{{ route('customer.referrals', [
                                    'package' => $customerPackageId
                                ]) }}"
                                class="text-decoration-none"
                            >

                                <div
                                    class="package-referral-card
                                    {{ $isSelected ? 'active' : '' }}"
                                >

                                    <div
                                        class="d-flex justify-content-between align-items-start"
                                    >

                                        <div>

                                            <span class="package-referral-label">
                                                PACKAGE
                                            </span>


                                            <h5 class="mb-2">

                                                {{ $package->name }}

                                            </h5>


                                            <small class="text-muted">

                                                ₹{{ number_format(
                                                    $package->price ?? 0,
                                                    2
                                                ) }}

                                            </small>

                                        </div>


                                        <div>

                                            @if($isSelected)

                                                <span class="package-selected-icon">

                                                    <i class="bi bi-check-circle-fill"></i>

                                                </span>

                                            @else

                                                <span class="package-arrow">

                                                    <i class="bi bi-chevron-right"></i>

                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </a>

                        </div>

                    @endforeach

                </div>


            @else


                {{-- =================================================
                    NO PACKAGES
                ================================================== --}}

                <div class="packages-empty">

                    <div class="empty-icon">

                        <i class="bi bi-box"></i>

                    </div>


                    <h3>
                        No Packages Purchased
                    </h3>


                    <p>
                        Purchase a package to start building your
                        referral network.
                    </p>


                    @if(Route::has('customer.packages'))

                        <a
                            href="{{ route('customer.packages') }}"
                            class="customer-primary-btn"
                        >

                            <i class="bi bi-box-seam me-2"></i>

                            View Packages

                        </a>

                    @endif

                </div>

            @endif

        </div>



        {{-- =====================================================
            SELECTED PACKAGE
        ====================================================== --}}

        @if(isset($selectedPackage) && $selectedPackage)


            {{-- =================================================
                PACKAGE HEADER
            ================================================== --}}

            <div class="customer-content-card mt-4">

                <div class="customer-content-card-header">

                    <div>

                        <span class="page-label">
                            SELECTED PACKAGE
                        </span>


                        <h3 class="mt-1 mb-0">

                            {{ $selectedPackage->name }}

                        </h3>

                    </div>


                    <span
                        class="badge bg-success-subtle text-success px-3 py-2 rounded-pill"
                    >

                        Lifetime Package

                    </span>

                </div>


                {{-- PACKAGE INFORMATION --}}

                <div class="row g-3">


                    {{-- AMOUNT --}}

                    <div class="col-md-4">

                        <div class="package-network-info">

                            <span>
                                Package Amount
                            </span>


                            <strong>

                                ₹{{ number_format(
                                    $selectedPackage->price ?? 0,
                                    2
                                ) }}

                            </strong>

                        </div>

                    </div>


                    {{-- TEAM TYPE --}}

                    <div class="col-md-4">

                        <div class="package-network-info">

                            <span>
                                Team Type
                            </span>


                            <strong>

                                {{ $selectedPackage->team_type ?? 'Team' }}

                            </strong>

                        </div>

                    </div>


                    {{-- TEAM SIZE --}}

                    <div class="col-md-4">

                        <div class="package-network-info">

                            <span>
                                Team Members
                            </span>


                            <strong>

                                {{ $selectedPackage->team_size ?? 0 }}

                            </strong>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                REFERRAL STATISTICS
            ================================================== --}}

            <div class="referral-stat-grid mt-4">


                {{-- TOTAL MEMBERS --}}

                <div class="referral-stat-card">

                    <span>
                        Total Members
                    </span>


                    <strong>
                        {{ $totalReferrals ?? 0 }}
                    </strong>

                </div>


                {{-- DIRECT MEMBERS --}}

                <div class="referral-stat-card">

                    <span>
                        Direct Members
                    </span>


                    <strong>
                        {{ $directReferrals ?? 0 }}
                    </strong>

                </div>


                {{-- POINTS --}}

                <div class="referral-stat-card">

                    <span>
                        Team Points
                    </span>


                    <strong>
                        {{ $totalPoints ?? 0 }}
                    </strong>

                </div>


                {{-- INCOME --}}

                <div class="referral-stat-card">

                    <span>
                        Referral Income
                    </span>


                    <strong>

                        ₹{{ number_format(
                            $totalIncome ?? 0,
                            2
                        ) }}

                    </strong>

                </div>

            </div>



            {{-- =================================================
                PACKAGE REFERRAL LINK
            ================================================== --}}

            <div class="customer-content-card mt-4">

                <div class="customer-content-card-header">

                    <div>

                        <h3>
                            Package Referral Link
                        </h3>


                        <small class="text-muted">

                            Share this link to invite members
                            for this package.

                        </small>

                    </div>


                    <span class="page-label">
                        INVITE & EARN
                    </span>

                </div>


                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Referral URL
                    |--------------------------------------------------------------------------
                    */

                    $referralUrl = url(
                        '/register'
                        . '?ref='
                        . $customer->id
                        . '&package='
                        . $selectedPackage->id
                    );

                @endphp


                <div class="referral-link-box">


                    <input
                        type="text"
                        id="referralLink"
                        readonly
                        value="{{ $referralUrl }}"
                    >


                    <button
                        type="button"
                        class="referral-copy-btn"
                        onclick="copyReferralLink()"
                    >

                        <i class="bi bi-copy"></i>

                        Copy Link

                    </button>


                </div>

            </div>



            {{-- =================================================
                NETWORK TYPES
            ================================================== --}}

            <div class="customer-content-card mt-4">

                <div class="customer-content-card-header">

                    <div>

                        <h3>
                            {{ $selectedPackage->name }} Network
                        </h3>


                        <small class="text-muted">

                            Package-specific referral structure.

                        </small>

                    </div>


                    <span class="page-label">
                        NETWORK
                    </span>

                </div>


                <div class="row g-3">


                    {{-- TEAM REFERRALS --}}

                    <div class="col-md-6">

                        <div class="network-type-card">


                            <div class="network-type-icon">

                                <i class="bi bi-diagram-3"></i>

                            </div>


                            <div>

                                <h5>
                                    Team Referrals
                                </h5>


                                <p>
                                    Members placed inside your package
                                    referral network.
                                </p>


                                <strong>

                                    {{ $totalReferrals ?? 0 }}

                                    Members

                                </strong>

                            </div>


                        </div>

                    </div>



                    {{-- DIRECT REFERRALS --}}

                    <div class="col-md-6">

                        <div class="network-type-card">


                            <div class="network-type-icon">

                                <i class="bi bi-person-plus"></i>

                            </div>


                            <div>

                                <h5>
                                    Direct Referrals
                                </h5>


                                <p>
                                    Members directly referred by you
                                    for this package.
                                </p>


                                <strong>

                                    {{ $directReferrals ?? 0 }}

                                    Members

                                </strong>

                            </div>


                        </div>

                    </div>


                </div>

            </div>



            {{-- =================================================
                REFERRAL MEMBERS
            ================================================== --}}

            <div class="customer-content-card mt-4">


                <div class="customer-content-card-header">

                    <div>

                        <h3>
                            Referral Members
                        </h3>


                        <small class="text-muted">

                            Members belonging to
                            {{ $selectedPackage->name }}

                        </small>

                    </div>


                    <span class="page-label">

                        {{ strtoupper(
                            $selectedPackage->name
                        ) }}

                    </span>

                </div>



                @if(isset($referrals) && $referrals->count())


                    <div class="customer-table-wrapper">

                        <table class="customer-table">


                            <thead>

                                <tr>

                                    <th>
                                        #
                                    </th>

                                    <th>
                                        Member
                                    </th>

                                    <th>
                                        Mobile
                                    </th>

                                    <th>
                                        Type
                                    </th>

                                    <th>
                                        Level
                                    </th>

                                    <th>
                                        Points
                                    </th>

                                    <th>
                                        Income
                                    </th>

                                    <th>
                                        Date
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                                @foreach($referrals as $referral)


                                    <tr>


                                        {{-- NUMBER --}}

                                        <td>

                                            {{ $loop->iteration }}

                                        </td>



                                        {{-- MEMBER --}}

                                        <td>

                                            <strong>

                                                {{
                                                    $referral->customer->name
                                                    ?? $referral->name
                                                    ?? 'Member'
                                                }}

                                            </strong>

                                        </td>



                                        {{-- MOBILE --}}

                                        <td>

                                            {{
                                                $referral->customer->mobile
                                                ?? $referral->mobile
                                                ?? '-'
                                            }}

                                        </td>



                                        {{-- TYPE --}}

                                        <td>


                                            @if(
                                                isset($referral->is_direct)
                                                && $referral->is_direct
                                            )


                                                <span
                                                    class="customer-status active"
                                                >

                                                    Direct

                                                </span>


                                            @else


                                                <span
                                                    class="customer-status"
                                                >

                                                    Team

                                                </span>


                                            @endif


                                        </td>



                                        {{-- LEVEL --}}

                                        <td>


                                            <span
                                                class="customer-status active"
                                            >

                                                Level
                                                {{ $referral->level ?? 1 }}

                                            </span>


                                        </td>



                                        {{-- POINTS --}}

                                        <td>

                                            {{ $referral->points ?? 0 }}

                                        </td>



                                        {{-- INCOME --}}

                                        <td>


                                            <strong class="verified">

                                                ₹{{ number_format(
                                                    $referral->total_income ?? 0,
                                                    2
                                                ) }}

                                            </strong>


                                        </td>



                                        {{-- DATE --}}

                                        <td>

                                            {{
                                                optional(
                                                    $referral->created_at
                                                )->format('d M Y')
                                            }}

                                        </td>


                                    </tr>


                                @endforeach


                            </tbody>


                        </table>

                    </div>


                @else


                    {{-- =================================================
                        EMPTY NETWORK
                    ================================================== --}}

                    <div class="packages-empty">


                        <div class="empty-icon">

                            <i class="bi bi-people"></i>

                        </div>


                        <h3>
                            No Referrals Yet
                        </h3>


                        <p>

                            You don't have any referral members
                            in this package yet.

                        </p>


                        <button
                            type="button"
                            class="customer-primary-btn"
                            onclick="copyReferralLink()"
                        >

                            <i class="bi bi-share me-2"></i>

                            Copy Package Referral Link

                        </button>


                    </div>


                @endif


            </div>


        @else


            {{-- =================================================
                NO PACKAGE SELECTED
            ================================================== --}}

            @if(isset($packages) && $packages->count())


                <div class="customer-content-card mt-4">


                    <div class="packages-empty">


                        <div class="empty-icon">

                            <i class="bi bi-diagram-3"></i>

                        </div>


                        <h3>
                            Select a Package
                        </h3>


                        <p>

                            Select one of your purchased packages
                            above to view its referral network.

                        </p>


                    </div>


                </div>


            @endif


        @endif


    </div>

</div>



{{-- =========================================================
    COPY REFERRAL LINK
========================================================= --}}

<script>

function copyReferralLink()
{
    const input =
        document.getElementById('referralLink');


    if (!input) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Modern Clipboard
    |--------------------------------------------------------------------------
    */

    if (navigator.clipboard) {

        navigator.clipboard
            .writeText(input.value)
            .then(function () {

                showCopied();

            })
            .catch(function () {

                fallbackCopy(input);

            });

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Fallback
    |--------------------------------------------------------------------------
    */

    fallbackCopy(input);
}



function fallbackCopy(input)
{
    input.select();

    input.setSelectionRange(
        0,
        99999
    );


    document.execCommand('copy');

    showCopied();
}



function showCopied()
{
    const buttons =
        document.querySelectorAll(
            '.referral-copy-btn'
        );


    buttons.forEach(function(button)
    {

        const original =
            button.innerHTML;


        button.innerHTML =
            '<i class="bi bi-check"></i> Copied';


        setTimeout(function()
        {

            button.innerHTML =
                original;

        }, 2000);

    });
}

</script>


@endsection