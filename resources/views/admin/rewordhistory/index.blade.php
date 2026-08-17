@extends('layout.mainlayout')

@section('title', 'Reward History')

@section('content')

    <div class="page-wrapper">
        <div class="content">

            <div class="page-header d-flex justify-content-between align-items-center">
                <div class="page-title">
                    <h4>Reward History</h4>
                    <h6>Manage customer reward transactions</h6>
                </div>

                {{-- <div class="page-btn">
                    <a href="javascript:void(0);" class="btn btn-primary">
                        <i class="ti ti-gift me-1"></i>
                        Reward History
                    </a>
                </div> --}}
            </div>

            <!-- Search -->
            <div class="card mb-3">
                <div class="card-body">

                    <form action="{{ route('admin.rewardhistory.index') }}" method="GET">

                        <div class="row align-items-end">

                            <div class="col-md-5">
                                <label class="form-label">Search</label>

                                <input type="text" name="search" class="form-control"
                                    placeholder="Search user, email, mobile, source..." value="{{ request('search') }}">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-search me-1"></i>
                                    Search
                                </button>

                                <a href="{{ route('admin.rewardhistory.index') }}" class="btn btn-light">
                                    Reset
                                </a>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

            <!-- Reward History List -->
            <div class="card">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>User</th>
                                    <th>Role</th>
                                    {{-- <th>Source</th> --}}
                                    <th>Reward Type</th>
                                    <th>Transaction</th>
                                    <th>Amount</th>
                                    <th>Opening</th>
                                    <th>Closing</th>
                                    <th>Status</th>
                                    <th>Reverted</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($rewards as $key => $reward)

                                    <tr>

                                        {{-- S.No --}}
                                        <td>
                                            {{ $rewards->firstItem() + $key }}
                                        </td>

                                        {{-- User --}}
                                        <td>
                                            @if($reward->customer)

                                                <div class="d-flex align-items-center">

                                                    @if($reward->customer->profile_pic)
                                                        <img src="{{ asset($reward->user->profile_pic) }}" alt="profile"
                                                            class="img-fluid rounded-circle border me-2"
                                                            style="width:40px;height:40px;object-fit:cover;">
                                                    @else
                                                        <img src="{{ URL::asset('build/img/users/user-32.jpg') }}" alt="profile"
                                                            class="img-fluid rounded-circle border me-2"
                                                            style="width:40px;height:40px;object-fit:cover;">
                                                    @endif

                                                    <div>
                                                        <h6 class="mb-0">
                                                            {{ $reward->customer->name ?? '-' }}
                                                        </h6>

                                                        <small class="text-muted">
                                                            {{ $reward->customer->mobile ?? $reward->customer->email ?? '-' }}
                                                        </small>
                                                    </div>

                                                </div>

                                            @else

                                                <span class="text-muted">
                                                    User #{{ $reward->user_id ?? '-' }}
                                                </span>

                                            @endif
                                        </td>

                                        {{-- Role --}}
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($reward->role ?? '-') }}
                                            </span>
                                        </td>

                                        {{-- Source --}}
                                        {{-- <td>

                                            <span class="fw-semibold">
                                                {{ ucfirst(str_replace('_', ' ', $reward->source_type ?? '-')) }}
                                            </span>

                                            @if($reward->source_id)
                                            <br>
                                            <small class="text-muted">
                                                ID: {{ $reward->source_id }}
                                            </small>
                                            @endif

                                        </td> --}}

                                        {{-- Reward Type --}}
                                        <td>
                                            @if($reward->reward_type == 'cashback')

                                                <span class="badge bg-primary">
                                                    Cashback
                                                </span>

                                            @elseif($reward->reward_type == 'points')

                                                <span class="badge bg-info">
                                                    Points
                                                </span>

                                            @elseif($reward->reward_type == 'voucher')

                                                <span class="badge bg-warning text-dark">
                                                    Voucher
                                                </span>

                                            @else

                                                <span class="badge bg-secondary">
                                                    {{ ucfirst(str_replace('_', ' ', $reward->reward_type) ?? '-') }}
                                                </span>

                                            @endif
                                        </td>

                                        {{-- Credit / Debit --}}
                                        <td>

                                            @if($reward->transaction_type == 'credit')

                                                <span class="text-success fw-semibold">
                                                    <i class="ti ti-arrow-down-left"></i>
                                                    Credit
                                                </span>

                                            @elseif($reward->transaction_type == 'debit')

                                                <span class="text-danger fw-semibold">
                                                    <i class="ti ti-arrow-up-right"></i>
                                                    Debit
                                                </span>

                                            @else

                                                <span class="text-muted">
                                                    {{ ucfirst(str_replace('_', ' ', $reward->transaction_type) ?? '-') }}
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Amount --}}
                                        <td>

                                            @if($reward->transaction_type == 'credit')

                                                <span class="text-success fw-semibold">
                                                    +₹{{ number_format($reward->amount ?? 0, 2) }}
                                                </span>

                                            @elseif($reward->transaction_type == 'debit')

                                                <span class="text-danger fw-semibold">
                                                    -₹{{ number_format($reward->amount ?? 0, 2) }}
                                                </span>

                                            @else

                                                ₹{{ number_format($reward->amount ?? 0, 2) }}

                                            @endif

                                        </td>

                                        {{-- Opening Balance --}}
                                        <td>
                                            ₹{{ number_format($reward->opening_balance ?? 0, 2) }}
                                        </td>

                                        {{-- Closing Balance --}}
                                        <td>
                                            <span class="fw-semibold">
                                                ₹{{ number_format($reward->closing_balance ?? 0, 2) }}
                                            </span>
                                        </td>

                                        {{-- Status --}}
                                        <td>

                                            @if($reward->status == 'credited')

                                                <span class="badge bg-success">
                                                    Credited
                                                </span>

                                            @elseif($reward->status == 'debited')

                                                <span class="badge bg-danger">
                                                    Debited
                                                </span>

                                            @elseif($reward->status == 'pending')

                                                <span class="badge bg-warning text-dark">
                                                    Pending
                                                </span>

                                            @elseif($reward->status == 'expired')

                                                <span class="badge bg-secondary">
                                                    Expired
                                                </span>

                                            @elseif($reward->status == 'reversed')

                                                <span class="badge bg-danger">
                                                    Reversed
                                                </span>

                                            @else

                                                <span class="badge bg-info">
                                                    {{ ucfirst($reward->status ?? '-') }}
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Reverted --}}
                                        <td>

                                            @if($reward->is_reverted == 1)

                                                <span class="badge bg-danger">
                                                    Yes
                                                </span>

                                            @else

                                                <span class="badge bg-success">
                                                    No
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Description --}}
                                        <td>
                                            {{ $reward->description ?? '-' }}
                                        </td>

                                        {{-- Created --}}
                                        <td>
                                            {{ $reward->created_at?->format('d M Y h:i A') }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-4">

                                            <i class="ti ti-gift fs-30 d-block mb-2"></i>

                                            No reward history found.

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- Pagination --}}
                    @if($rewards->hasPages())
                        <div class="p-3 border-top">
                            {{ $rewards->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

@endsection