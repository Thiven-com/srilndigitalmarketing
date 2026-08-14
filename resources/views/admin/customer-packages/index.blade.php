@extends('layout.mainlayout')

@section('title', 'Customer Packages')

@section('content')

<div class="page-wrapper">

    <div class="content">

        {{-- PAGE HEADER --}}
        <div class="page-header d-flex justify-content-between align-items-center">

            <div class="page-title">

                <h4>Customer Packages</h4>

                <h6>
                    Manage package purchases and payment approvals
                </h6>

            </div>

        </div>


        {{-- FILTER CARD --}}
        <div class="card">

            <div class="card-body">

                <form method="GET">

                    <div class="row align-items-end g-3">

                        {{-- SEARCH --}}
                        <div class="col-lg-4 col-md-6">

                            <label class="form-label">
                                Search
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>

                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="Order, UTR, customer name, mobile..."
                                    value="{{ request('search') }}"
                                >

                            </div>

                        </div>


                        {{-- PAYMENT STATUS --}}
                        <div class="col-lg-3 col-md-6">

                            <label class="form-label">
                                Payment Status
                            </label>

                            <select
                                name="payment_status"
                                class="form-select"
                            >

                                <option value="">
                                    All Payment Status
                                </option>

                                <option
                                    value="pending"
                                    @selected(request('payment_status') === 'pending')
                                >
                                    Pending
                                </option>

                                <option
                                    value="approved"
                                    @selected(request('payment_status') === 'approved')
                                >
                                    Approved
                                </option>

                                <option
                                    value="rejected"
                                    @selected(request('payment_status') === 'rejected')
                                >
                                    Rejected
                                </option>

                            </select>

                        </div>


                        {{-- PACKAGE STATUS --}}
                        <div class="col-lg-3 col-md-6">

                            <label class="form-label">
                                Package Status
                            </label>

                            <select
                                name="package_status"
                                class="form-select"
                            >

                                <option value="">
                                    All Package Status
                                </option>

                                <option
                                    value="pending"
                                    @selected(request('package_status') === 'pending')
                                >
                                    Pending
                                </option>

                                <option
                                    value="active"
                                    @selected(request('package_status') === 'active')
                                >
                                    Active
                                </option>

                                <option
                                    value="rejected"
                                    @selected(request('package_status') === 'rejected')
                                >
                                    Rejected
                                </option>

                            </select>

                        </div>


                        {{-- SEARCH BUTTON --}}
                        <div class="col-lg-2 col-md-6">

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >

                                <i class="ti ti-search me-1"></i>

                                Search

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- CUSTOMER PACKAGES TABLE --}}
        <div class="card">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table">

                        <thead class="thead-light">

                            <tr>

                                <th>#</th>

                                <th>Order</th>

                                <th>Customer</th>

                                <th>Package</th>

                                <th>Amount</th>

                                <th>Payment</th>

                                <th>Package Status</th>

                                <th>Date</th>

                                <th>Action</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($customerPackages as $key => $item)

                                <tr>

                                    {{-- NUMBER --}}
                                    <td>
                                        {{ $customerPackages->firstItem() + $key }}
                                    </td>


                                    {{-- ORDER --}}
                                    <td>

                                        <strong>
                                            {{ $item->order_number }}
                                        </strong>

                                        @if($item->payment_reference)

                                            <small class="d-block text-muted mt-1">

                                                UTR:
                                                {{ $item->payment_reference }}

                                            </small>

                                        @endif

                                    </td>


                                    {{-- CUSTOMER --}}
                                    <td>

                                        <div>

                                            <strong>
                                                {{ $item->customer->name ?? '-' }}
                                            </strong>

                                            <small class="d-block text-muted">

                                                {{ $item->customer->mobile ?? '-' }}

                                            </small>

                                        </div>

                                    </td>


                                    {{-- PACKAGE --}}
                                    <td>

                                        <strong>
                                            {{ $item->package->name ?? '-' }}
                                        </strong>

                                        @if(isset($item->package->code))

                                            <small class="d-block text-muted">

                                                {{ $item->package->code }}

                                            </small>

                                        @endif

                                    </td>


                                    {{-- AMOUNT --}}
                                    <td>

                                        <strong>
                                            ₹{{ number_format($item->total_amount, 2) }}
                                        </strong>

                                    </td>


                                    {{-- PAYMENT STATUS --}}
                                    <td>

                                        @if($item->payment_status === 'approved')

                                            <span class="badge bg-success">

                                                <i class="ti ti-check me-1"></i>

                                                Approved

                                            </span>

                                        @elseif($item->payment_status === 'rejected')

                                            <span class="badge bg-danger">

                                                <i class="ti ti-x me-1"></i>

                                                Rejected

                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark">

                                                <i class="ti ti-clock me-1"></i>

                                                Pending

                                            </span>

                                        @endif

                                    </td>


                                    {{-- PACKAGE STATUS --}}
                                    <td>

                                        @if($item->package_status === 'active')

                                            <span class="badge bg-success">

                                                <i class="ti ti-circle-check me-1"></i>

                                                Active

                                            </span>

                                        @elseif($item->package_status === 'rejected')

                                            <span class="badge bg-danger">

                                                <i class="ti ti-circle-x me-1"></i>

                                                Rejected

                                            </span>

                                        @else

                                            <span class="badge bg-secondary">

                                                <i class="ti ti-clock me-1"></i>

                                                Pending

                                            </span>

                                        @endif

                                    </td>


                                    {{-- DATE --}}
                                    <td>

                                        {{ optional($item->created_at)->format('d M Y') }}

                                        <small class="d-block text-muted">

                                            {{ optional($item->created_at)->format('h:i A') }}

                                        </small>

                                    </td>


                                    {{-- ACTION --}}
                                    <td class="action-table-data">

                                        <div class="edit-delete-action">

                                            {{-- VIEW --}}
                                            <a
                                                href="{{ route('admin.customer-packages.show', $item->id) }}"
                                                class="me-2 p-2 btn btn-sm btn-info text-white"
                                                title="View"
                                            >

                                                <i
                                                    data-feather="eye"
                                                    class="feather-eye"
                                                ></i>

                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="9"
                                        class="text-center py-5"
                                    >

                                        <div class="text-muted">

                                            <i
                                                class="ti ti-package-off fs-2 d-block mb-2"
                                            ></i>

                                            No customer package purchases found.

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- PAGINATION --}}
                @if($customerPackages->hasPages())

                    <div class="p-3 border-top">

                        {{ $customerPackages->withQueryString()->links() }}

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection