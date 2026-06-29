@php
    $role = Auth::user()->role ?? '';

    $isAdmin = in_array($role, [
        'super_admin',
        'admin_pl',
    ]);

    $isManager = in_array($role, [
        'super_admin',
        'manager_pl',
        'manager_sales',
    ]);

    $isSales = in_array($role, [
        'super_admin',
        'sales',
        'admin_sales',
        'manager_sales',
    ]);

    $isGudang = in_array($role, [
        'super_admin',
        'gudang',
    ]);

    $isPurchasing = in_array($role, [
        'super_admin',
        'purchasing',
    ]);

    $canInventory = $isAdmin || $isManager || $isGudang;
    $canTransaction = $isAdmin || $isManager || $isGudang;
    $canPurchasing = $isAdmin || $isManager || $isPurchasing;
    $canStockCard = $isAdmin || $isManager || $isGudang || $isSales || $isPurchasing;
    $canStockReport = $isAdmin || $isManager;
    $canSalesSearch = $isSales;
    $canAdminMenu = $isAdmin;
@endphp

<div class="sidebar bg-white border-end shadow-sm min-vh-100 p-3">

    <ul class="nav flex-column">

        <li class="nav-item mb-1">
            <a href="/dashboard" class="nav-link text-dark">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        @if($canInventory)
            <li class="nav-item mt-3 mb-1 text-muted small fw-bold">
                MASTER DATA
            </li>

            <li class="nav-item">
                <a href="/products" class="nav-link text-dark">
                    <i class="bi bi-box-seam me-2"></i>
                    Master Barang
                </a>
            </li>

            <li class="nav-item">
                <a href="/brands" class="nav-link text-dark">
                    <i class="bi bi-tags me-2"></i>
                    Merek
                </a>
            </li>

            <li class="nav-item">
                <a href="/units" class="nav-link text-dark">
                    <i class="bi bi-rulers me-2"></i>
                    Satuan
                </a>
            </li>

            <li class="nav-item">
                <a href="/categories" class="nav-link text-dark">
                    <i class="bi bi-grid me-2"></i>
                    Category
                </a>
            </li>

            <li class="nav-item">
                <a href="/warehouses" class="nav-link text-dark">
                    <i class="bi bi-building me-2"></i>
                    Gudang
                </a>
            </li>
        @endif

        @if($canTransaction)
            <li class="nav-item mt-3 mb-1 text-muted small fw-bold">
                TRANSAKSI
            </li>

            <li class="nav-item">
                <a href="/stock-in" class="nav-link text-dark">
                    <i class="bi bi-arrow-down-circle me-2"></i>
                    Stok Masuk
                </a>
            </li>

            <li class="nav-item">
                <a href="/stock-out" class="nav-link text-dark">
                    <i class="bi bi-arrow-up-circle me-2"></i>
                    Stok Keluar
                </a>
            </li>

            <li class="nav-item">
                <a href="/stock-opname" class="nav-link text-dark">
                    <i class="bi bi-clipboard-check me-2"></i>
                    Stock Opname
                </a>
            </li>

            <li class="nav-item">
                <a href="/item-requests" class="nav-link text-dark">
                    <i class="bi bi-card-checklist me-2"></i>
                    Request Barang
                </a>
            </li>
        @endif

        @if($canPurchasing)
            <li class="nav-item mt-3 mb-1 text-muted small fw-bold">
                PURCHASING
            </li>

            <li class="nav-item">
                <a href="/suppliers" class="nav-link text-dark">
                    <i class="bi bi-truck me-2"></i>
                    Supplier
                </a>
            </li>

            <li class="nav-item">
                <a href="/purchase-orders" class="nav-link text-dark">
                    <i class="bi bi-cart-check me-2"></i>
                    Purchase Order
                </a>
            </li>
        @endif

        @if($canStockCard || $canStockReport)
            <li class="nav-item mt-3 mb-1 text-muted small fw-bold">
                REPORT
            </li>

            @if($canStockCard)
                <li class="nav-item">
                    <a href="/stock-card" class="nav-link text-dark">
                        <i class="bi bi-journal-text me-2"></i>
                        Kartu Stok
                    </a>
                </li>
            @endif

            @if($canStockReport)
                <li class="nav-item">
                    <a href="/stock-report" class="nav-link text-dark">
                        <i class="bi bi-bar-chart me-2"></i>
                        Laporan Stok
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/activity-logs" class="nav-link text-dark">
                        <i class="bi bi-clock-history me-2"></i>
                        Activity Log
                    </a>
                </li>
            @endif
        @endif

        @if($canSalesSearch)
            <li class="nav-item mt-3">
                <a href="/sales/stock-search" class="nav-link text-dark">
                    <i class="bi bi-search me-2"></i>
                    Cari Stok Sales
                </a>
            </li>
        @endif

        @if($canInventory)
            <li class="nav-item">
                <a href="/scan-qr" class="nav-link text-dark">
                    <i class="bi bi-qr-code-scan me-2"></i>
                    Scan QR
                </a>
            </li>
        @endif

        @if($canAdminMenu)
            <li class="nav-item mt-3 mb-1 text-muted small fw-bold">
                ADMIN
            </li>

            <li class="nav-item">
                <a href="/backup" class="nav-link text-dark">
                    <i class="bi bi-database-down me-2"></i>
                    Backup
                </a>
            </li>
        @endif

    </ul>

</div>