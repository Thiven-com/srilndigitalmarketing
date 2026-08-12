<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Build your network and grow together with our membership platform.">

    <title>
        @yield('title', 'MLM')
    </title>


    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Bootstrap Icons -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- Google Fonts -->

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Common Website CSS -->

    <link rel="stylesheet" href="{{ asset('website/css/website.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/customer-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/customer.css') }}">


    @yield('styles')

</head>


<body>


    <!-- HEADER -->

    @include('website.partials.header')


    <!-- PAGE CONTENT -->

    @yield('content')


    <!-- FOOTER -->

    @include('website.partials.footer')


    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Common Website JS -->

    <script src="{{ asset('website/js/website.js') }}"></script>


    @yield('scripts')


</body>

</html>