@if(!Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
    <div class="header">
        <div class="main-header">
            <!-- Logo -->
            <div class="header-left active">
                <a href="{{ route('admin.dashboard') }}" class="logo logo-normal">
                    {{-- @if (!empty($site->logo))
                    <img src="{{ Storage::disk('s3')->url($site->logo)  }}" alt="Img">
                    @endif --}}

                    <img src="{{ asset('website/images/logo.png') }}" style="max-height: 60px;" alt="Img">

                </a>
                <a href="{{ route('admin.dashboard') }}" class="logo logo-white">
                    {{-- @if (!empty($site->logo)) --}}
                    <img src="{{ asset('website/images/logo.png') }}" style="max-height: 60px;" alt="Img">
                    {{-- @endif --}}
                </a>
                <a href="{{ route('admin.dashboard') }}" class="logo-small">
                    {{-- @if (!empty($site->logo)) --}}
                    <img src="{{ asset('website/images/logo.png') }}" style="max-height: 60px;" alt="Img">
                    {{-- @endif --}}

                </a>
            </div>
            <!-- /Logo -->
            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <!-- Header Menu -->
            <ul class="nav user-menu">

                <!-- Search -->
                <li class="nav-item nav-searchinputs">
                    <div class="top-nav-search">

                    </div>
                </li>
                <!-- /Search -->

                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i class="ti ti-maximize"></i>
                    </a>
                </li>

                <li class="nav-item dropdown has-arrow main-drop profile-nav">
                    <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-info p-0">
                            <span class="user-letter">
                                <img src="{{URL::asset('build/img/users/user-32.jpg')}}" alt="Img" class="img-fluid">
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profileset d-flex align-items-center">
                            <span class="user-img me-2">
                                <img src="{{URL::asset('build/img/users/user-32.jpg')}}" alt="Img">
                            </span>
                            <div>
                                <h6 class="fw-medium">{{ auth('admin')->user()->name ?? ''}}</h6>
                                <p>Admin</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ route('admin.dashboard')  }}"><i
                                class="ti ti-graph me-2"></i>Dashboard</a>
                        <hr class="my-2">
                        <a class="dropdown-item logout pb-0" href="{{route('admin.logout')}}"><i
                                class="ti ti-logout me-2"></i>Logout</a>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="dropdown-item" href="{{ route('admin.logout')}}">Logout</a>
                </div>
            </div>
            <!-- /Mobile Menu -->
        </div>
    </div>
@endif


