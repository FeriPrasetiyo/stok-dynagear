@extends('layouts.app')

@section('title', 'Laporan Stok')

@section('content')

<div class="container mt-4 mb-5">

    <h3 class="mb-3">Laporan Stok</h3>

    <div class="mb-3 d-flex gap-2 flex-wrap">
        <a href="/stock-report/export?brand_id={{ request('brand_id') }}"
           class="btn btn-success">
            Export CSV
        </a>

        <a href="/stock-report/print?brand_id={{ request('brand_id') }}"
           class="btn btn-danger">
            Print / PDF
        </a>

        <a href="/stock-report/pdf?brand_id={{ request('brand_id') }}"
           class="btn btn-danger">
            PDF
        </a>
    </div>

    <div class="card shadow border-0 mb-3">
        <div class="card-body">

            <form method="GET" action="/stock-report">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">
                            Filter Brand
                        </label>

                        <select name="brand_id"
                                class="form-select">

                            <option value="">
                                Semua Brand
                            </option>

                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->nama_merek }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button class="btn btn-primary">
                            Filter
                        </button>

                        <a href="/stock-report"
                           class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="card shadow border-0">

        <div class="table-responsive">

            <table class="table table-bordered align-middle mb-0">

                <thead class="table-primary">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Brand</th>
                        <th>Stok Awal</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Stok Aktual</th>
                        <th>Minimum</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)

                        <tr>
                            <td>{{ $product->kode_barang }}</td>

                            <td>{{ $product->nama_barang }}</td>

                            <td>{{ $product->category->nama_category ?? '-' }}</td>

                            <td>{{ $product->brand->nama_merek ?? '-' }}</td>

                            <td>{{ $product->stok_awal }}</td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $product->stock_in }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-danger">
                                    {{ $product->stock_out }}
                                </span>
                            </td>

                            <td>
                                <strong>{{ $product->stock_actual }}</strong>
                            </td>

                            <td>{{ $product->stok_minimum }}</td>

                            <td>
                                @if($product->stock_actual <= $product->stok_minimum)
                                    <span class="badge bg-danger">
                                        Stok Minimum
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Aman
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="text-center">
                                Belum ada data barang.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection