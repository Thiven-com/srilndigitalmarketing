@extends('layouts.website')

@section('content')

<div class="container py-5">

    {{-- Page Header --}}
    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h2 class="fw-bold mb-1">
                    My Packages
                </h2>

                <p class="text-muted mb-0">
                    View your lifetime package purchases, payment status and tree details.
                </p>

            </div>

            <a
                href="{{ route('customer.packages') }}"
                class="btn btn-outline-success rounded-pill px-4"
            >
                <i class="bi bi-plus-circle me-1"></i>
                Browse Packages
            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success rounded-3 border-0">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="alert alert-danger rounded-3 border-0">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>

    @endif


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="alert alert-danger rounded-3 border-0">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- Packages --}}
    <div class="row g-4">

        @forelse($packages as $purchase)

            <div class="col-lg-6 col-xl-4">

                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                    {{-- Card Header --}}
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start gap-3">

                            <div>

                                <h5 class="fw-bold mb-1">

                                    {{ $purchase->package->name ?? 'Package' }}

                                </h5>

                                <small class="text-muted">

                                    {{ $purchase->order_number }}

                                </small>

                            </div>


                            {{-- Status --}}
                            @if($purchase->payment_status === 'approved')

                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">

                                    <i class="bi bi-check-circle me-1"></i>
                                    Approved

                                </span>

                            @elseif($purchase->payment_status === 'rejected')

                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                                    <i class="bi bi-x-circle me-1"></i>
                                    Rejected

                                </span>

                            @else

                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">

                                    <i class="bi bi-clock me-1"></i>
                                    Pending

                                </span>

                            @endif

                        </div>


                        <hr>


                        {{-- Package Details --}}
                        <div class="mb-3">

                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Package
                                </span>

                                <strong>
                                    {{ $purchase->package->name ?? '-' }}
                                </strong>

                            </div>


                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Package Code
                                </span>

                                <span>
                                    {{ $purchase->package->code ?? '-' }}
                                </span>

                            </div>


                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Tree Type
                                </span>

                                <span class="text-capitalize">

                                    {{ str_replace('_', ' ', $purchase->package->tree_type ?? '-') }}

                                </span>

                            </div>


                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Amount
                                </span>

                                <strong>
                                    ₹{{ number_format($purchase->total_amount, 2) }}
                                </strong>

                            </div>


                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Payment
                                </span>

                                <span>
                                    {{ strtoupper($purchase->payment_method ?? '-') }}
                                </span>

                            </div>


                            <div class="d-flex justify-content-between">

                                <span class="text-muted">
                                    Purchased
                                </span>

                                <span>

                                    {{ $purchase->created_at
                                        ? $purchase->created_at->format('d M Y')
                                        : '-' }}

                                </span>

                            </div>

                        </div>


                        {{-- Approved --}}
                        @if($purchase->payment_status === 'approved')

                            <div class="alert alert-success border-0 rounded-3 mb-3">

                                <div class="d-flex align-items-center">

                                    <i class="bi bi-check-circle fs-5 me-2"></i>

                                    <div>

                                        <strong>
                                            Package Active
                                        </strong>

                                        <div class="small">
                                            Your package has been approved and added to the tree.
                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- Action Buttons --}}
                            <div class="row g-2">

                                <div class="col-6">

                                    <a
                                        href="{{ route('customer.package.details', $purchase->id) }}"
                                        class="btn btn-outline-success w-100 rounded-3"
                                    >

                                        <i class="bi bi-box-seam me-1"></i>

                                        Details

                                    </a>

                                </div>


                                <div class="col-6">

                                    <a
                                        href="{{ route('customer.package.tree', $purchase->id) }}"
                                        class="btn btn-success w-100 rounded-3"
                                    >

                                        <i class="bi bi-diagram-3 me-1"></i>

                                        View Tree

                                    </a>

                                </div>

                            </div>


                        {{-- Rejected --}}
                        @elseif($purchase->payment_status === 'rejected')

                            @if($purchase->admin_remark)

                                <div class="alert alert-danger border-0 rounded-3 mb-3">

                                    <strong>

                                        <i class="bi bi-exclamation-circle me-1"></i>

                                        Admin Remark:

                                    </strong>

                                    <div class="mt-1">

                                        {{ $purchase->admin_remark }}

                                    </div>

                                </div>

                            @endif


                            {{-- Re-purchase --}}
                            <a
                                href="{{ route('customer.packages') }}"
                                class="btn btn-outline-success w-100 rounded-3"
                            >

                                <i class="bi bi-arrow-repeat me-1"></i>

                                Purchase Again

                            </a>


                        {{-- Pending --}}
                        @else

                            <div class="alert alert-warning border-0 rounded-3 mb-3">

                                <div class="d-flex align-items-center">

                                    <i class="bi bi-clock fs-5 me-2"></i>

                                    <div>

                                        <strong>
                                            Payment Verification Pending
                                        </strong>

                                        <div class="small">

                                            Admin approval is required before this package becomes active.

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- Details available for pending purchase --}}
                            <a
                                href="{{ route('customer.package.details', $purchase->id) }}"
                                class="btn btn-outline-secondary w-100 rounded-3"
                            >

                                <i class="bi bi-eye me-1"></i>

                                View Details

                            </a>

                        @endif

                    </div>

                </div>

            </div>


        @empty

            {{-- Empty State --}}
            <div class="col-12">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body text-center py-5">

                        <div class="mb-3">

                            <i class="bi bi-box-seam fs-1 text-muted"></i>

                        </div>


                        <h5 class="fw-bold">

                            No Packages Purchased Yet

                        </h5>


                        <p class="text-muted mb-4">

                            You haven't purchased any package yet.

                        </p>


                        <a
                            href="{{ route('customer.packages') }}"
                            class="btn btn-success rounded-pill px-4"
                        >

                            <i class="bi bi-cart-plus me-1"></i>

                            Browse Packages

                        </a>

                    </div>

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection