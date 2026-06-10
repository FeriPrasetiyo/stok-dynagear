@extends('layouts.app')

@section('title', 'Dashboard Stok')

@section('content')

<div class="container mt-4 mb-5">
<div class="mb-4">

    <h3 class="fw-bold">
        Dashboard Stok Aktual
    </h3>

    <p class="text-muted mb-0">
        Selamat datang,
        <strong>{{ Auth::user()->name }}</strong>
    </p>

    @if($stokMinimumCount > 0)

        <div class="alert alert-danger mt-3">

            <strong>Perhatian!</strong>

            Terdapat

            <strong>
                {{ $stokMinimumCount }}
            </strong>

            barang yang sudah mencapai stok minimum.

        </div>

    @endif

</div>

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

<div class="card shadow border-0 mt-4">

    <div class="card-header bg-primary text-white">
        Grafik Dashboard
    </div>

    <div class="card-body">
        <canvas id="stockChart" height="100"></canvas>
    </div>

</div>

<div class="card shadow border-0 mt-4">

    <div class="card-header bg-info text-white">
        Stok Per Gudang
    </div>

    <div class="card-body">

        @if(isset($warehouseSummary) && count($warehouseSummary) > 0)

            <div class="row">

                @foreach($warehouseSummary as $warehouse)

                    <div class="col-md-4 mb-3">

                        <div class="border rounded p-3 bg-light">

                            <h6 class="fw-bold">
                                {{ $warehouse['nama_gudang'] }}
                            </h6>

                            <h3 class="text-primary">
                                {{ $warehouse['stok'] }}
                            </h3>

                            <small class="text-muted">
                                Total Stok Barang
                            </small>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="alert alert-info mb-0">
                Belum ada data gudang.
            </div>

        @endif

    </div>

</div>

<div class="row mt-4">

    @foreach($stokMinimumProducts as $product)

        <div class="col-md-4 mb-3">

            <div class="card border-danger">

                <div class="card-body">

                    <h6>
                        {{ $product->nama_barang }}
                    </h6>

                    <span class="badge bg-danger">
                        Sisa {{ $product->stok_aktual }}
                    </span>

                </div>

            </div>

        </div>

    @endforeach

</div>

<div class="card shadow border-0 mt-4">

    <div class="card-header bg-danger text-white">
        Barang Stok Minimum
    </div>

    <div class="card-body">

        @if(count($stokMinimumProducts) > 0)

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-danger">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok Aktual</th>
                            <th>Stok Minimum</th>
                            <th>Lokasi Rak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($stokMinimumProducts as $product)

                            <tr>

                                <td>{{ $product->kode_barang }}</td>

                                <td>{{ $product->nama_barang }}</td>

                                <td>{{ $product->kategori ?? '-' }}</td>

                                <td>
                                    <span class="badge bg-danger">
                                        {{ $product->stok_aktual }}
                                    </span>
                                </td>

                                <td>{{ $product->stok_minimum }}</td>

                                <td>{{ $product->lokasi_rak ?? '-' }}</td>

                                <td>

                                    <a href="/products/{{ $product->id }}"
                                       class="btn btn-primary btn-sm">
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="alert alert-success mb-0">
                Semua stok masih aman.
            </div>

        @endif

    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('stockChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'Total Barang',
            'Total Stok',
            'Stok Minimum',
            'Transaksi Hari Ini'
        ],
        datasets: [{
            label: 'Dashboard Stok',
            data: [
                {{ $totalBarang }},
                {{ $totalStok }},
                {{ $stokMinimumCount }},
                {{ $stokMasukHariIni + $stokKeluarHariIni }}
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>

@endsection
