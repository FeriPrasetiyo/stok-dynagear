@extends('layouts.app')

@section('title', 'Tambah Stock Opname')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet">

<div class="container mt-4">

    <div class="card shadow border-0">

        <div class="card-header bg-warning">

            <h4 class="mb-0">
                Tambah Stock Opname
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

            <form action="/stock-opname"
                  method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Tanggal
                        </label>

                        <input type="date"
                               name="tanggal"
                               value="{{ date('Y-m-d') }}"
                               class="form-control"
                               required>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Cari Barang
                    </label>

                    <select name="product_id"
                            id="product_id"
                            class="form-control"
                            required>

                        <option value="">
                            Cari kode atau nama barang...
                        </option>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}">

                                {{ $product->kode_barang }}
                                -
                                {{ $product->nama_barang }}

                                @if($product->unit)
                                    ({{ $product->unit->nama_satuan }})
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Stok Fisik
                    </label>

                    <input type="number"
                           name="stok_fisik"
                           class="form-control"
                           min="0"
                           placeholder="Masukkan stok hasil perhitungan fisik"
                           required>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
                              rows="3"
                              class="form-control"
                              placeholder="Catatan stock opname (opsional)"></textarea>

                </div>

                <hr>

                <button class="btn btn-warning">

                    Simpan Stock Opname

                </button>

                <a href="/stock-opname"
                   class="btn btn-secondary">

                    Batal

                </a>

            </form>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function(){

    $('#product_id').select2({

        placeholder: 'Cari kode atau nama barang...',

        allowClear: true,

        width: '100%'

    });

});

</script>

@endsections