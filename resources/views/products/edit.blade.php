@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')

<div class="card shadow border-0">

        <div class="card-header bg-warning">
            <h4 class="mb-0">
                Edit Barang
            </h4>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="/products/{{ $product->id }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">
                        Kode Barang
                    </label>

                    <input type="text"
                           name="kode_barang"
                           class="form-control"
                           value="{{ old('kode_barang', $product->kode_barang) }}"
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
                                {{ old('warehouse_id', $product->warehouse_id) == $warehouse->id ? 'selected' : '' }}>
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
                           value="{{ old('nama_barang', $product->nama_barang) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Kategori
                    </label>

                    <select name="kategori"
                            class="form-control">

                        <option value="">
                            Pilih Kategori
                        </option>

                        @foreach($categories as $category)
                            <option value="{{ $category->nama_kategori }}"
                                {{ old('kategori', $product->kategori) == $category->nama_kategori ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
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
                                {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
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
                                {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>

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
                           value="{{ old('stok_awal', $product->stok_awal) }}"
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
                           value="{{ old('stok_minimum', $product->stok_minimum) }}"
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
                           value="{{ old('lokasi_rak', $product->lokasi_rak) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Foto Barang
                    </label>

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
                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              class="form-control"
                              rows="3">{{ old('keterangan', $product->keterangan) }}</textarea>
                </div>

                <button class="btn btn-warning">
                    Update
                </button>

                <a href="/products"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>

@endsection