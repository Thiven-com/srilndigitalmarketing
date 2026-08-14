@extends('layouts.website')

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            My Referrals
        </h2>

        <p class="text-muted mb-0">
            Users directly sponsored by you.
        </p>

    </div>


    {{-- Statistics --}}
    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <div class="text-muted mb-2">
                        Total Referrals
                    </div>

                    <h3 class="fw-bold mb-0">
                        {{ $totalReferrals }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- Referral List --}}
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 p-4">

            <h5 class="fw-bold mb-1">
                My Sponsored Users
            </h5>

            <p class="text-muted mb-0">
                Direct referrals under your sponsor ID.
            </p>

        </div>


        <div class="card-body p-0">

            @forelse($referrals as $key => $referral)

                <div class="d-flex align-items-center justify-content-between p-4 border-top">

                    <div class="d-flex align-items-center">

                        {{-- Profile --}}
                        @if($referral->profile_pic)

                            <img
                                src="{{ asset('storage/' . $referral->profile_pic) }}"
                                width="50"
                                height="50"
                                class="rounded-circle me-3"
                                style="object-fit: cover;"
                            >

                        @else

                            <div
                                class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                                style="width:50px;height:50px;"
                            >
                                <strong>
                                    {{ strtoupper(substr($referral->name ?? 'U', 0, 1)) }}
                                </strong>
                            </div>

                        @endif


                        {{-- User Details --}}
                        <div>

                            <h6 class="fw-bold mb-1">
                                {{ $referral->name }}
                            </h6>

                            <div class="small text-muted">

                                User ID:
                                <strong>
                                    {{ $referral->userid }}
                                </strong>

                            </div>

                            @if($referral->mobile)

                                <div class="small text-muted">
                                    {{ $referral->mobile }}
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- Status --}}
                    <div>

                        @if(
                            $referral->account_status === 'active'
                            || $referral->activation
                        )

                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                Active
                            </span>

                        @else

                            <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                Inactive
                            </span>

                        @endif

                    </div>

                </div>

            @empty

                <div class="text-center py-5">

                    <i class="bi bi-people fs-1 text-muted"></i>

                    <h5 class="fw-bold mt-3">
                        No Referrals Yet
                    </h5>

                    <p class="text-muted mb-0">
                        Users you sponsor will appear here.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection