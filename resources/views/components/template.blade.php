<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>

<body class="d-flex flex-column min-vh-100">

    @include('components.navbar')

    @yield('content')

    <footer class="bg-light text-center text-lg-start mt-auto ">
        <!-- Copyright -->
        <div class="text-center p-3">
            © 2023 Copyright
            KeMajlis
        </div>
        <!-- Copyright -->
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
