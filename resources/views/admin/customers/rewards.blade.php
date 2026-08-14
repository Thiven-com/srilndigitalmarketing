@extends('admin.customers.customer_menu')
@section('customer')
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="tab-content">
                @if(session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                @endif
                <div class="tab-pane fade show active">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">

                            @if($rewards->count() > 0)
                                <div class="table-responsive">
                                    <table class="table align-middle table-hover">

                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Amount</th>
                                                <th>Opening Balance</th>
                                                <th>Closing Balance</th>
                                                <th>Type</th>
                                                <th>Note</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($rewards as $key => $reward)
                                                <tr>
                                                    <td>#{{ $reward->id }}</td>
                                                    <td class="fw-semibold">
                                                        ₹ {{ number_format($reward->amount, 2) }}
                                                    </td>
                                                    <td class="fw-semibold">
                                                        @if ($reward->opening_balance > 0)
                                                            ₹ {{ number_format($reward->opening_balance, 2) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="fw-semibold">
                                                        ₹ {{ number_format($reward->closing_balance, 2) }}
                                                    </td>

                                                    <td>
                                                        <span
                                                            class="badge {{ $reward->transaction_type == 'credit' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ ucfirst($reward->transaction_type) }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        {{ $reward->description ?? '-' }}
                                                    </td>

                                                    <td class="text-muted">
                                                        {{ $reward->created_at->format('d M Y, h:i A') }}
                                                    </td>
                                                  
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>


                                <div class="d-flex justify-content-center mt-4">
                                    {{ $rewards->links('pagination::bootstrap-5') }}
                                </div>

                            @else

                                <div class="text-center py-5">
                                    <i class="ti ti-gift fs-32 text-muted"></i>
                                    <p class="text-muted mt-2">
                                        No rewards for this customer
                                    </p>
                                </div>

                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmConversion() {
            return confirm('Are you sure you want to convert this customer?');
        }
    </script>
@endsection