@extends('layouts.app')

@section('title', 'Kartu Stok')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<h3 class="fw-bold mb-3">
    Kartu Stok
</h3>

<div class="card shadow border-0 mb-4">
    <div class="card-body">

        <form method="GET" action="/stock-card">

            <div class="mb-3">
                <label class="form-label">
                    Cari Barang
                </label>

                <select name="product_id"
                        id="product_id"
                        class="form-control">

                    <option value="">
                        Cari kode / nama barang...
                    </option>

                    @foreach($products as $item)
                        <option value="{{ $item->id }}"
                            {{ request('product_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->kode_barang }} - {{ $item->nama_barang }}
                        </option>
                    @endforeach

                </select>
            </div>

            <button class="btn btn-primary">
                Tampilkan Kartu Stok
            </button>

            <a href="/stock-card"
               class="btn btn-secondary">
                Reset
            </a>

        </form>

    </div>
</div>

@if($product)

    <div class="card shadow border-0 mb-4">

        <div class="card-header bg-primary text-white">
            <strong>
                Informasi Barang
            </strong>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <p class="mb-1">
                        <strong>Kode:</strong>
                        {{ $product->kode_barang }}
                    </p>

                    <p class="mb-1">
                        <strong>Nama Barang:</strong>
                        {{ $product->nama_barang }}
                    </p>

                    <p class="mb-1">
                        <strong>Kategori:</strong>
                        {{ $product->category->nama_category ?? '-' }}
                    </p>

                    <p class="mb-1">
                        <strong>Brand:</strong>
                        {{ $product->brand->nama_merek ?? '-' }}
                    </p>

                </div>

                <div class="col-md-6">

                    <p class="mb-1">
                        <strong>Gudang:</strong>
                        {{ $product->warehouse->nama_gudang ?? '-' }}
                    </p>

                    <p class="mb-1">
                        <strong>Unit:</strong>

                        @if($product->unit)
                            {{ $product->unit->nama_satuan }}

                            @if($product->unit->kode)
                                ({{ $product->unit->kode }})
                            @endif
                        @else
                            -
                        @endif
                    </p>

                    <p class="mb-1">
                        <strong>Stok Minimum:</strong>
                        {{ $product->stok_minimum }}
                    </p>

                    <p class="mb-1">
                        <strong>Saldo Akhir:</strong>
                        <span class="badge bg-success">
                            {{ $saldo }}
                        </span>
                    </p>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow border-0">

        <div class="card-header bg-dark text-white">
            Riwayat Mutasi Stok
        </div>

        <div class="table-responsive">

            <table class="table table-bordered align-middle mb-0">

                <thead class="table-primary">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Dokumen</th>
                        <th>Keterangan</th>
                        <th>Qty Mutasi</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Saldo</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($mutations as $row)

                        <tr>

                            <td>
                                {{ date('d-m-Y H:i', strtotime($row['tanggal'])) }}
                            </td>

                            <td>
                                @if($row['jenis'] == 'STOK MASUK')
                                    <span class="badge bg-success">
                                        STOK MASUK
                                    </span>
                                @elseif($row['jenis'] == 'STOK KELUAR')
                                    <span class="badge bg-danger">
                                        STOK KELUAR
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        STOK AWAL
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $row['dokumen'] ?? '-' }}
                            </td>

                            <td>
                                {{ $row['keterangan'] ?? '-' }}
                            </td>

                            <td>
                                @if($row['jenis'] == 'STOK MASUK')
                                    <span class="badge bg-success">
                                        {{ $row['masuk'] }}
                                    </span>
                                @elseif($row['jenis'] == 'STOK KELUAR')
                                    <span class="badge bg-danger">
                                        {{ $row['keluar'] }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ $row['masuk'] }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $row['masuk'] }}
                            </td>

                            <td>
                                {{ $row['keluar'] }}
                            </td>

                            <td>
                                <strong>
                                    {{ $row['saldo'] }}
                                </strong>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada mutasi stok.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@else

    <div class="alert alert-info">
        Silakan cari dan pilih barang untuk melihat kartu stok.
    </div>

@endif

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('#product_id').select2({
        placeholder: 'Cari kode atau nama barang',
        width: '100%'
    });
</script>

@endsection