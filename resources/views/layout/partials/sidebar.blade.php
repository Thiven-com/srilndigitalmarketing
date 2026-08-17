@if (!Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
                <!-- Logo -->
                <div class="sidebar-logo active">
                        <a href="{{ route('admin.dashboard') }}" class="logo logo-normal">
                                <img src="{{ asset('website/images/logo.png') }}" alt="Img"
                                        style="width: 100%; height: 70px; padding-left: 10px">
                        </a>
                </div>
                <div class="sidebar-inner slimscroll">
                        <div id="sidebar-menu" class="sidebar-menu">
                                <ul>
                                        <li class="submenu-open">
                                                <h6 class="submenu-hdr">Main</h6>
                                                <ul>
                                                        <li><a href="{{ route('admin.dashboard') }}"
                                                                        class="{{ Request::routeIs('admin.dashboard', '/') ? 'active' : '' }}"><i
                                                                                class="ti ti-layout-grid fs-16 me-2"></i>Dashboard</a>
                                                        </li>
                                                </ul>
                                        </li>
                                        <li class="submenu-open">
                                                <h6 class="submenu-hdr">HRM</h6>
                                                <ul>
                                                        {{-- <li
                                                                class="{{ Request::routeIs('admin.customers.*') ? 'active' : '' }}">
                                                                <a href="javascript:void(0);" class="has-arrow">
                                                                        <i class="ti ti-users fs-16 me-2"></i>
                                                                        <span>Members</span>
                                                                </a>

                                                                <ul class="sub-menu">
                                                                        <li
                                                                                class="{{ Request::routeIs('admin.customers.all') ? 'active' : '' }}">
                                                                                <a href="{{ route('admin.customers.all') }}">
                                                                                        All Members
                                                                                </a>
                                                                        </li>

                                                                        <li class="#">
                                                                                <a href="#">
                                                                                        New Registrations
                                                                                </a>
                                                                        </li>

                                                                        <li class="#">
                                                                                <a href="#">
                                                                                        Pending Approvals
                                                                                </a>
                                                                        </li>
                                                                </ul>
                                                        </li> --}}
                                                        <li class="submenu">
                                                                <a href="javascript:void(0);"
                                                                        class="{{ Request::is('admin/customers') ? 'active subdrop' : '' }}"><i
                                                                                class="ti ti-article fs-16 me-2"></i><span>Members</span><span
                                                                                class="menu-arrow"></span></a>

                                                                <ul>
                                                                        <li
                                                                                class="{{ Request::routeIs('admin.customers.all') ? 'active' : '' }}">
                                                                                <a href="{{ route('admin.customers.all') }}"><i
                                                                                                class="ti ti-users fs-16 me-2"></i><span>All
                                                                                                Members</span></a>
                                                                        </li>
                                                                        <li
                                                                                class="{{ Request::routeIs('admin.customers.all') ? 'active' : '' }}">
                                                                                <a
                                                                                        href="{{ route('admin.customers.all', ['type' => 'new']) }}"><i
                                                                                                class="ti ti-user-plus fs-16 me-2"></i><span>New
                                                                                                Registrations</span></a>
                                                                        </li>
                                                                </ul>
                                                        </li>

                                                        <li class="{{ Request::routeIs('packages.all') ? 'active' : '' }}">
                                                                <a href="{{ route('packages.all') }}">
                                                                        <i class="ti ti-box fs-16 me-2"></i>
                                                                        <span>Packages</span>
                                                                </a>
                                                        </li>

                                                        <li class="{{ Request::routeIs('customer-packages') ? 'active' : '' }}">
                                                                <a href="{{ route('admin.customer-packages.index') }}">
                                                                        <i class="ti ti-credit-card fs-16 me-2"></i>
                                                                        <span>Subscriptions</span>
                                                                </a>
                                                        </li>

                                                        <li class="{{ Request::routeIs('admin.trees.index') ? 'active' : '' }}">
                                                                <a href="{{ route('admin.trees.index') }}">
                                                                        <i class="ti ti-sitemap fs-16 me-2"></i>
                                                                        <span>Genealogy Tree</span>
                                                                </a>
                                                        </li>
                                                        <li class="{{ Request::routeIs('admin.rewardhistory.index') ? 'active' : '' }}">
                                                                <a href="{{ route('admin.rewardhistory.index') }}">
                                                                        <i class="ti ti-discount-2 fs-16 me-2"></i>
                                                                        <span>Reword History</span>
                                                                </a>
                                                        </li>
                                                </ul>
                                        </li>
                                        <li class="submenu-open">
                                                <h6 class="submenu-hdr">Settings</h6>
                                                <ul>
                                                        {{-- <li>
                                                                <a href="{{route('admin.change.password')}}"
                                                                        class="{{ Route::is('admin.change.password') ? 'active' : '' }}"><i
                                                                                class="ti ti-key fs-16 me-2"></i><span>Change
                                                                                Password</span>
                                                                </a>
                                                        </li> --}}
                                                        <li>
                                                                <a href="{{route('admin.logout')}}"
                                                                        class="{{ Request::is('admin.logout') ? 'active' : '' }}"><i
                                                                                class="ti ti-logout fs-16 me-2"></i><span>Logout</span>
                                                                </a>
                                                        </li>
                                                </ul>
                                        </li>
                                </ul>

                        </div>
                </div>
        </div>
        <!-- /Sidebar -->
@endif