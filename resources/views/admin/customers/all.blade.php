@extends('layout.mainlayout')

@section('title', 'Customers')

@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div class="page-title">
                    <h4>Customers</h4>
                    <h6>Manage your customers</h6>
                </div>

                <div class="page-btn">
                    <a href="javascript:void(0);" class="btn btn-primary">
                        <i class="ti ti-users me-1"></i>Customers
                    </a>
                </div>
            </div>

            <!-- Customer List -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Wallet</th>
                                    <th>Rewards</th>
                                    <th>KYC</th>
                                    <th>Verified</th>
                                    <th>Blocked</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($customers as $key => $customer)
                                    <tr>

                                        <td>{{ $customers->firstItem() + $key }}</td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($customer->profile_pic)
                                                    <img src="{{ asset($customer->profile_pic) }}" alt="profile"
                                                        class="img-fluid rounded-circle border"
                                                        style="width:50px;height:50px;object-fit:cover;">
                                                @else
                                                    <img src="{{ URL::asset('build/img/users/user-32.jpg') }}" alt="profile"
                                                        class="img-fluid rounded-circle border"
                                                        style="width:50px;height:50px;object-fit:cover;">
                                                @endif
                                            </div>
                                        </td>

                                        <td>{{ $customer->name ?? '-' }}</td>
                                        <td>{{ $customer->email ?? '-' }}</td>
                                        <td>{{ $customer->mobile ?? '-' }}</td>

                                        <td>
                                            <span class="text-success fw-semibold">
                                                ₹{{ number_format($customer->wallet ?? 0, 2) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="text-primary fw-semibold">
                                                {{ number_format($customer->rewards ?? 0, 2) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($customer->kyc_status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($customer->kyc_status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($customer->mobile_verified == 'yes')
                                                <span class="badge bg-success">Yes</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($customer->is_block == 'yes')
                                                <span class="badge bg-danger">Blocked</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="badge bg-info text-dark">
                                                {{ ucfirst($customer->account_status ?? 'pending') }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $customer->created_at->format('d M Y') }}
                                        </td>
                                        <td class="text-center">

                                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="action-btn">

                                                <i class="ti ti-eye"></i>

                                            </a>

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-muted py-4">
                                            No customers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    <div class="p-3 border-top">
                        {{ $customers->links() }}
                    </div>

                </div>
            </div>
            <!-- /Customer List -->

        </div>

    </div>

@endsection