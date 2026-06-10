<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Dynagear Stock')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">

        <a href="/dashboard" class="navbar-brand fw-bold">
            Dynagear Stock
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">

    {{-- Semua role login --}}
    <li class="nav-item">
        <a href="/dashboard" class="nav-link">
            Dashboard
        </a>
    </li>

    {{-- Admin --}}
    @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <a href="/users" class="nav-link">
                User
            </a>
        </li>
        <li class="nav-item">
    <a href="/backup" class="nav-link">
        Backup
    </a>
</li>
    @endif

    {{-- Admin + Gudang --}}
    @if(in_array(Auth::user()->role, ['admin', 'gudang']))

        <li class="nav-item">
            <a href="/products" class="nav-link">
                Master Barang
            </a>
        </li>

        <li class="nav-item">
            <a href="/categories" class="nav-link">
                Kategori
            </a>
        </li>

        <li class="nav-item">
            <a href="/suppliers" class="nav-link">
                Supplier
            </a>
        </li>

        <li class="nav-item">
            <a href="/warehouses" class="nav-link">
                Gudang
            </a>
        </li>

        <li class="nav-item">
            <a href="/stock-in" class="nav-link">
                Stok Masuk
            </a>
        </li>

        <li class="nav-item">
            <a href="/stock-out" class="nav-link">
                Stok Keluar
            </a>
        </li>

        <li class="nav-item">
            <a href="/stock-opname" class="nav-link">
                Stock Opname
            </a>
        </li>

        <li class="nav-item">
            <a href="/stock-card" class="nav-link">
                Kartu Stok
            </a>
        </li>

        <li class="nav-item">
    <a href="/scan-qr" class="nav-link">
        Scan QR
    </a>
</li>

    @endif

    {{-- Admin + Manager --}}
    @if(in_array(Auth::user()->role, ['admin', 'manager']))

        <li class="nav-item">
            <a href="/stock-report" class="nav-link">
                Laporan
            </a>
        </li>

        <li class="nav-item">
            <a href="/purchase-orders" class="nav-link">
                Purchase Order
            </a>
        </li>

<li class="nav-item">
    <a href="/activity-logs" class="nav-link">
        Activity Log
    </a>
</li>

    @endif

    {{-- Admin + Sales --}}
    @if(in_array(Auth::user()->role, ['admin', 'sales']))

        <li class="nav-item">
            <a href="/item-requests" class="nav-link">
                Request Barang
            </a>
        </li>

    @endif

    <li class="nav-item ms-lg-2">
        <form action="/logout" method="POST">
            @csrf

            <button class="btn btn-warning btn-sm mt-2 mt-lg-1">
                Logout
            </button>
        </form>
    </li>

</ul>
        </div>

    </div>
</nav>

<main class="container mt-4 mb-5">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>