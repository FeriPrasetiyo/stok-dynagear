@extends('layouts.app')

@section('title', 'Buat Purchase Order')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-success text-white">

        <h4 class="mb-0">
            Buat Purchase Order
        </h4>

    </div>

    <div class="card-body">

        <form action="/purchase-orders"
              method="POST">

            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label>Tanggal</label>

                    <input type="date"
                           name="tanggal"
                           value="{{ date('Y-m-d') }}"
                           class="form-control"
                           required>

                </div>

                <div class="col-md-4 mb-3">

                    <label>No PO</label>

                    <input type="text"
                           name="nomor_po"
                           class="form-control"
                           placeholder="PO-2026-0001"
                           required>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Supplier</label>

                    <select name="supplier_id"
                            class="form-control">

                        <option value="">
                            Pilih Supplier
                        </option>

                        @foreach($suppliers as $supplier)

                            <option value="{{ $supplier->id }}">
                                {{ $supplier->nama_supplier }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <hr>

            <h5>Detail Barang</h5>

            <div id="items">

                <div class="row mb-3 item-row">

                    <div class="col-md-6">

                        <select name="product_id[]"
                                class="form-control"
                                required>

                            <option value="">
                                Pilih Barang
                            </option>

                            @foreach($products as $product)

                                <option value="{{ $product->id }}">
                                    {{ $product->kode_barang }}
                                    -
                                    {{ $product->nama_barang }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

                        <input type="number"
                               name="qty[]"
                               class="form-control"
                               placeholder="Qty"
                               required>

                    </div>

                    <div class="col-md-3">

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

                <label>Keterangan</label>

                <textarea name="keterangan"
                          rows="3"
                          class="form-control"></textarea>

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

<script>

document.getElementById('addItem')
.addEventListener('click', function () {

    const row =
        document.querySelector('.item-row')
        .cloneNode(true);

    row.querySelector('select').value = '';
    row.querySelector('input').value = '';

    document
        .getElementById('items')
        .appendChild(row);
});

document.addEventListener('click', function(e){

    if(e.target.classList.contains('remove-item')){

        if(document.querySelectorAll('.item-row').length > 1){

            e.target.closest('.item-row').remove();

        }

    }

});

</script>

@endsection