@if(Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))

    <!-- Header -->
    <div class="header pos-header">

        <!-- Logo -->
        <div class="header-left active">
            <a href="{{ route('admin.dashboard') }}" class="logo logo-normal">
                <img src="{{ Storage::disk('s3')->url($site->logo)  }}" alt="Img">
            </a>
            <a href="{{ route('admin.dashboard') }}" class="logo logo-white">
                <img src="{{ Storage::disk('s3')->url($site->logo)  }}" alt="Img">
            </a>
            <a href="{{ route('admin.dashboard') }}" class="logo-small">
                <img src="{{ Storage::disk('s3')->url($site->logo)  }}" alt="Img">
            </a>
        </div>
        <!-- /Logo -->

        <a id="mobile_btn" class="mobile_btn d-none" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <!-- Header Menu -->
        <ul class="nav user-menu">

            <!-- Search -->
            <li class="nav-item time-nav">
                <span class="bg-teal text-white d-inline-flex align-items-center"><img
                        src="{{URL::asset('build/img/icons/clock-icon.svg')}}" alt="img" class="me-2">09:25:32</span>
            </li>
            <!-- /Search -->

            <li class="nav-item pos-nav">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-purple btn-md d-inline-flex align-items-center">
                    <i class="ti ti-world me-1"></i>Dashboard
                </a>
            </li>

            <!-- Select Store -->
            <li class="nav-item dropdown has-arrow main-drop select-store-dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle nav-link select-store" data-bs-toggle="dropdown">
                    <span class="user-info">
                        <span class="user-letter">
                            <img src="{{URL::asset('build/img/store/store-01.png')}}" alt="Store Logo" class="img-fluid">
                        </span>
                        <span class="user-detail">
                            <span class="user-name">Freshmart</span>
                        </span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" class="dropdown-item">
                        <img src="{{URL::asset('build/img/store/store-01.png')}}" alt="Store Logo"
                            class="img-fluid">Freshmart
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <img src="{{URL::asset('build/img/store/store-02.png')}}" alt="Store Logo" class="img-fluid">Grocery
                        Apex
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <img src="{{URL::asset('build/img/store/store-03.png')}}" alt="Store Logo" class="img-fluid">Grocery
                        Bevy
                    </a>
                    <a href="javascript:void(0);" class="dropdown-item">
                        <img src="{{URL::asset('build/img/store/store-04.png')}}" alt="Store Logo" class="img-fluid">Grocery
                        Eden
                    </a>
                </div>
            </li>
            <!-- /Select Store -->

            <li class="nav-item nav-item-box">
                <a href="#" data-bs-toggle="modal" data-bs-target="#calculator"
                    class="bg-orange border-orange text-white"><i class="ti ti-calculator"></i></a>
            </li>
            <li class="nav-item nav-item-box">
                <a href="javascript:void(0);" id="btnFullscreen" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Maximize">
                    <i class="ti ti-maximize"></i>
                </a>
            </li>
            <li class="nav-item nav-item-box" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Cash Register">
                <a href="#" data-bs-toggle="modal" data-bs-target="#cash-register"><i class="ti ti-cash"></i></a>
            </li>
            <li class="nav-item nav-item-box" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Print Last Reciept">
                <a href="#"><i class="ti ti-printer"></i></a>
            </li>
            <li class="nav-item nav-item-box" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Today’s Sale">
                <a href="#" data-bs-toggle="modal" data-bs-target="#today-sale"><i class="ti ti-progress"></i></a>
            </li>
            <li class="nav-item nav-item-box" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Today’s Profit">
                <a href="#" data-bs-toggle="modal" data-bs-target="#today-profit"><i
                        class="ti ti-chart-infographic"></i></a>
            </li>
            <li class="nav-item nav-item-box" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="POS Settings">
                <a href="{{url('pos-settings')}}"><i class="ti ti-settings"></i></a>
            </li>
            <li class="nav-item dropdown has-arrow main-drop profile-nav">
                <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                    <span class="user-info p-0">
                        <span class="user-letter">
                            <img src="{{URL::asset('build/img/users/user-32.jpg')}}" alt="Img" class="img-fluid">
                        </span>
                    </span>
                </a>
                <div class="dropdown-menu menu-drop-user">
                    <div class="profilename">
                        <div class="profileset">
                            <span class="user-img"><img src="{{URL::asset('build/img/users/user-32.jpg')}}" alt="Img">
                                <span class="status online"></span></span>
                            <div class="profilesets">
                                <h6>{{ auth('admin')->user()->name ?? ''}}</h6>
                                <h5>Admin</h5>
                            </div>
                        </div>
                        <hr class="m-0">
                        <a class="dropdown-item" href="{{ route('admin.dashboard')  }}"><i class="me-2"
                                data-feather="user"></i>My
                            Dashboard</a>
                        <a class="dropdown-item" href="{{route('admin.settings.company')}}"><i class="me-2"
                                data-feather="settings"></i>Settings</a>
                        <hr class="m-0">
                        <a class="dropdown-item logout pb-0" href="{{url('signin')}}"><img
                                src="{{URL::asset('build/img/icons/log-out.svg')}}" class="me-2" alt="img">Logout</a>
                    </div>
                </div>
            </li>
        </ul>
        <!-- /Header Menu -->

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('admin.dashboard')  }}">Dashboard</a>
                <a class="dropdown-item" href="{{route('admin.settings.company')}}">Settings</a>
                <a class="dropdown-item" href="{{ route('admin.logout')}}">Logout</a>
            </div>
        </div>
        <!-- /Mobile Menu -->
    </div>
    <!-- Header -->
@endif