@extends('layouts.website')
@section('content')

    <div class="container py-5">

        <div class="row justify-content-center">
            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">

                    <i class="bi bi-check-circle me-2"></i>

                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                </div>

            @endif


            {{-- ERROR MESSAGE --}}
            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    {{ session('error') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                </div>

            @endif


            {{-- VALIDATION ERRORS --}}
            @if($errors->any())

                <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">

                    <div class="fw-bold mb-2">

                        <i class="bi bi-exclamation-circle me-2"></i>

                        Please correct the following errors:

                    </div>

                    <ul class="mb-0 ps-4">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif
            <div class="col-lg-9">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                    <div class="card-body p-4 p-lg-5">

                        <div class="text-center mb-4">

                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                Lifetime Package
                            </span>

                            <h2 class="fw-bold mt-3 mb-2">
                                {{ $package->name }}
                            </h2>

                            <p class="text-muted mb-0">
                                Complete your payment to activate this package.
                            </p>

                        </div>


                        {{-- Package Amount --}}

                        <div class="text-center mb-4">

                            <div class="text-muted">
                                Package Amount
                            </div>

                            <h1 class="fw-bold text-success">
                                ₹{{ number_format($package->price, 2) }}
                            </h1>

                        </div>


                        <div class="row g-4">


                            {{-- QR SECTION --}}

                            <div class="col-lg-5">

                                <div class="bg-light rounded-4 p-4 text-center h-100">

                                    <h5 class="fw-bold mb-3">
                                        Scan & Pay
                                    </h5>

                                    <div class="bg-white rounded-4 p-3 d-inline-block shadow-sm">

                                        <img src="{{ asset('website/images/payment-qr.png') }}" alt="Payment QR"
                                            class="img-fluid" style="width:220px;height:220px;object-fit:contain;">

                                    </div>

                                    <p class="text-muted small mt-3 mb-0">
                                        Scan this QR code using your UPI app
                                        and complete the payment.
                                    </p>

                                </div>

                            </div>


                            {{-- FORM --}}

                            <div class="col-lg-7">

                                <form action="{{ route('customer.package.purchase.store', $package->id) }}" method="POST"
                                    enctype="multipart/form-data">

                                    @csrf


                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">
                                            Payment Reference / UTR
                                        </label>

                                        <input type="text" name="payment_reference" class="form-control form-control-lg"
                                            placeholder="Enter UTR / Transaction ID" value="{{ old('payment_reference') }}">

                                        @error('payment_reference')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    <div class="mb-4">

                                        <label class="form-label fw-semibold">
                                            Payment Receipt
                                        </label>

                                        <input type="file" name="payment_receipt" class="form-control form-control-lg"
                                            accept="image/jpeg,image/png,image/webp" required>

                                        <div class="form-text">
                                            JPG, PNG or WEBP. Maximum 5 MB.
                                        </div>

                                        @error('payment_receipt')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    <div class="alert alert-warning border-0 rounded-3">

                                        <div class="fw-semibold mb-1">
                                            Important
                                        </div>

                                        <small>
                                            Please make the exact payment and
                                            upload a clear payment receipt.
                                            Your package will be activated only
                                            after admin verification.
                                        </small>

                                    </div>


                                    <button type="submit" class="btn btn-success btn-lg w-100 rounded-3">

                                        <i class="bi bi-cloud-arrow-up me-2"></i>

                                        Submit Payment

                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection