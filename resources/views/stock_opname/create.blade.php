@extends('layouts.app')

@section('title', 'Tambah Stock Opname')

@section('content')

<div class="container mt-4">

    <div class="card shadow">

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

                <div class="mb-3">

                    <label>Tanggal</label>

                    <input type="date"
                           name="tanggal"
                           value="{{ date('Y-m-d') }}"
                           class="form-control"
                           required>

                </div>

                <div class="mb-3">

                    <label>Barang</label>

                    <select name="product_id"
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

                <div class="mb-3">

                    <label>Stok Fisik</label>

                    <input type="number"
                           name="stok_fisik"
                           class="form-control"
                           min="0"
                           required>

                </div>

                <div class="mb-4">

                    <label>Keterangan</label>

                    <textarea name="keterangan"
                              rows="3"
                              class="form-control"></textarea>

                </div>

                <button class="btn btn-warning">
                    Simpan
                </button>

                <a href="/stock-opname"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>

    </div>

</div>

@endsection