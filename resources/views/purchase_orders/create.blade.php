@extends('layouts.app')

@section('title', 'Buat Purchase Order')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<div class="card shadow border-0">

    <div class="card-header bg-success text-white">
        <h4 class="mb-0">
            Buat Purchase Order
        </h4>
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi Kesalahan:</strong>

                <hr>

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/purchase-orders" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal</label>

                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal', date('Y-m-d')) }}"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">No PO</label>

                    <input type="text"
                           name="nomor_po"
                           class="form-control"
                           value="{{ old('nomor_po') }}"
                           placeholder="PO-2026-0001"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Supplier</label>

                    <select name="supplier_id"
                            id="supplier_id"
                            class="form-control supplier-select"
                            required>

                        <option value="">
                            Pilih Supplier
                        </option>

                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama_supplier }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

            <hr>

            <h5 class="fw-bold mb-3">
                Detail Barang
            </h5>

            <div id="items">

                <div class="row mb-3 item-row">

                    <div class="col-md-6">
                        <label class="form-label">Barang</label>

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

                    <div class="col-md-3">
                        <label class="form-label">Qty</label>

                        <input type="number"
                               name="qty[]"
                               class="form-control"
                               placeholder="Qty"
                               min="1"
                               required>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button"
                                class="btn btn-danger remove-item">
                            Hapus
                        </button>
                    </div>

                </div>

            </div>

            <button type="button"
                    id="addItem"
                    class="btn btn-secondary mb-3">
                + Tambah Barang
            </button>

            <div class="mb-4">
                <label class="form-label">Keterangan</label>

                <textarea name="keterangan"
                          rows="3"
                          class="form-control">{{ old('keterangan') }}</textarea>
            </div>

            <button class="btn btn-success">
                Simpan PO
            </button>

            <a href="/purchase-orders"
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
            <div class="row mb-3 item-row">

                <div class="col-md-6">
                    <label class="form-label">Barang</label>

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

                <div class="col-md-3">
                    <label class="form-label">Qty</label>

                    <input type="number"
                           name="qty[]"
                           class="form-control"
                           placeholder="Qty"
                           min="1"
                           required>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="button"
                            class="btn btn-danger remove-item">
                        Hapus
                    </button>
                </div>

            </div>
        `;

        document.getElementById('items')
            .insertAdjacentHTML('beforeend', html);

        initSelect2();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            if (document.querySelectorAll('.item-row').length > 1) {
                e.target.closest('.item-row').remove();
            }
        }
    });
</script>

@endsection