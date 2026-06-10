<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Barang - Dynagear Stock</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a href="/products" class="navbar-brand">Dynagear Stock</a>

        <a href="/products" class="btn btn-light btn-sm">
            Kembali
        </a>
    </div>
</nav>

<div class="container mt-4 mb-5">

    <div class="card shadow border-0">

        <div class="card-header bg-warning">
            <h4 class="mb-0">Edit Barang</h4>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode Barang</label>
                    <input type="text"
                           name="kode_barang"
                           class="form-control"
                           value="{{ old('kode_barang', $product->kode_barang) }}"
                           required>
                </div>
<div class="mb-3">
    <label class="form-label">Gudang</label>

    <select name="warehouse_id"
            class="form-control">

        <option value="">
            Pilih Gudang
        </option>

        @foreach($warehouses as $warehouse)
            <option value="{{ $warehouse->id }}"
                {{ old('warehouse_id', $product->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
                {{ $warehouse->nama_gudang }}
            </option>
        @endforeach

    </select>
</div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text"
                           name="nama_barang"
                           class="form-control"
                           value="{{ old('nama_barang', $product->nama_barang) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text"
                           name="kategori"
                           class="form-control"
                           value="{{ old('kategori', $product->kategori) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text"
                           name="satuan"
                           class="form-control"
                           value="{{ old('satuan', $product->satuan) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok Awal</label>
                    <input type="number"
                           name="stok_awal"
                           class="form-control"
                           value="{{ old('stok_awal', $product->stok_awal) }}"
                           min="0"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok Minimum</label>
                    <input type="number"
                           name="stok_minimum"
                           class="form-control"
                           value="{{ old('stok_minimum', $product->stok_minimum) }}"
                           min="0"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi Rak</label>
                    <input type="text"
                           name="lokasi_rak"
                           class="form-control"
                           value="{{ old('lokasi_rak', $product->lokasi_rak) }}">
                </div>

                <div class="mb-3">
    <label class="form-label">Foto Barang</label>

    @if($product->foto)
        <div class="mb-2">
            <img src="{{ asset('storage/'.$product->foto) }}"
                 style="width:120px; height:120px; object-fit:cover;"
                 class="rounded border">
        </div>
    @endif

    <input type="file"
           name="foto"
           class="form-control"
           accept="image/*">
</div>

                <div class="mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="3">{{ old('keterangan', $product->keterangan) }}</textarea>
                </div>

                <button class="btn btn-warning">
                    Update
                </button>

                <a href="/products" class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>