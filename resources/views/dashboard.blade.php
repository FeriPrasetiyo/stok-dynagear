@extends('layouts.app')

@section('title', 'Dashboard Stok')

@section('content')

@php
    $role = auth()->user()->role ?? '';

    $canSeeStockMinimum = in_array($role, [
        'super_admin',
        'manager_pl',
        'admin_pl',
        'gudang',
    ]);
@endphp

<div class="mb-4">

    <h3 class="fw-bold">
        Dashboard Stok Aktual
    </h3>

    <p class="text-muted mb-0">
        Selamat datang,
        <strong>{{ Auth::user()->name }}</strong>
    </p>

</div>

<div class="row">

    <div class="col-12 col-md-6 col-lg-3 mb-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <p class="text-muted mb-1">Total Barang</p>

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
                <p class="text-muted mb-1">Total Stok Aktual</p>

                <h3 class="fw-bold">
                    {{ $totalStok }}
                </h3>

                <span class="badge bg-success">
                    Qty Semua Barang
                </span>
            </div>
        </div>
    </div>

    @if($canSeeStockMinimum)

        <div class="col-12 col-md-6 col-lg-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <p class="text-muted mb-1">Stok Minimum</p>

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

    @endif

    <div class="col-12 col-md-6 col-lg-3 mb-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <p class="text-muted mb-1">Transaksi Hari Ini</p>

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

@if($canSeeStockMinimum && $stokMinimumCount > 0)

    <div class="alert alert-warning mt-3">
        <strong>Perhatian!</strong>
        Ada <strong>{{ $stokMinimumCount }}</strong>
        barang yang mendekati stok minimum.
    </div>

@endif

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

                        <div class="border rounded p-3 bg-light h-100">

                            <h6 class="fw-bold">
                                {{ $warehouse['nama_gudang'] }}
                            </h6>

                            <h3 class="text-primary fw-bold">
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

@if($canSeeStockMinimum)

    <div class="card shadow border-0 mt-4">

        <div class="card-header bg-danger text-white">
            Top 10 Barang Stok Minimum
        </div>

        <div class="card-body">

            @if(count($stokMinimumProducts) > 0)

                <div class="table-responsive">

                    <table class="table table-bordered align-middle mb-0">

                        <thead class="table-danger">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Gudang</th>
                                <th>Satuan</th>
                                <th>Stok Aktual</th>
                                <th>Stok Minimum</th>
                                <th>Lokasi Rak</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($stokMinimumProducts as $product)

                                <tr>
                                    <td>{{ $product->kode_barang }}</td>

                                    <td>{{ $product->nama_barang }}</td>

                                    <td>{{ $product->kategori ?? '-' }}</td>

                                    <td>{{ $product->warehouse->nama_gudang ?? '-' }}</td>

                                    <td>
                                        {{ $product->unit->nama_satuan ?? '-' }}

                                        @if($product->unit && $product->unit->kode)
                                            ({{ $product->unit->kode }})
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $product->stok_aktual }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $product->stok_minimum }}
                                    </td>

                                    <td>
                                        {{ $product->lokasi_rak ?? '-' }}
                                    </td>

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

@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('stockChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Total Barang',
                'Total Stok',
                @if($canSeeStockMinimum)
                    'Stok Minimum',
                @endif
                'Transaksi Hari Ini'
            ],
            datasets: [{
                label: 'Dashboard Stok',
                data: [
                    {{ $totalBarang }},
                    {{ $totalStok }},
                    @if($canSeeStockMinimum)
                        {{ $stokMinimumCount }},
                    @endif
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