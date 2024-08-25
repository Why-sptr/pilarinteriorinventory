<!-- resources/views/layouts/main.blade.php -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>
<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    @include('partials.sidebar')
    <!-- Sidebar End -->
    <div class="body-wrapper">
        <!-- Header Start -->
        @include('partials.navbar')
        <!-- Header End -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
