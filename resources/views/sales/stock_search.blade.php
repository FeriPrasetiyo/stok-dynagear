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
                Cek stok barang dan jumlah Outstanding PO yang sedang dipesan Purchasing.
            </p>

            <form method="GET" action="/sales/stock-search">
                <div class="row g-2">

                    <div class="col-12 col-md-6">
                        <input type="text"
                               name="search"
                               value="{{ $search }}"
                               class="form-control form-control-lg"
                               placeholder="Cari kode / nama / kategori / brand...">
                    </div>

                    <div class="col-12 col-md-3">
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

                    <div class="col-6 col-md-1 d-grid">
                        <button class="btn btn-primary btn-lg">
                            Cari
                        </button>
                    </div>

                    <div class="col-6 col-md-2 d-grid">
                        <a href="/sales/stock-search"
                           class="btn btn-secondary btn-lg">
                            Reset
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">
            Data Stok Sales
        </h5>

        <span class="badge bg-primary">
            Total: {{ $products->total() }}
        </span>
    </div>

    {{-- Tampilan Mobile --}}
    <div class="d-md-none">

        @forelse($products as $product)

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div class="mb-3">

                        <div class="fw-bold text-primary">
                            {{ $product->kode_barang }}
                        </div>

                        <div class="fw-semibold">
                            {{ $product->nama_barang }}
                        </div>

                    </div>

                    <div class="row small text-muted">

                        <div class="col-6 mb-2">
                            Brand
                            <div class="text-dark fw-semibold">
                                {{ $product->brand->nama_merek ?? '-' }}
                            </div>
                        </div>

                        <div class="col-6 mb-2">
                            Kategori
                            <div class="text-dark">
                                {{ $product->category->nama_category ?? '-' }}
                            </div>
                        </div>

                        <div class="col-6 mb-2">
                            Unit
                            <div class="text-dark">
                                {{ $product->unit->nama_satuan ?? '-' }}

                                @if($product->unit && $product->unit->kode)
                                    ({{ $product->unit->kode }})
                                @endif
                            </div>
                        </div>

                        <div class="col-6 mb-2">
                            Gudang
                            <div class="text-dark">
                                {{ $product->warehouse->nama_gudang ?? '-' }}
                            </div>
                        </div>

                        <div class="col-6 mb-2">
                            Stok
                            <div>
                                <span class="badge bg-dark fs-6">
                                    {{ $product->stock_actual }}
                                </span>
                            </div>
                        </div>

                        <div class="col-6 mb-2">
                            Outstanding PO
                            <div>
                                <span class="badge bg-warning text-dark fs-6">
                                    {{ $product->outstanding_po_qty ?? 0 }}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        @empty

            <div class="alert alert-info text-center">
                Barang tidak ditemukan.
            </div>

        @endforelse

    </div>

    {{-- Tampilan Desktop --}}
    <div class="card shadow border-0 d-none d-md-block">

        <div class="table-responsive">

            <table class="table table-sm table-bordered table-hover align-middle mb-0">

                <thead class="table-primary">
                    <tr>
                        <th>Barang</th>
                        <th>Brand</th>
                        <th>Kategori</th>
                        <th>Unit</th>
                        <th>Gudang</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Outstanding PO</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>
                            <td style="min-width: 280px;">
                                <strong class="text-primary">
                                    {{ $product->kode_barang }}
                                </strong>
                                <br>

                                <span class="text-truncate d-inline-block"
                                      style="max-width: 260px;"
                                      title="{{ $product->nama_barang }}">
                                    {{ $product->nama_barang }}
                                </span>
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

                            <td class="text-center">
                                <span class="badge bg-dark fs-6">
                                    {{ $product->stock_actual }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-warning text-dark fs-6">
                                    {{ $product->outstanding_po_qty ?? 0 }}
                                </span>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                Barang tidak ditemukan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">
        {{ $products->withQueryString()->links() }}
    </div>

</div>

@endsection