<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Dynagear Stock')</title>

    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon"
          type="image/jpeg"
          href="{{ asset('img/logo/dynagearlogo.jpg') }}">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background: #ffffff;
            min-height: 100vh;
            overflow-y: auto;
            border-right: 1px solid #dee2e6;
        }

        @media (min-width: 992px) {
            .sidebar {
                position: sticky;
                top: 66px;
                height: calc(100vh - 66px);
            }
        }

        .sidebar .nav-link {
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            color: #212529;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #0d6efd;
            color: #ffffff !important;
        }

        .sidebar .menu-title {
            font-size: 11px;
            font-weight: 700;
            color: #6c757d;
            margin-top: 18px;
            margin-bottom: 6px;
            padding-left: 12px;
            text-transform: uppercase;
        }

        main {
            min-height: calc(100vh - 66px);
        }

        @media (max-width: 991px) {
            main {
                padding: 1rem !important;
            }
        }

        .btn-portal-back {
    font-weight: 600;
    white-space: nowrap;
    }

@media (max-width: 576px) {
    .navbar-brand {
        max-width: 170px;
    }

    .btn-portal-back {
        padding: 8px 10px;
        font-size: 14px;
        border-radius: 10px;
    }
}
    </style>
</head>

<body>

@auth

    @include('layouts.navbar')

    {{-- Sidebar Mobile --}}
    <div class="offcanvas offcanvas-start"
         tabindex="-1"
         id="mobileSidebar"
         aria-labelledby="mobileSidebarLabel">

        <div class="offcanvas-header bg-primary text-white">

            <h5 class="offcanvas-title"
                id="mobileSidebarLabel">
                Dynagear Stock
            </h5>

            <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close">
            </button>

        </div>

        <div class="offcanvas-body p-0">
            @include('layouts.sidebar')
        </div>

    </div>

    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar Desktop --}}
            <aside class="col-lg-2 p-0 d-none d-lg-block">
                @include('layouts.sidebar')
            </aside>

            {{-- Content --}}
            <main class="col-lg-10 px-4 py-4">

                @include('partials.alerts')

                @yield('content')

                @include('partials.footer')

            </main>

        </div>
    </div>

@else

    @yield('content')

@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>