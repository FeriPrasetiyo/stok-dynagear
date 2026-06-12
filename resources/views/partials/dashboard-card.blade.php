<div class="row">

    <div class="col-12 col-md-6 col-lg-3 mb-3">
        <div class="card shadow border-0">
            <div class="card-body">

                <p class="text-muted mb-1">
                    Total Barang
                </p>

                <h3 class="fw-bold">
                    {{ $totalBarang }}
                </h3>

                <span class="badge bg-primary">
                    Master Barang
                </span>

            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-3">
        <div class="card shadow border-0">
            <div class="card-body">

                <p class="text-muted mb-1">
                    Total Stok Aktual
                </p>

                <h3 class="fw-bold">
                    {{ $totalStok }}
                </h3>

                <span class="badge bg-success">
                    Qty Semua Barang
                </span>

            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-3">
        <div class="card shadow border-0">
            <div class="card-body">

                <p class="text-muted mb-1">
                    Stok Minimum
                </p>

                <h3 class="fw-bold">
                    {{ $stokMinimumCount }}
                </h3>

                @if($stokMinimumCount > 0)

                    <span class="badge bg-danger">
                        Segera Restock
                    </span>

                @else

                    <span class="badge bg-success">
                        Aman
                    </span>

                @endif

            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-3">
        <div class="card shadow border-0">
            <div class="card-body">

                <p class="text-muted mb-1">
                    Transaksi Hari Ini
                </p>

                <h3 class="fw-bold">
                    {{ $stokMasukHariIni + $stokKeluarHariIni }}
                </h3>

                <span class="badge bg-dark">
                    Masuk {{ $stokMasukHariIni }}
                    /
                    Keluar {{ $stokKeluarHariIni }}
                </span>

            </div>
        </div>
    </div>

</div>