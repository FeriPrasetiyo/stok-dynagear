@extends('layouts.app')

@section('title', 'Import Barang')

@section('content')

<div class="container mt-4 mb-5">

    <div class="card shadow border-0">
        <div class="card-header bg-success text-white">
            Import Barang Excel / CSV
        </div>

        <div class="card-body">

            <p>Format Excel / CSV:</p>

            <pre class="bg-light p-3 border rounded">warehouse_id,brand_id,unit_id,category_id,kode_barang,nama_barang,stok_awal,stok_minimum
1,16,2,2,BRG001,Bearing 6204,100,10</pre>

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('products.import.preview') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label">File Excel / CSV</label>
                    <input type="file"
                           name="file"
                           class="form-control"
                           accept=".xlsx,.xls,.csv"
                           required>
                </div>

                <button class="btn btn-success">
                    Preview Data
                </button>

                <a href="{{ route('products.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

@endsection