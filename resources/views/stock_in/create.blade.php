@extends('layouts.app')

@section('title', 'Tambah Stok Masuk')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<div class="card shadow border-0">

    <div class="card-header bg-success text-white">
        <h4 class="mb-0">
            Tambah Stok Masuk
        </h4>
    </div>

    <div class="card-body">

        <form action="/stock-in" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       value="{{ old('tanggal', date('Y-m-d')) }}"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Gudang
                </label>

                <select name="warehouse_id"
                        class="form-control"
                        required>

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
                    Supplier
                </label>

                <select name="supplier"
                        class="form-control supplier-select"
                        required>

                    <option value="">
                        Pilih Supplier
                    </option>

                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->nama_supplier }}"
                            {{ old('supplier') == $supplier->nama_supplier ? 'selected' : '' }}>
                            {{ $supplier->nama_supplier }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Nomor Dokumen
                </label>

                <input type="text"
                       name="nomor_dokumen"
                       class="form-control"
                       value="{{ old('nomor_dokumen') }}"
                       placeholder="Contoh: SJ-001">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Keterangan
                </label>

                <textarea name="keterangan"
                          class="form-control"
                          rows="3">{{ old('keterangan') }}</textarea>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">
                Barang
            </h5>

            <div id="items">

                <div class="row mb-2 item-row">

                    <div class="col-md-7 mb-2">
                        <select name="product_id[]"
                                class="form-control product-select"
                                required>

                            <option value="">
                                Cari / Pilih Barang
                            </option>

                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->kode_barang }} - {{ $product->nama_barang }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <input type="number"
                               name="qty[]"
                               class="form-control"
                               placeholder="Qty"
                               min="1"
                               required>
                    </div>

                    <div class="col-md-2 mb-2">
                        <button type="button"
                                class="btn btn-danger w-100 remove">
                            X
                        </button>
                    </div>

                </div>

            </div>

            <button type="button"
                    id="addItem"
                    class="btn btn-secondary btn-sm">
                + Tambah Barang
            </button>

            <hr>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="/stock-in"
               class="btn btn-secondary">
                Batal
            </a>

        </form>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function initSelect2() {
        $('.product-select').select2({
            placeholder: 'Cari barang...',
            width: '100%'
        });

        $('.supplier-select').select2({
            placeholder: 'Cari supplier...',
            width: '100%'
        });
    }

    initSelect2();

    document.getElementById('addItem').addEventListener('click', function () {

        let html = `
            <div class="row mb-2 item-row">

                <div class="col-md-7 mb-2">
                    <select name="product_id[]"
                            class="form-control product-select"
                            required>

                        <option value="">
                            Cari / Pilih Barang
                        </option>

                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->kode_barang }} - {{ $product->nama_barang }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <input type="number"
                           name="qty[]"
                           class="form-control"
                           placeholder="Qty"
                           min="1"
                           required>
                </div>

                <div class="col-md-2 mb-2">
                    <button type="button"
                            class="btn btn-danger w-100 remove">
                        X
                    </button>
                </div>

            </div>
        `;

        document.getElementById('items')
            .insertAdjacentHTML('beforeend', html);

        initSelect2();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove')) {
            if (document.querySelectorAll('.item-row').length > 1) {
                e.target.closest('.item-row').remove();
            }
        }
    });
</script>

@endsection