<?php $page = 'index'; ?>
@extends('layout.mainlayout')

@section('content')

    <style>
        body {
            background: #f4f7fb;
        }

        /* ================= HEADER ================= */

        .dashboard-header {
            background: linear-gradient(100deg, #ff4f9a, #ffb6d9, #8b5cf6);
            border-radius: 24px;
            padding: 35px;
            color: #fff;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            right: -80px;
            top: -80px;
        }

        .dashboard-header h2 {
            font-weight: 700;
            margin-bottom: 6px;
            color: #fff;

        }

        .dashboard-header p {
            opacity: .9;
            margin-bottom: 0;
        }

        /* ================= CARDS ================= */

        .dashboard-card {
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
            transition: .3s;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            right: -25px;
            top: -25px;
            background: rgba(79, 70, 229, .05);
        }

        .card-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            margin-bottom: 18px;
        }

        .bg-primary-gradient {
            background: linear-gradient(135deg, #4f46e5, #2563eb);
        }

        .bg-success-gradient {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .bg-warning-gradient {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .bg-danger-gradient {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .bg-info-gradient {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .bg-dark-gradient {
            background: linear-gradient(135deg, #111827, #1f2937);
        }

        .dashboard-card h6 {
            color: #64748b;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .dashboard-card h3 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .dashboard-card p {
            margin: 0;
            color: #94a3b8;
            font-size: 13px;
        }

        /* ================= TABLE ================= */

        .custom-table-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
            overflow: hidden;
        }

        .custom-table-header {
            padding: 22px;
            border-bottom: 1px solid #f1f5f9;
        }

        .custom-table-header h5 {
            margin: 0;
            font-weight: 700;
        }

        .custom-table {
            margin: 0;
        }

        .custom-table thead {
            background: #f8fafc;
        }

        .custom-table thead th {
            border: none;
            padding: 16px;
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
        }

        .custom-table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-top: 1px solid #f1f5f9;
        }

        .custom-table tbody tr:hover {
            background: #f8fafc;
        }

        /* ================= BADGES ================= */

        .badge-soft-success {
            background: #ecfdf5;
            color: #059669;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-soft-warning {
            background: #fffbeb;
            color: #d97706;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-soft-danger {
            background: #fef2f2;
            color: #dc2626;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-soft-info {
            background: #eff6ff;
            color: #2563eb;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        /* ================= CUSTOMER ================= */

        .customer-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .customer-avatar {
            width: 45px;
            height: 45px;
            border-radius: 14px;
            background: linear-gradient(135deg, #4f46e5, #2563eb);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* ================= FOOTER ================= */

        .dashboard-footer {
            background: #fff;
            border-radius: 18px;
            padding: 18px 24px;
            margin-top: 28px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, .05);
        }

        @media(max-width:768px) {

            .dashboard-header {
                padding: 24px;
            }

            .dashboard-card {
                margin-bottom: 20px;
            }
        }
    </style>

    <div class="page-wrapper">

        <div class="content">

            {{-- ================= HEADER ================= --}}

            <div class="dashboard-header">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>
                        <h2>Welcome Back, Admin 👋</h2>
                        <p>
                            Monitor customers, activities, subscriptions and payments.
                        </p>
                    </div>

                    <div>
                        <span class="badge bg-light text-dark px-3 py-2">
                            {{ now()->format('d M Y') }}
                        </span>
                    </div>

                </div>

            </div>
            {{-- ================= STATS CARDS ================= --}}

            <div class="row g-4 mb-4">

                {{-- PACKAGE 1 --}}
                <div class="col-xl-4 col-lg-6 col-md-6">

                    <div class="dashboard-card">

                        <div class="card-icon bg-warning-gradient">
                            <i class="ti ti-cash"></i>
                        </div>

                        <h6>
                            Three Way Commission
                        </h6>

                        <h3>
                            ₹{{ number_format($package1Commission ?? 0, 2) }}
                        </h3>

                        <p>
                            Admin commission generated from Three Way rewards.
                        </p>

                    </div>

                </div>


                {{-- PACKAGE 2 --}}
                <div class="col-xl-4 col-lg-6 col-md-6">

                    <div class="dashboard-card">

                        <div class="card-icon bg-primary-gradient">
                            <i class="ti ti-cash"></i>
                        </div>

                        <h6>
                            F & I Promotes Commission
                        </h6>

                        <h3>
                            ₹{{ number_format($package2Commission ?? 0, 2) }}
                        </h3>

                        <p>
                            Admin commission generated from F & I Promotes rewards.
                        </p>

                    </div>

                </div>


                {{-- PACKAGE 3 --}}
                <div class="col-xl-4 col-lg-6 col-md-6">

                    <div class="dashboard-card">

                        <div class="card-icon bg-success-gradient">
                            <i class="ti ti-cash"></i>
                        </div>

                        <h6>
                            Mini Web Commission
                        </h6>

                        <h3>
                            ₹{{ number_format($package3Commission ?? 0, 2) }}
                        </h3>

                        <p>
                            Admin commission generated from Mini Web rewards.
                        </p>

                    </div>

                </div>
            </div>


            {{-- ================= GENERAL STATISTICS ================= --}}

            <div class="row g-4 mb-4">

                {{-- TOTAL PACKAGES --}}
                <div class="col-xl-6 col-md-6">

                    <div class="dashboard-card">

                        <div class="card-icon bg-primary-gradient">
                            <i class="ti ti-package"></i>
                        </div>

                        <h6>
                            Total Packages
                        </h6>

                        <h3>
                            {{ $totalPackages }}
                        </h3>

                        <p>
                            All active and inactive packages available in the system.
                        </p>

                    </div>

                </div>


                {{-- TOTAL CUSTOMERS --}}
                <div class="col-xl-6 col-md-6">

                    <div class="dashboard-card">

                        <div class="card-icon bg-success-gradient">
                            <i class="ti ti-users"></i>
                        </div>

                        <h6>
                            Total Customers
                        </h6>

                        <h3>
                            {{ $totalCustomers }}
                        </h3>

                        <p>
                            Registered customers currently available in the platform.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection