@extends('layouts.app')

@section('title', 'Buat Request Barang')

@section('content')

<div class="card shadow border-0">
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">Buat Request Barang</h4>
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/item-requests" method="POST">
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
                    <label class="form-label">No Request</label>
                    <input type="text"
                           name="nomor_request"
                           class="form-control"
                           value="{{ old('nomor_request', 'REQ-'.date('Ymd-His')) }}"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tujuan</label>
                    <input type="text"
                           name="tujuan"
                           class="form-control"
                           value="{{ old('tujuan') }}"
                           placeholder="Contoh: Produksi / Assembling">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan"
                          class="form-control"
                          rows="3">{{ old('keterangan') }}</textarea>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Detail Barang</h5>

            <div id="items">
                <div class="row mb-3 item-row">
                    <div class="col-md-7 mb-2">
                        <select name="product_id[]"
                                class="form-control"
                                required>
                            <option value="">Pilih Barang</option>

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
                                class="btn btn-danger w-100 remove-item">
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

            <div class="mt-3">
                <button class="btn btn-success">
                    Simpan Request
                </button>

                <a href="/item-requests" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>

    </div>
</div>

<script>
    document.getElementById('addItem').addEventListener('click', function () {
        const row = document.querySelector('.item-row').cloneNode(true);

        row.querySelector('select').value = '';
        row.querySelector('input').value = '';

        document.getElementById('items').appendChild(row);
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