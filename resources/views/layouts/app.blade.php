<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Dynagear Stock')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png"href="{{ asset('img/logo/favicon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

    @include('partials.navbar')

    <main class="container mt-4 mb-5">

        @include('partials.alerts')

        @yield('content')

    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>