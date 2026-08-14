<?php $page = 'customer-details'; ?>
@extends('layout.mainlayout')

@section('content')
    <style>
        .profile-avatar-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-avatar,
        .default-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
        }

        .default-avatar {
            background: linear-gradient(100deg, #ff4f9a, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 34px;
        }
    </style>
    <div class="page-wrapper">
        <div class="content">

            {{-- ================= HEADER ================= --}}
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <a href="{{ route('admin.customers.all') }}" class="btn btn-light border rounded-pill px-3">
                        <i class="ti ti-arrow-left me-1"></i> Back
                    </a>
                </div>

                {{-- <div class="d-flex gap-2">
                    <button class="btn btn-primary rounded-pill px-3">
                        <i class="ti ti-edit me-1"></i> Edit Customer
                    </button>
                </div> --}}
            </div>


            {{-- ================= PROFILE CARD ================= --}}
            <div class="card border-0 shadow-lg overflow-hidden mb-4 customer-profile-card">
                @if (session('message'))

                    @if (session('success') == 1)

                        <div class="alert alert-success alert-dismissible fade show" role="alert">

                            <strong>Success!</strong> {{ session('message') }}

                            <button type="button" class="btn-close" data-bs-dismiss="alert">
                            </button>

                        </div>

                    @else

                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            <strong>Error!</strong> {{ session('message') }}

                            <button type="button" class="btn-close" data-bs-dismiss="alert">
                            </button>

                        </div>

                    @endif

                @endif
                {{-- Top Gradient --}}
                <div class="profile-cover"></div>

                <div class="card-body position-relative">

                    <div class="row align-items-center">

                        {{-- LEFT --}}
                        <div class="col-lg-6">

                            <div class="d-flex align-items-center flex-wrap gap-3">

                                {{-- Avatar --}}
                                <div class="profile-avatar-wrapper">

                                    @if(!empty($customer->profile_pic) && file_exists(public_path($customer->profile_pic)))

                                        <img src="{{ asset($customer->profile_pic) }}" class="profile-avatar">

                                    @else

                                        <div class="default-avatar">

                                            <i class="fa fa-user"></i>

                                        </div>

                                    @endif

                                </div>

                                {{-- Info --}}
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <h3 class="mb-0 fw-bold text-dark">
                                            {{ $customer->name ?? 'Customer' }}
                                        </h3>
                                    </div>

                                    <div class="mt-2 text-muted">
                                        <div class="mb-1">
                                            <i class="ti ti-phone me-1 text-primary"></i>
                                            {{ $customer->mobile ?? 'N/A' }}
                                        </div>

                                        <div class="mb-1">
                                            <i class="ti ti-id me-1 text-success"></i>
                                            {{ $customer->userid ?? 'N/A' }}
                                        </div>

                                        <div class="mb-1">
                                            <i class="ti ti-mail me-1 text-danger"></i>
                                            {{ $customer->email ?? 'N/A' }}
                                        </div>
                                        <div class="mb-1">
                                            <i class="ti ti-users me-1 text-warning"></i>
                                            <strong>Sponsor ID :</strong>
                                            {{ $customer->sponsor_id ?? 'N/A' }}
                                        </div>

                                        <div class="mb-1">
                                            <i class="ti ti-user-star me-1 text-info"></i>
                                            <strong>Sponsor Name :</strong>

                                            {{ $customer->sponsor_name ?? 'N/A' }}
                                        </div>
                                    </div>

                                    {{-- Block Button --}}
                                    {{-- <div class="mt-3">
                                        @if ($customer->is_block == 'yes')
                                        <button type="button" class="btn btn-danger rounded-pill px-4 block-toggle"
                                            data-id="{{ $customer->id }}" data-blocked="yes">
                                            <i class="ti ti-lock-open me-1"></i> Unblock
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-dark rounded-pill px-4 block-toggle"
                                            data-id="{{ $customer->id }}" data-blocked="no">
                                            <i class="ti ti-ban me-1"></i> Block
                                        </button>
                                        @endif
                                    </div> --}}

                                    </div>




                                </div>

                            </div>

                        </div>

                        {{-- RIGHT --}}
                        {{-- <div class="col-lg-6 mt-4 mt-lg-0">

                            <div class="row g-3">

                                <div class="col-4">
                                    <div class="stats-card">
                                        <div class="stats-icon bg-warning-subtle text-warning">
                                            <i class="ti ti-gift"></i>
                                        </div>

                                        <div>
                                            <h4 class="fw-bold mb-0">
                                                ₹{{ number_format($customer->rewards ?? 0, 2) }}
                                            </h4>
                                            <small class="text-muted">Rewards</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="stats-card">
                                        <div class="stats-icon bg-primary-subtle text-primary">
                                            <i class="ti ti-wallet"></i>
                                        </div>

                                        <div>
                                            <h4 class="fw-bold mb-0">
                                                ₹{{ number_format($customer->wallet ?? 0, 2) }}
                                            </h4>
                                            <small class="text-muted">Wallet</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stats-card">
                                        <div class="stats-icon bg-primary-subtle text-primary">
                                            <i class="ti ti-wallet"></i>
                                        </div>

                                        <div>
                                            <h4 class="fw-bold mb-0">
                                                ₹{{ number_format($customer->bonus ?? 0, 2) }}
                                            </h4>
                                            <small class="text-muted">Bonus</small>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div> --}}

                    </div>

                </div>
            </div>


            {{-- ================= TABS ================= --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-2">

                    <ul class="nav nav-pills customer-tabs gap-2">

                        <li class="nav-item">
                            <a class="nav-link @if(request('slug') == 'profile') active @endif"
                                href="{{ route('admin.customers.show', ['customer' => $customer->id, 'slug' => 'profile']) }}">
                                <i class="ti ti-user me-1"></i> Profile
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link @if(request('slug') == 'activities') active @endif"
                                href="{{ route('admin.customers.show', ['customer' => $customer->id, 'slug' => 'activities']) }}">
                                <i class="ti ti-activity me-1"></i> Activities
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a class="nav-link @if(request('slug') == 'rewards') active @endif"
                                href="{{ route('admin.customers.show', ['customer' => $customer->id, 'slug' => 'rewards']) }}">
                                <i class="ti ti-award me-1"></i> Rewards
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link @if(request('slug') == 'wallet') active @endif"
                                href="{{ route('admin.customers.show', ['customer' => $customer->id, 'slug' => 'wallet']) }}">
                                <i class="ti ti-wallet me-1"></i> Wallet
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request('slug') == 'bonus') active @endif"
                                href="{{ route('admin.customers.show', ['customer' => $customer->id, 'slug' => 'bonus']) }}">
                                <i class="ti ti-wallet me-1"></i> Bonus
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request('slug') == 'referrals') active @endif"
                                href="{{ route('admin.customers.show', ['customer' => $customer->id, 'slug' => 'referrals']) }}">
                                <i class="ti ti-wallet me-1"></i> Referrals
                            </a>
                        </li> --}}

                    </ul>

                </div>
            </div>


            {{-- ================= CONTENT ================= --}}
            @yield('customer')

        </div>


        {{-- ================= FOOTER ================= --}}
        <div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
            <p class="mb-0">2026 © {{ $site->site_name ?? ' '}}. All Rights Reserved</p>
            <p>Designed & Developed by <span class="text-primary">{{ $site->site_name ?? ' '}}</span></p>
        </div>

    </div>


    {{-- ================= STYLE ================= --}}
    <style>
        .customer-profile-card {
            border-radius: 22px;
        }

        .profile-cover {
            height: 70px;
            background: linear-gradient(100deg, #ff4f9a, #8b5cf6);
        }

        .profile-avatar-wrapper {
            /* margin-top: 10px; */
            position: relative;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 20px;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .12);
            background: #fff;
        }

        .stats-card {
            background: #fff;
            border-radius: 18px;
            padding: 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1px solid #f1f1f1;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
            transition: .3s;
        }

        .stats-card:hover {
            transform: translateY(-3px);
        }

        .stats-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .customer-tabs .nav-link {
            border-radius: 12px;
            padding: 5px 8px;
            font-weight: 600;
            color: #6b7280;
            transition: .3s;
        }

        .customer-tabs .nav-link:hover {
            background: #f5f7ff;
            color: #4f46e5;
        }

        .customer-tabs .nav-link.active {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff !important;
            box-shadow: 0 5px 15px rgba(79, 70, 229, .25);
        }

        @media(max-width:768px) {

            .profile-avatar-wrapper {
                margin-top: -55px;
            }

            .profile-avatar {
                width: 95px;
                height: 95px;
            }

            .profile-cover {
                height: 50px;
            }
        }
    </style>


    {{-- ================= SCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const buttons = document.querySelectorAll('.block-toggle');

            buttons.forEach(button => {

                button.addEventListener('click', function () {

                    const userId = this.dataset.id;
                    const isBlocked = this.dataset.blocked === 'yes' ? 'no' : 'yes';
                    const btn = this;

                    fetch(`/admin/customers/${userId}/toggle-block`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            is_block: isBlocked
                        })
                    })
                        .then(response => response.json())
                        .then(data => {

                            if (data.success) {

                                if (isBlocked === 'yes') {

                                    btn.innerHTML =
                                        '<i class="ti ti-lock-open me-1"></i> Unblock';

                                    btn.classList.remove('btn-dark');
                                    btn.classList.add('btn-danger');

                                } else {

                                    btn.innerHTML =
                                        '<i class="ti ti-ban me-1"></i> Block';

                                    btn.classList.remove('btn-danger');
                                    btn.classList.add('btn-dark');
                                }

                                btn.dataset.blocked = isBlocked;

                            } else {
                                alert('Something went wrong!');
                            }

                        })
                        .catch(err => console.error(err));

                });

            });

        });
    </script>

    <script>
        function confirmSubscriber(id) {

            if (confirm('Are you sure you want to make this customer a subscriber?')) {

                document.getElementById('subscriberForm' + id).submit();

            }

        }
    </script>

@endsection