@extends('layout.mainlayout')

@section('title', 'Package Details')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="page-title">
                <h4>Package Details</h4>
                <h6>View package information</h6>
            </div>

            <div class="d-flex gap-2">
                {{-- <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>Edit
                </a> --}}

                <a href="{{ route('packages.all') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i>Back
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-4 col-lg-5 col-md-12 mb-4">

                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body text-center">

                        @if($package->image)
                            <img src="{{ asset( $package->image) }}"
                                 alt="Package Image"
                                 class="img-fluid rounded-3 border mb-3"
                                 style="max-height: 260px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mb-3"
                                 style="height: 260px;">
                                <i class="ti ti-photo text-muted" style="font-size: 48px;"></i>
                            </div>
                        @endif

                        <h5 class="fw-bold mb-1">{{ $package->name }}</h5>

                        <p class="text-muted mb-3">
                            {{ $package->code ?? 'No package code' }}
                        </p>

                        <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">

                            @if($package->is_popular)
                                <span class="badge bg-success px-3 py-2">Popular</span>
                            @endif

                            @if($package->is_featured)
                                <span class="badge bg-primary px-3 py-2">Featured</span>
                            @endif

                            @if($package->status)
                                <span class="badge bg-info px-3 py-2 text-dark">Active</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Inactive</span>
                            @endif

                        </div>

                        @if($package->icon)
                            <div class="border-top pt-3">
                                <p class="text-muted small mb-2">Package Icon</p>

                                <img src="{{ asset($package->icon) }}"
                                     alt="Package Icon"
                                     width="72"
                                     height="72"
                                     class="rounded border p-1 bg-white">
                            </div>
                        @endif

                    </div>

                </div>

            </div>

            <div class="col-xl-8 col-lg-7 col-md-12">

                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0">Pricing Information</h5>
                    </div>

                    <div class="card-body">

                        <div class="row g-3">

                            <div class="col-sm-6 col-lg-4">
                                <div class="border rounded-3 p-3 h-100 bg-light">
                                    <div class="text-muted small mb-1">Price</div>
                                    <div class="fw-bold text-success fs-5">
                                        ₹{{ number_format($package->price, 2) }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4">
                                <div class="border rounded-3 p-3 h-100 bg-light">
                                    <div class="text-muted small mb-1">Joining Amount</div>
                                    <div class="fw-semibold fs-5">
                                        ₹{{ number_format($package->joining_amount, 2) }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4">
                                <div class="border rounded-3 p-3 h-100 bg-light">
                                    <div class="text-muted small mb-1">Renewal Amount</div>
                                    <div class="fw-semibold fs-5">
                                        ₹{{ number_format($package->renewal_amount, 2) }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0">Package Information</h5>
                    </div>

                    <div class="card-body">

                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Package Name</div>
                                <div class="fw-semibold">{{ $package->name }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Package Code</div>
                                <div class="fw-semibold">{{ $package->code ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Slug</div>
                                <div class="fw-semibold">{{ $package->slug ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <div class="text-muted small mb-1">Sort Order</div>
                                <div class="fw-semibold">{{ $package->sort_order }}</div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0">Short Description</h5>
                    </div>

                    <div class="card-body">

                        <p class="mb-0 text-muted">
                            {{ $package->short_description ?: 'No short description available.' }}
                        </p>

                    </div>

                </div>

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="mb-0">Full Description</h5>
                    </div>

                    <div class="card-body">

                        @if($package->description)
                            <div class="package-description text-muted">
                                {!! nl2br(e($package->description)) !!}
                            </div>
                        @else
                            <p class="text-muted mb-0">No detailed description available.</p>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection