<?php $page = 'employees-list'; ?>
@extends('layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="page-header d-flex flex-wrap align-items-center justify-content-between">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Level Team Count</h4>
                        <h6>T20 Team Overview</h6>
                    </div>
                </div>

                <div>
                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary">
                        <i class="ti ti-home"></i> Home
                    </a>

                    <button type="button" onclick="history.back()" class="btn btn-danger">
                        <i class="ti ti-arrow-left"></i> Back
                    </button>
                </div>
            </div>
            <div class="search-box">
                <form id="searchForm" class="search-form">

                    <input type="text" name="userid" id="userid" placeholder="🔍 Enter User ID"
                        value="{{ request('userid', $data['userId'] ?? '') }}" required>

                    <button type="submit">
                        Search User
                    </button>

                </form>
            </div>

            @if(isset($data['userId']))
                <div class="alert alert-info">
                    <strong>User ID :</strong> {{ $data['userId'] }}
                </div>
            @endif

            @php
                $totalMembers = 0;
                $totalIncome = 0;
            @endphp

            @php
                $totalMembers = collect($data['levelCounts'] ?? [])->sum();
                $totalIncome = $totalMembers * 10;
            @endphp

            <div class="card">

                <div class="card-header">
                    <h5 class="mb-0">Level Wise Income Report</h5>
                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <thead class="thead-light">
                                <tr>
                                    {{-- <th width="10%">S.No</th> --}}
                                    <th width="25%">Level</th>
                                    <th width="30%">Members</th>
                                    <th width="35%">Income</th>
                                </tr>
                            </thead>

                            <tbody>

                                @for($i = 1; $i <= 20; $i++)

                                    @php
                                        $members = $data['levelCounts'][$i] ?? 0;
                                        $income = $members * 10;
                                    @endphp

                                    <tr>

                                        {{-- <td>{{ $i }}</td> --}}

                                        <td>
                                            {{ $i }}
                                            {{ $i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th')) }}
                                            Level
                                        </td>

                                        <td>
                                            {{ number_format($members) }}
                                            {{-- × 10 --}}
                                        </td>

                                        <td>
                                            ₹{{ number_format($income) }}
                                        </td>

                                    </tr>

                                @endfor

                                <tr class="table-success">

                                    <th >
                                        Total
                                    </th>

                                    <th>
                                        {{ number_format($totalMembers) }}
                                    </th>

                                    <th>
                                        ₹{{ number_format($totalIncome) }}
                                    </th>

                                </tr>
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>
    <style>
        .search-box {
            padding: 20px;
            background: #fff;
            border-bottom: 1px solid #eef2f7;
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-form input {
            flex: 1;
            height: 50px;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 0 18px;
            font-size: 15px;
            font-weight: 500;
            color: #334155;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .search-form input::placeholder {
            color: #94a3b8;
        }

        .search-form input:focus {
            outline: none;
            background: #fff;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .search-form button {
            height: 50px;
            padding: 0 25px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .search-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);
        }

        .search-form button:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {

            .search-form {
                flex-direction: column;
            }

            .search-form input,
            .search-form button {
                width: 100%;
            }
        }
    </style>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let userid = document.getElementById('userid').value.trim();

            if (userid) {
                window.location.href =
                    "{{ url('admin/t20-table') }}/" + userid;
            }
        });
    </script>
@endsection