@extends('layouts.website')

@section('title', 'Edit Profile')

@section('content')

    <style>
        .edit-profile-page {
            padding: 50px 0 80px;
            background: #f8faf9;
            min-height: 100vh;
        }

        .container-custom {
            width: min(1180px, calc(100% - 30px));
            margin: auto;
        }

        .edit-profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        .profile-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #198754;
            margin-bottom: 8px;
            display: block;
        }

        .edit-profile-header h1 {
            font-size: 34px;
            font-weight: 800;
            margin: 0 0 8px;
            color: #18231d;
        }

        .edit-profile-header p {
            margin: 0;
            color: #6c757d;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 18px;
            border: 1px solid #dee5e0;
            border-radius: 12px;
            background: #fff;
            color: #26352c;
            text-decoration: none;
            font-weight: 600;
        }

        .back-btn:hover {
            background: #f1f5f2;
            color: #198754;
        }

        .edit-profile-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #e8eee9;
            box-shadow: 0 10px 35px rgba(0, 0, 0, .05);
            overflow: hidden;
        }

        .profile-cover {
            height: 150px;
            background:
                linear-gradient(135deg,
                    #198754,
                    #65b88b);
        }

        .profile-form {
            padding: 0 40px 40px;
        }

        .profile-picture-section {
            margin-top: -55px;
            margin-bottom: 35px;
            display: flex;
            align-items: end;
            gap: 20px;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 6px solid #fff;
            background: #e9f5ee;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            font-weight: 700;
            color: #198754;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .12);
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-area {
            padding-bottom: 8px;
        }

        .upload-area h6 {
            margin-bottom: 5px;
            font-weight: 700;
        }

        .upload-area p {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .form-section {
            margin-top: 30px;
        }

        .form-section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #edf1ee;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .form-section-title h4 {
            margin: 0;
            font-size: 19px;
            font-weight: 750;
        }

        .form-section-title i {
            color: #198754;
            font-size: 22px;
        }

        .form-label {
            font-weight: 650;
            color: #34433a;
            margin-bottom: 8px;
        }

        .form-control {
            min-height: 48px;
            border-radius: 11px;
            border: 1px solid #dfe7e1;
            padding: 10px 14px;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .10);
        }

        .readonly-field {
            background: #f5f7f6 !important;
        }

        .form-text {
            font-size: 12px;
            color: #7a857e;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
        }

        .alert {
            border: 0;
            border-radius: 12px;
        }

        .form-actions {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid #edf1ee;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .cancel-btn,
        .save-btn {
            min-height: 48px;
            padding: 10px 24px;
            border-radius: 11px;
            font-weight: 650;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
        }

        .cancel-btn {
            background: #f1f4f2;
            color: #34433a;
        }

        .cancel-btn:hover {
            background: #e5eae7;
            color: #222;
        }

        .save-btn {
            background: #198754;
            color: #fff;
        }

        .save-btn:hover {
            background: #157347;
            color: #fff;
        }

        @media (max-width: 768px) {

            .edit-profile-page {
                padding: 30px 0 50px;
            }

            .edit-profile-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .edit-profile-header h1 {
                font-size: 28px;
            }

            .profile-form {
                padding: 0 20px 25px;
            }

            .profile-picture-section {
                align-items: flex-start;
                flex-direction: column;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .cancel-btn,
            .save-btn {
                width: 100%;
            }
        }
    </style>


    <section class="edit-profile-page">

        <div class="container-custom">

            {{-- Header --}}
            <div class="edit-profile-header">

                <div>

                    <span class="profile-label">
                        MY ACCOUNT
                    </span>

                    <h1>
                        Edit Profile
                    </h1>

                    <p>
                        Update your personal account information.
                    </p>

                </div>

                <a href="{{ route('customer.profile') }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i>
                    Back to Profile
                </a>

            </div>


            {{-- Validation Errors --}}
            @if($errors->any())

                <div class="alert alert-danger mb-4">

                    <strong>
                        Please fix the following errors:
                    </strong>

                    <ul class="mb-0 mt-2">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- Success --}}
            @if(session('success'))

                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>

            @endif


            <div class="edit-profile-card">

                <div class="profile-cover"></div>


                <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="profile-form">

                    @csrf

                    {{-- Profile Picture --}}
                    <div class="profile-picture-section">

                        <div class="profile-picture">

                            @if($customer->profile_pic)

                                <img src="{{ asset('storage/' . $customer->profile_pic) }}" alt="{{ $customer->name }}"
                                    id="profilePreview">

                            @else

                                                    <span id="profileInitial">

                                                        {{ strtoupper(
                                    substr($customer->name ?? 'U', 0, 1)
                                ) }}

                                                    </span>

                                                    <img id="profilePreview" src="" alt="Profile Preview" style="display:none;">

                            @endif

                        </div>


                        <div class="upload-area">

                            <h6>
                                Profile Picture
                            </h6>

                            <p>
                                JPG, JPEG, PNG or WEBP. Maximum 5 MB.
                            </p>

                            <label for="profile_pic" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-camera me-1"></i>
                                Change Photo
                            </label>

                            <input type="file" name="profile_pic" id="profile_pic" class="d-none"
                                accept="image/jpeg,image/png,image/webp">

                        </div>

                    </div>


                    {{-- Personal Details --}}
                    <div class="form-section">

                        <div class="form-section-title">

                            <div>

                                <small class="text-success fw-bold">
                                    ACCOUNT INFORMATION
                                </small>

                                <h4>
                                    Personal Details
                                </h4>

                            </div>

                            <i class="bi bi-person"></i>

                        </div>


                        <div class="row g-4">

                            {{-- Name --}}
                            <div class="col-md-6">

                                <label for="name" class="form-label">
                                    Full Name
                                </label>

                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $customer->name) }}" placeholder="Enter your full name" required>

                                @error('name')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Mobile --}}
                            <div class="col-md-6">

                                <label for="mobile" class="form-label">
                                    Mobile Number
                                </label>

                                <input type="text" id="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror"
                                    value="{{ old('mobile', $customer->mobile) }}" placeholder="Enter mobile number"
                                    readonly>

                                @error('mobile')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- Email --}}
                            <div class="col-md-6">

                                <label for="email" class="form-label">
                                    Email Address
                                </label>

                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $customer->email) }}" placeholder="Enter email address">

                                @error('email')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            {{-- DOB --}}
                            <div class="col-md-6">

                                <label for="dob" class="form-label">
                                    Date of Birth
                                </label>

                                <input type="date" name="dob" id="dob"
                                    class="form-control @error('dob') is-invalid @enderror" value="{{ old(
        'dob',
        $customer->dob
        ? $customer->dob->format('Y-m-d')
        : ''
    ) }}">

                                @error('dob')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Account Information --}}
                    <div class="form-section">

                        <div class="form-section-title">

                            <div>

                                <small class="text-success fw-bold">
                                    ACCOUNT DETAILS
                                </small>

                                <h4>
                                    Account Information
                                </h4>

                            </div>

                            <i class="bi bi-shield-lock"></i>

                        </div>


                        <div class="row g-4">

                            {{-- User ID --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    User ID
                                </label>

                                <input type="text" class="form-control readonly-field" value="{{ $customer->userid }}"
                                    readonly>

                                <div class="form-text">
                                    User ID cannot be changed.
                                </div>

                            </div>


                            {{-- Sponsor --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Sponsor ID
                                </label>

                                <input type="text" class="form-control readonly-field"
                                    value="{{ $customer->sponsor_id ?? '-' }}" readonly>

                                <div class="form-text">
                                    Sponsor information cannot be changed.
                                </div>

                            </div>


                            {{-- Account Status --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Account Status
                                </label>

                                <input type="text" class="form-control readonly-field"
                                    value="{{ ucfirst($customer->account_status ?? 'Pending') }}" readonly>

                            </div>


                            {{-- KYC --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    KYC Status
                                </label>

                                <input type="text" class="form-control readonly-field"
                                    value="{{ ucfirst($customer->kyc_status ?? 'Pending') }}" readonly>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="form-actions">

                        <a href="{{ route('customer.profile') }}" class="cancel-btn">
                            <i class="bi bi-x-lg"></i>
                            Cancel
                        </a>

                        <button type="submit" class="save-btn">
                            <i class="bi bi-check-lg"></i>
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>


    <script>

        document
            .getElementById('profile_pic')
            .addEventListener('change', function (event) {

                const file = event.target.files[0];

                if (!file) {
                    return;
                }

                const preview =
                    document.getElementById('profilePreview');

                const initial =
                    document.getElementById('profileInitial');

                preview.src =
                    URL.createObjectURL(file);

                preview.style.display = 'block';

                if (initial) {
                    initial.style.display = 'none';
                }

            });

    </script>

@endsection