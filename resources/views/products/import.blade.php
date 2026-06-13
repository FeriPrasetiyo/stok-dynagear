@extends('layouts.app')

@section('title', 'Import Barang')

@section('content')

<div class="card shadow border-0">
    <div class="card-header bg-success text-white">
        Import Barang CSV
    </div>

    <div class="card-body">

        <p>Format CSV:</p>

        <pre class="bg-light p-3 border rounded">kode_barang,nama_barang,category,satuan,stok_awal,stok_minimum,lokasi_rak,keterangan
BRG001,Bearing 6204,Sparepart,pcs,100,10,Rak A1,Keterangan barang</pre>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/products-import"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label">File CSV</label>
                <input type="file"
                       name="file"
                       class="form-control"
                       accept=".csv,.txt"
                       required>
            </div>

            <button class="btn btn-success">
                Import
            </button>

            <a href="/products" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection