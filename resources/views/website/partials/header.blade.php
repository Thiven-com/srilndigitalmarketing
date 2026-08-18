<header class="main-header">

    <div class="container-custom">

        <nav class="navbar navbar-expand-lg">

            {{-- LOGO --}}
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('website/images/logo.png') }}" alt="Logo" class="website-logo">
            </a>


            {{-- MOBILE BUTTON --}}
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#websiteNavbar" aria-controls="websiteNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="bi bi-list fs-2"></i>
            </button>


            {{-- NAVIGATION --}}
            <div class="collapse navbar-collapse" id="websiteNavbar">

                <ul class="navbar-nav mx-auto">

                    {{-- HOME --}}
                    <li class="nav-item">

                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            Home
                        </a>

                    </li>


                    {{-- ABOUT --}}
                    <li class="nav-item">

                        <a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                            About Us
                        </a>

                    </li>


                    {{-- PACKAGES --}}
                    <li class="nav-item">

                        <a href="{{ route('packages') }}"
                            class="nav-link {{ request()->is('packages') || request()->is('packages/*') ? 'active' : '' }}">
                            Packages
                        </a>

                    </li>


                    {{-- HOW IT WORKS --}}
                    <li class="nav-item">

                        <a href="{{ url('/how-it-works') }}"
                            class="nav-link {{ request()->is('how-it-works') ? 'active' : '' }}">
                            How It Works
                        </a>

                    </li>


                    {{-- FAQ --}}
                    <li class="nav-item">

                        <a href="{{ url('/faq') }}" class="nav-link {{ request()->is('faq') ? 'active' : '' }}">
                            FAQ
                        </a>

                    </li>


                    {{-- CONTACT --}}
                    <li class="nav-item">

                        <a href="{{ url('/contact') }}" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">
                            Contact
                        </a>

                    </li>

                </ul>


                {{-- =====================================================
                GUEST ACTIONS
                ====================================================== --}}

                @guest

                    <div class="header-actions">

                        {{-- LOGIN --}}
                        <a href="{{ url('/login') }}" class="btn-login">

                            <i class="bi bi-person"></i>

                            <span>
                                Login
                            </span>

                        </a>


                        {{-- JOIN NOW --}}
                        <a href="{{ url('/register') }}" class="btn-primary-custom">

                            <i class="bi bi-person-plus"></i>

                            <span>
                                Join Now
                            </span>

                        </a>

                    </div>

                @endguest


                {{-- =====================================================
                LOGGED IN CUSTOMER
                ====================================================== --}}

                @auth

                    <div class="header-customer">

                        <a href="{{ route('customer.dashboard') }}" class="customer-profile-link">

                            <div class="header-avatar">

                                @if(auth()->user()->profile_pic)

                                    <img src="{{ asset(auth()->user()->profile_pic) }}"
                                        alt="{{ auth()->user()->name }}">

                                @else

                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}

                                @endif

                            </div>

                            <div class="header-customer-info">

                                <span>
                                    Welcome
                                </span>

                                <strong>
                                    {{ auth()->user()->name ?? 'Member' }}
                                </strong>

                            </div>

                        </a>


                        <a href="{{ route('customer.dashboard') }}" class="btn-login">

                            <i class="bi bi-grid"></i>

                            <span>
                                Dashboard
                            </span>

                        </a>


                        <form action="{{ route('customer.logout') }}" method="POST" class="header-logout-form">

                            @csrf

                            <button type="submit" class="btn-primary-custom">

                                <i class="bi bi-box-arrow-right"></i>

                                <span>
                                    Logout
                                </span>

                            </button>

                        </form>

                    </div>

                @endauth

            </div>

        </nav>

    </div>

</header>