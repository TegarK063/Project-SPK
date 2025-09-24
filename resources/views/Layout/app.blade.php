<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'My App')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />

    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400&display=swap" rel="stylesheet" />

    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}" /> --}}
    @stack('styles')
</head>

<body id="page-top">
    {{-- Navbar --}}
    @include('Layout.nav')

    {{-- Konten halaman --}}
    @yield('content')

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    @stack('scripts')
</body>

</html>

