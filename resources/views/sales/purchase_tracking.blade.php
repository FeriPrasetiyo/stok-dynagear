@extends('layouts.app')

@section('title', 'Tracking Purchase Product')

@section('content')

<div class="container-fluid mt-4 mb-5">

    <div class="card shadow border-0 mb-4">
        <div class="card-body">

            <h3 class="fw-bold mb-2">
                Tracking Purchase Product
            </h3>

            <p class="text-muted mb-3">
                Pantau barang yang sedang dipesan Purchasing.
            </p>

            <form method="GET" action="{{ route('sales.purchase-tracking') }}">
                <div class="row g-2">

                    <div class="col-12 col-md-4">
                        <input type="text"
                               name="search"
                               value="{{ $search }}"
                               class="form-control form-control-lg"
                               placeholder="Cari kode / nama / brand / kategori...">
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

                    <div class="col-12 col-md-3">
                        <select name="status"
                                class="form-select form-select-lg">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>

                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                Approved / Dipesan
                            </option>

                            <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>
                                Ordered
                            </option>

                            <option value="partial_received" {{ request('status') == 'partial_received' ? 'selected' : '' }}>
                                Sebagian Datang
                            </option>

                            <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>
                                Sudah Datang
                            </option>

                        </select>
                    </div>

                    <div class="col-6 col-md-1 d-grid">
                        <button class="btn btn-primary btn-lg">
                            Cari
                        </button>
                    </div>

                    <div class="col-6 col-md-1 d-grid">
                        <a href="{{ route('sales.purchase-tracking') }}"
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
            Data Tracking Purchase
        </h5>

        <span class="badge bg-primary">
            Total: {{ $details->total() }}
        </span>
    </div>

    <div class="card shadow border-0 d-none d-md-block">

        <div class="table-responsive">

            <table class="table table-sm table-bordered table-hover align-middle mb-0">

                <thead class="table-primary">
                    <tr>
                        <th>No PO</th>
                        <th>Tanggal PO</th>
                        <th>Barang</th>
                        <th>Brand</th>
                        <th class="text-center">Qty PO</th>
                        <th class="text-center">Diterima</th>
                        <th class="text-center">Sisa</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($details as $detail)

                        @php
                            $po = $detail->purchaseOrder;
                            $product = $detail->product;
                            $qtyReceived = $detail->qty_received ?? 0;
                            $sisa = max(0, ($detail->qty ?? 0) - $qtyReceived);

                            $statusLabel = [
                                'draft' => 'Draft',
                                'approved' => 'Dipesan',
                                'ordered' => 'Dipesan',
                                'partial_received' => 'Sebagian Datang',
                                'received' => 'Sudah Datang',
                                'cancelled' => 'Dibatalkan',
                            ][$po->status] ?? strtoupper($po->status);

                            $statusClass = [
                                'draft' => 'bg-secondary',
                                'approved' => 'bg-warning text-dark',
                                'ordered' => 'bg-warning text-dark',
                                'partial_received' => 'bg-info text-dark',
                                'received' => 'bg-success',
                                'cancelled' => 'bg-danger',
                            ][$po->status] ?? 'bg-dark';
                        @endphp

                        <tr>
                            <td>
                                {{ $po->nomor_po ?? '-' }}
                            </td>

                            <td>
                                {{ $po->tanggal ?? '-' }}
                            </td>

                            <td style="min-width: 280px;">
                                <strong class="text-primary">
                                    {{ $product->kode_barang ?? '-' }}
                                </strong>
                                <br>

                                <span class="text-truncate d-inline-block"
                                      style="max-width: 260px;"
                                      title="{{ $product->nama_barang ?? '-' }}">
                                    {{ $product->nama_barang ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $product->brand->nama_merek ?? '-' }}
                            </td>

                            <td class="text-center">
                                <span class="badge bg-dark">
                                    {{ $detail->qty ?? 0 }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-success">
                                    {{ $qtyReceived }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-warning text-dark">
                                    {{ $sisa }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="badge {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                Data tracking purchase tidak ditemukan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="d-md-none">

        @forelse($details as $detail)

            @php
                $po = $detail->purchaseOrder;
                $product = $detail->product;
                $qtyReceived = $detail->qty_received ?? 0;
                $sisa = max(0, ($detail->qty ?? 0) - $qtyReceived);

                $statusLabel = [
                    'draft' => 'Draft',
                    'approved' => 'Dipesan',
                    'ordered' => 'Dipesan',
                    'partial_received' => 'Sebagian Datang',
                    'received' => 'Sudah Datang',
                    'cancelled' => 'Dibatalkan',
                ][$po->status] ?? strtoupper($po->status);

                $statusClass = [
                    'draft' => 'bg-secondary',
                    'approved' => 'bg-warning text-dark',
                    'ordered' => 'bg-warning text-dark',
                    'partial_received' => 'bg-info text-dark',
                    'received' => 'bg-success',
                    'cancelled' => 'bg-danger',
                ][$po->status] ?? 'bg-dark';
            @endphp

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <div class="fw-bold text-primary">
                                {{ $product->kode_barang ?? '-' }}
                            </div>

                            <div class="fw-semibold">
                                {{ $product->nama_barang ?? '-' }}
                            </div>
                        </div>

                        <span class="badge {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="row small text-muted">

                        <div class="col-6 mb-2">
                            No PO
                            <div class="text-dark fw-semibold">
                                {{ $po->nomor_po ?? '-' }}
                            </div>
                        </div>

                        <div class="col-6 mb-2">
                            Tanggal
                            <div class="text-dark">
                                {{ $po->tanggal ?? '-' }}
                            </div>
                        </div>

                        <div class="col-6 mb-2">
                            Brand
                            <div class="text-dark">
                                {{ $product->brand->nama_merek ?? '-' }}
                            </div>
                        </div>
                        
                        <div class="col-4 mb-2">
                            Qty PO
                            <div>
                                <span class="badge bg-dark">
                                    {{ $detail->qty ?? 0 }}
                                </span>
                            </div>
                        </div>

                        <div class="col-4 mb-2">
                            Diterima
                            <div>
                                <span class="badge bg-success">
                                    {{ $qtyReceived }}
                                </span>
                            </div>
                        </div>

                        <div class="col-4 mb-2">
                            Sisa
                            <div>
                                <span class="badge bg-warning text-dark">
                                    {{ $sisa }}
                                </span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        @empty

            <div class="alert alert-info text-center">
                Data tracking purchase tidak ditemukan.
            </div>

        @endforelse

    </div>

    <div class="mt-3">
        {{ $details->withQueryString()->links() }}
    </div>

</div>

@endsection