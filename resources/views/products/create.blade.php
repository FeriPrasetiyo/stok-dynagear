@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-success text-white">
        <h4 class="mb-0">
            Tambah Barang
        </h4>
    </div>

    <div class="card-body">

        <form action="/products"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label">
                    Kode Barang
                </label>

                <input type="text"
                       name="kode_barang"
                       class="form-control"
                       value="{{ old('kode_barang') }}"
                       placeholder="Contoh: BRG-001"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Gudang
                </label>

                <select name="warehouse_id"
                        class="form-control">

                    <option value="">
                        Pilih Gudang
                    </option>

                    @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}"
                            {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>

                            {{ $warehouse->nama_gudang }}

                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Nama Barang
                </label>

                <input type="text"
                       name="nama_barang"
                       class="form-control"
                       value="{{ old('nama_barang') }}"
                       placeholder="Contoh: Oil Seal"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    category
                </label>

                <select name="category"
                        class="form-control">

                    <option value="">
                        Pilih category
                    </option>

                    @foreach($categories as $category)
                        <option value="{{ $category->nama_category }}"
                            {{ old('category') == $category->nama_category ? 'selected' : '' }}>

                            {{ $category->nama_category }}

                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Merek
                </label>

                <select name="brand_id"
                        class="form-control">

                    <option value="">
                        Pilih Merek
                    </option>

                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>

                            {{ $brand->nama_merek }}

                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Satuan
                </label>

                <select name="unit_id"
                        class="form-control"
                        required>

                    <option value="">
                        Pilih Satuan
                    </option>

                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}"
                            {{ old('unit_id') == $unit->id ? 'selected' : '' }}>

                            {{ $unit->nama_satuan }}

                            @if($unit->kode)
                                - {{ $unit->kode }}
                            @endif

                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Stok Awal
                </label>

                <input type="number"
                       name="stok_awal"
                       class="form-control"
                       value="{{ old('stok_awal', 0) }}"
                       min="0"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Stok Minimum
                </label>

                <input type="number"
                       name="stok_minimum"
                       class="form-control"
                       value="{{ old('stok_minimum', 0) }}"
                       min="0"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Lokasi Rak
                </label>

                <input type="text"
                       name="lokasi_rak"
                       class="form-control"
                       value="{{ old('lokasi_rak') }}"
                       placeholder="Contoh: Rak A1">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Foto Barang
                </label>

                <input type="file"
                       name="foto"
                       class="form-control"
                       accept="image/*">
            </div>

            <div class="mb-4">
                <label class="form-label">
                    Keterangan
                </label>

                <textarea name="keterangan"
                          class="form-control"
                          rows="3">{{ old('keterangan') }}</textarea>
            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="/products"
               class="btn btn-secondary">
                Batal
            </a>

        </form>

    </div>

</div>

@endsection