
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

        <div class="collapse navbar-collapse"
             id="navbarMenu">

            <ul class="navbar-nav ms-auto">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="/dashboard"
                       class="nav-link">
                        Dashboard
                    </a>
                </li>

                {{-- Master Data --}}
                @if(in_array(Auth::user()->role, ['admin','manager','gudang']))

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        Master Data

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item"
                               href="/products">
                                Master Barang
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/brands">
                                Merek
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/units">
                                Satuan
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/categories">
                                Category
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/warehouses">
                                Gudang
                            </a>
                        </li>

                    </ul>

                </li>

                @endif

                {{-- Transaksi --}}
                @if(in_array(Auth::user()->role, ['admin','manager','gudang']))

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        Transaksi

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item"
                               href="/stock-in">
                                Stok Masuk
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/stock-out">
                                Stok Keluar
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/stock-opname">
                                Stock Opname
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/item-requests">
                                Request Barang
                            </a>
                        </li>

                    </ul>

                </li>

                @endif

                {{-- Purchasing --}}
                @if(in_array(Auth::user()->role, ['admin','manager','purchasing']))

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        Purchasing

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item"
                               href="/suppliers">
                                Supplier
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/purchase-orders">
                                Purchase Order
                            </a>
                        </li>

                    </ul>

                </li>

                @endif

                {{-- Report --}}
                @if(in_array(Auth::user()->role, ['admin','manager','gudang','sales']))

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        Report

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item"
                               href="/stock-card">
                                Kartu Stok
                            </a>
                        </li>

                        @if(in_array(Auth::user()->role, ['admin','manager']))

                        <li>
                            <a class="dropdown-item"
                               href="/stock-report">
                                Laporan Stok
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/activity-logs">
                                Activity Log
                            </a>
                        </li>

                        @endif

                    </ul>

                </li>

                @endif

                {{-- Admin --}}
                @if(Auth::user()->role == 'admin')

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">

                        Admin

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item"
                               href="/users">
                                User
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="/backup">
                                Backup
                            </a>
                        </li>

                    </ul>

                </li>

                @endif

                {{-- Tools --}}
                @if(in_array(Auth::user()->role, ['admin','manager','gudang']))

                <li class="nav-item">
                    <a href="/scan-qr"
                       class="nav-link">
                        Scan QR
                    </a>
                </li>

                @endif

                {{-- Logout --}}
                <li class="nav-item ms-lg-3">

                    <form action="/logout"
                          method="POST">

                        @csrf

                        <button class="btn btn-warning btn-sm">
                            Logout
                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</nav>