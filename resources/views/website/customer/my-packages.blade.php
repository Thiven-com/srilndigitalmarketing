@extends('layouts.website')

@section('content')

<div class="container py-5">

    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            My Packages
        </h2>

        <p class="text-muted mb-0">
            View your lifetime package purchases and payment status.
        </p>

    </div>


    @if(session('success'))

        <div class="alert alert-success rounded-3">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger rounded-3">
            {{ session('error') }}
        </div>

    @endif


    <div class="row g-4">

        @forelse($packages as $purchase)

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm rounded-4 h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    {{ $purchase->package->name ?? 'Package' }}
                                </h5>

                                <small class="text-muted">
                                    {{ $purchase->order_number }}
                                </small>

                            </div>


                            @if($purchase->payment_status === 'approved')

                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                    Approved
                                </span>

                            @elseif($purchase->payment_status === 'rejected')

                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                    Rejected
                                </span>

                            @else

                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                    Pending
                                </span>

                            @endif

                        </div>


                        <hr>


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
                                {{ strtoupper($purchase->payment_method) }}
                            </span>

                        </div>


                        <div class="d-flex justify-content-between">

                            <span class="text-muted">
                                Purchased
                            </span>

                            <span>
                                {{ $purchase->created_at->format('d M Y') }}
                            </span>

                        </div>


                        @if($purchase->payment_status === 'approved')

                            <div class="mt-4">

                                <div class="alert alert-success border-0 mb-0">

                                    <i class="bi bi-check-circle me-2"></i>

                                    Package is active.

                                </div>

                            </div>

                        @elseif($purchase->payment_status === 'rejected')

                            @if($purchase->admin_remark)

                                <div class="mt-4">

                                    <div class="alert alert-danger border-0 mb-0">

                                        <strong>
                                            Admin Remark:
                                        </strong>

                                        <div class="mt-1">
                                            {{ $purchase->admin_remark }}
                                        </div>

                                    </div>

                                </div>

                            @endif

                        @else

                            <div class="mt-4">

                                <div class="alert alert-warning border-0 mb-0">

                                    <i class="bi bi-clock me-2"></i>

                                    Payment verification is pending.

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="text-center py-5">

                    <i class="bi bi-box-seam fs-1 text-muted"></i>

                    <h5 class="mt-3">
                        No packages purchased yet
                    </h5>

                    <a
                        href="{{ route('customer.packages') }}"
                        class="btn btn-success mt-3"
                    >
                        Browse Packages
                    </a>

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection