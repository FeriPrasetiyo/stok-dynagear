@extends('layouts.app')

@section('title', 'Pencarian Stok Sales')

@section('content')

<div class="container-fluid mt-4 mb-5">

    <div class="card shadow border-0 mb-4">
        <div class="card-body">

            <h3 class="fw-bold mb-2">
                Pencarian Stok Sales
            </h3>

            <p class="text-muted mb-3">
                Halaman ini digunakan untuk mengecek ketersediaan stok barang.
            </p>

            <form method="GET" action="/sales/stock-search">

                <div class="row g-2">

                    <div class="col-12 col-md-4">
                        <label class="form-label d-md-none">
                            Pencarian
                        </label>

                        <input type="text"
                               name="search"
                               value="{{ $search }}"
                               class="form-control form-control-lg"
                               placeholder="Cari kode / nama / kategori...">
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label d-md-none">
                            Brand
                        </label>

                        <select name="brand_id"
                                class="form-select form-select-lg">
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

                    <div class="col-6 col-md-2">
                        <label class="form-label d-md-none">
                            Status
                        </label>

                        <select name="status"
                                class="form-select form-select-lg">
                            <option value="">
                                Semua Stok
                            </option>

                            <option value="tersedia"
                                {{ request('status') == 'tersedia' ? 'selected' : '' }}>
                                Tersedia
                            </option>

                            <option value="kosong"
                                {{ request('status') == 'kosong' ? 'selected' : '' }}>
                                Kosong
                            </option>
                        </select>
                    </div>

                    <div class="col-6 col-md-2">
                        <label class="form-label d-md-none">
                            Urutan
                        </label>

                        <select name="sort"
                                class="form-select form-select-lg">
                            <option value="">
                                Urutan
                            </option>

                            <option value="stok_terbanyak"
                                {{ request('sort') == 'stok_terbanyak' ? 'selected' : '' }}>
                                Stok Banyak
                            </option>

                            <option value="stok_terkecil"
                                {{ request('sort') == 'stok_terkecil' ? 'selected' : '' }}>
                                Stok Kecil
                            </option>
                        </select>
                    </div>

                    <div class="col-12 col-md-1 d-grid">
                        <button class="btn btn-primary btn-lg">
                            Cari
                        </button>
                    </div>

                    <div class="col-12 d-grid d-md-none">
                        <a href="/sales/stock-search"
                           class="btn btn-secondary btn-lg">
                            Reset
                        </a>
                    </div>

                    <div class="col-12 d-none d-md-block mt-2">
                        <a href="/sales/stock-search"
                           class="btn btn-secondary">
                            Reset Filter
                        </a>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <strong>
                Tabel Stok Barang
            </strong>

            <span class="badge bg-light text-dark align-self-start align-self-md-center">
                Total Data: {{ $products->total() }}
            </span>
        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0 table-sm">

                <thead class="table-primary">
                    <tr>
                        <th width="130">Kode</th>
                        <th>Nama Barang</th>
                        <th width="140">Brand</th>
                        <th width="140">Kategori</th>
                        <th width="100">Unit</th>
                        <th width="140">Gudang</th>
                        <th width="130">Stok</th>
                        <th width="130">Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>
                            <td>
                                <strong>{{ $product->kode_barang }}</strong>
                            </td>

                            <td style="min-width: 220px;">
                                <strong class="d-block d-md-none text-primary">
                                    {{ $product->kode_barang }}
                                </strong>

                                {{ $product->nama_barang }}
                            </td>

                            <td>
                                {{ $product->brand->nama_merek ?? '-' }}
                            </td>

                            <td>
                                {{ $product->category->nama_category ?? '-' }}
                            </td>

                            <td>
                                {{ $product->unit->nama_satuan ?? '-' }}

                                @if($product->unit && $product->unit->kode)
                                    ({{ $product->unit->kode }})
                                @endif
                            </td>

                            <td>
                                {{ $product->warehouse->nama_gudang ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-dark fs-6">
                                    {{ $product->stock_actual }}
                                </span>
                            </td>

                            <td>
                                @if($product->stock_actual <= 0)
                                    <span class="badge bg-danger">
                                        Kosong
                                    </span>
                                @elseif($product->stock_actual <= $product->stok_minimum)
                                    <span class="badge bg-warning text-dark">
                                        Terbatas
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Tersedia
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8"
                                class="text-center">
                                Barang tidak ditemukan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer">
            {{ $products->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection