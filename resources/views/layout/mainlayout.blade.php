<!DOCTYPE html>
@if (!Route::is(['layout-horizontal', 'layout-detached', 'layout-modern', 'layout-two-column', 'layout-hovered', 'layout-boxed', 'layout-rtl', 'layout-dark']))
    <html lang="en">
@endif
@if (Route::is(['layout-horizontal']))
    <html lang="en" data-layout="horizontal">
@endif
@if (Route::is(['layout-detached']))
    <html lang="en" data-layout="detached">
@endif
@if (Route::is(['layout-modern']))
    <html lang="en" data-layout="modern">
@endif
@if (Route::is(['layout-two-column']))
    <html lang="en" data-layout="twocolumn">
@endif
@if (Route::is(['layout-hovered']))
    <html lang="en" data-layout="layout-hovered">
@endif
@if (Route::is(['layout-boxed']))
    <html lang="en" data-layout="default" data-width="box">
@endif
@if (Route::is(['layout-rtl']))
    <html lang="en" data-layout-mode="light_mode">
@endif
@if (Route::is(['layout-dark']))
    <html lang="en" data-theme="dark">
@endif

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Ask(R)Pay - Admin">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Ask(R)Pay - Admin">
    <meta name="robots" content="noindex, nofollow">
    {{-- <title>{{$site->site_name }} </title> --}}

    <!-- Favicon -->
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset($site->favicon) ?? ''  }}"> --}}
    {{--
    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::disk('s3')->url($site->favicon) ?? ''  }}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @include('layout.partials.head')
</head>


@if (
        !Route::is([
            'under-maintenance',
            'coming-soon',
            'error-404',
            'error-500',
            'two-step-verification-3',
            'two-step-verification-2',
            'two-step-verification',
            'email-verification-3',
            'email-verification-2',
            'email-verification',
            'reset-password-3',
            'reset-password-2',
            'reset-password',
            'forgot-password-3',
            'forgot-password-2',
            'forgot-password',
            'register-3',
            'register-2',
            'register',
            'signin-3',
            'signin-2',
            'admin.login',
            'signin',
            'success',
            'success-2',
            'success-3',
            'layout-horizontal',
            'layout-hovered',
            'layout-boxed',
            'layout-rtl',
            'pos',
            'pos-2',
            'pos-3',
            'pos-4',
            'pos-5',
            'admin.password.request',
            'admin.password.verifyOtp',
            'admin.password.verifyForm',
            'admin.password.resetForm'
        ])
    )

    <body>
@endif
    @if (Route::is(['layout-horizontal']))

        <body class="menu-horizontal">
    @endif
        @if (Route::is(['layout-hovered']))

            <body class="mini-sidebar expand-menu">
        @endif
            @if (Route::is(['layout-boxed']))

                <body class="mini-sidebar layout-box-mode">
            @endif
                @if (Route::is(['layout-rtl']))

                    <body class="layout-mode-rtl">
                @endif

                    @if (Route::is(['under-maintenance', 'coming-soon', 'error-404', 'error-500']))

                        <body class="error-page">
                    @endif
                        @if (Route::is(['two-step-verification', 'email-verification', 'reset-password', 'forgot-password', 'register-2', 'register', 'signin', 'success']))

                            <body class="account-page">
                        @endif

                            @if(Route::is(['two-step-verification-3', 'two-step-verification-2', 'success-2', 'success-3', 'signin-3', 'signin-2', 'admin.login', 'reset-password-3', 'reset-password-2', 'forgot-password-3', 'forgot-password-2', 'email-verification-3', 'email-verification-2', 'register-3', 'admin.password.request', 'admin.password.verifyOtp', 'admin.password.verifyForm', 'admin.password.resetForm']))

                                <body class="account-page bg-white">
                            @endif

                                @if(Route::is(['lock-screen']))
                                    <img src="{{URL::asset('build/img/bg/lock-screen-bg.png')}}" alt="bg"
                                        class="lock-screen-bg position-absolute img-fluid d-sm-none d-md-none d-lg-flex">
                                @endif

                                @if(Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))

                                    <body class="pos-page">
                                @endif
                                    @component('components.loader')
                                    @endcomponent
                                    <!-- Main Wrapper -->
                                    @if (!Route::is(['lock-screen', 'pos', 'pos-3', 'pos-4', 'pos-5']))
                                        <div class="main-wrapper">
                                    @endif
                                        @if (Route::is(['lock-screen']))
                                            <div class="main-wrapper login-body">
                                        @endif
                                            @if (Route::is(['pos']))

                                                <div class="main-wrapper pos-five">
                                            @endif
                                                @if (Route::is(['pos-3']))
                                                    <div class="main-wrapper pos-two">
                                                @endif
                                                    @if (Route::is(['pos-4']))
                                                        <div class="main-wrapper pos-three">
                                                    @endif
                                                        @if (Route::is(['pos-5']))
                                                            <div class="main-wrapper pos-three pos-four">
                                                        @endif
                                                            @if (!Route::is(['under-maintenance', 'coming-soon', 'error-404', 'error-500', 'two-step-verification-3', 'two-step-verification-2', 'two-step-verification', 'email-verification-3', 'email-verification-2', 'email-verification', 'reset-password-3', 'reset-password-2', 'reset-password', 'forgot-password-3', 'forgot-password-2', 'forgot-password', 'register-3', 'register-2', 'register', 'signin-3', 'signin-2', 'admin.login', 'signin', 'success', 'success-2', 'success-3', 'lock-screen', 'admin.password.request', 'admin.password.verifyOtp', 'admin.password.verifyForm', 'admin.password.resetForm']))
                                                                @include('layout.partials.header')
                                                            @endif
                                                            @if (!Route::is(['under-maintenance', 'coming-soon', 'error-404', 'error-500', 'two-step-verification-3', 'two-step-verification-2', 'two-step-verification', 'email-verification-3', 'email-verification-2', 'email-verification', 'reset-password-3', 'reset-password-2', 'reset-password', 'forgot-password-3', 'forgot-password-2', 'forgot-password', 'register-3', 'register-2', 'register', 'signin-3', 'signin-2', 'admin.login', 'signin', 'success', 'success-2', 'success-3', 'lock-screen', 'admin.password.request', 'admin.password.verifyOtp', 'admin.password.verifyForm', 'admin.password.resetForm']))
                                                                @include('layout.partials.sidebar')
                                                                @include('layout.partials.horizontal-sidebar')
                                                            @endif
                                                            @yield('content')
                                                        </div>
                                                        <!-- /Main Wrapper -->

                                                        @component('components.modalpopup')
                                                        @endcomponent
                                                        @include('layout.partials.footer-scripts')
                                                        <!-- put this near the end of the body, before </body> -->
                                                        <!-- jQuery (required by our view scripts) -->
                                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                                                            integrity="sha256-/xUj+3OJ+Y6kz8a2eQvQvA6a8b1z1mZ6b9QZxF3QmQ="
                                                            crossorigin="anonymous"></script>

                                                        <!-- Bootstrap JS (if you use Bootstrap modals) -->
                                                        <script
                                                            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                                                            integrity="sha384-..." crossorigin="anonymous"></script>

                                                        <!-- feather icons initialization (optional if you use feather) -->
                                                        <script src="https://unpkg.com/feather-icons"></script>
                                                        <script> if (window.feather) feather.replace(); </script>

                                                        <!-- Render all pushed scripts from child views -->
                                                        @stack('scripts')
                                </body>

                            </body>
                            @include('sweetalert::alert')

</html>