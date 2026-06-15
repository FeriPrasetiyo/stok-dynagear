@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')


<div class="container mt-4 mb-5">

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="fw-bold mb-1">
            Master Barang
        </h3>

        <p class="text-muted mb-0">
            Data barang dan stok awal
        </p>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('products.template') }}"
           class="btn btn-info">
            Download Template
        </a>

        <a href="{{ route('products.import.index') }}"
           class="btn btn-primary">
            Import Excel
        </a>

        <a href="/products/create"
           class="btn btn-success">
            + Tambah Barang
        </a>

    </div>

</div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow border-0 mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="input-group">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari kode / nama / category..."
                           value="{{ request('search') }}">

                    <button class="btn btn-primary">
                        Cari
                    </button>

                    <a href="/products" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">

        @forelse($products as $product)

            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        @if($product->foto)
                            <img src="{{ asset('storage/'.$product->foto) }}"
                                 class="img-fluid rounded mb-3"
                                 style="height:220px;width:100%;object-fit:cover;">
                        @else
                            <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center"
                                 style="height:220px;">
                                <span class="text-muted">
                                    Tidak ada foto
                                </span>
                            </div>
                        @endif

                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode(url('/products/'.$product->id)) }}"
     alt="QR Code">

                        <h5 class="fw-bold text-primary">
                            {{ $product->nama_barang }}
                        </h5>

                        <p class="mb-1">
    <strong>category:</strong>
    {{ $product->category->nama_category ?? '-' }}
</p>

<p class="mb-1">
    <strong>Merek:</strong>
    {{ $product->brand->nama_merek ?? '-' }}
</p>

<p class="mb-1">
    <strong>Gudang:</strong>
    {{ $product->warehouse->nama_gudang ?? '-' }}
</p>

<p class="mb-1">
    <strong>Satuan:</strong>

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
    <strong>Stok Awal:</strong>
    {{ $product->stok_awal }}
</p>

<p class="mb-1">
    <strong>Stok Minimum:</strong>
    {{ $product->stok_minimum }}
</p>

<p class="mb-1">
    <strong>Lokasi Rak:</strong>
    {{ $product->lokasi_rak ?? '-' }}
</p>

                        @php
                            $stokAktual = $product->stok_awal;
                        @endphp

                        <p class="mb-2">
                            <strong>Status:</strong>

                            @if($stokAktual <= $product->stok_minimum)
                                <span class="badge bg-danger">
                                    Stok Minimum
                                </span>
                            @else
                                <span class="badge bg-success">
                                    Aman
                                </span>
                            @endif
                        </p>

                        <p class="mb-0">
                            <strong>Keterangan:</strong>
                            {{ $product->keterangan ?? '-' }}
                        </p>

                    </div>

                    <div class="card-footer bg-white border-0">
                        <div class="d-grid gap-2">

                            <a href="/products/{{ $product->id }}"
                               class="btn btn-primary">
                                Detail
                            </a>

                            <a href="/products/{{ $product->id }}/edit"
                               class="btn btn-warning">
                                Edit
                            </a>

                            <form action="/products/{{ $product->id }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger w-100">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada data barang.
                </div>
            </div>

        @endforelse

    </div>

    <div class="mt-3">
        {{ $products->withQueryString()->links() }}
    </div>

</div>

@endsection