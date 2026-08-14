@extends('layouts.website')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Package Details
            </h2>

            <p class="text-muted mb-0">
                View your package and purchase information.
            </p>

        </div>

        <a
            href="{{ route('customer.packages') }}"
            class="btn btn-outline-secondary"
        >
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>

    </div>


    <div class="row g-4">

        {{-- Package Information --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Package Information
                    </h5>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Package
                        </span>

                        <strong>
                            {{ $purchase->package->name ?? 'Package' }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Package Code
                        </span>

                        <strong>
                            {{ $purchase->package->code ?? '-' }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Tree Type
                        </span>

                        <strong>
                            {{ ucwords(str_replace('_', ' ', $purchase->package->tree_type ?? '-')) }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Package Price
                        </span>

                        <strong>
                            ₹{{ number_format($purchase->package->price ?? 0, 2) }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Joining Amount
                        </span>

                        <strong>
                            ₹{{ number_format($purchase->joining_amount ?? 0, 2) }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between">

                        <span class="text-muted">
                            Total Amount
                        </span>

                        <strong class="text-success">
                            ₹{{ number_format($purchase->total_amount ?? 0, 2) }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- Purchase Information --}}
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Purchase Information
                    </h5>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Order Number
                        </span>

                        <strong>
                            {{ $purchase->order_number }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Payment Method
                        </span>

                        <strong>
                            {{ strtoupper($purchase->payment_method) }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Payment Reference
                        </span>

                        <strong>
                            {{ $purchase->payment_reference ?? '-' }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Purchase Date
                        </span>

                        <strong>
                            {{ $purchase->created_at->format('d M Y h:i A') }}
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between">

                        <span class="text-muted">
                            Status
                        </span>

                        @if($purchase->payment_status === 'approved')

                            <span class="badge bg-success">
                                Approved
                            </span>

                        @elseif($purchase->payment_status === 'rejected')

                            <span class="badge bg-danger">
                                Rejected
                            </span>

                        @else

                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- Package Description --}}
        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        About This Package
                    </h5>

                    <p class="text-muted mb-0">

                        {{ $purchase->package->description ?? 'No description available.' }}

                    </p>

                </div>

            </div>

        </div>


        {{-- Tree Button --}}
        @if($purchase->payment_status === 'approved')

            <div class="col-12">

                <div class="text-center">

                    <a
                        href="{{ route('customer.package.tree', $purchase->id) }}"
                        class="btn btn-primary px-5 rounded-3"
                    >
                        <i class="bi bi-diagram-3 me-2"></i>
                        View My Package Tree
                    </a>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection