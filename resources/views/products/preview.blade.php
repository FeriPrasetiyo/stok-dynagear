@extends('layouts.app')

@section('title', 'Preview Import Produk')

@section('content')
<div class="container mt-4">

    <div class="card shadow border-0">
        <div class="card-header">
            <h4 class="mb-0">Preview Data Import</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Warehouse ID</th>
                            <th>Brand ID</th>
                            <th>Unit ID</th>
                            <th>Category ID</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok Awal</th>
                            <th>Stok Minimum</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach(array_slice($rows, 1) as $row)
                            <tr>
                                <td>{{ $row[0] ?? '' }}</td>
                                <td>{{ $row[1] ?? '' }}</td>
                                <td>{{ $row[2] ?? '' }}</td>
                                <td>{{ $row[3] ?? '' }}</td>
                                <td>{{ $row[4] ?? '' }}</td>
                                <td>{{ $row[5] ?? '' }}</td>
                                <td>{{ $row[6] ?? 0 }}</td>
                                <td>{{ $row[7] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <form action="{{ route('products.import.store') }}"
                  method="POST">
                @csrf

                <button class="btn btn-success">
                    Simpan ke Products
                </button>

                <a href="{{ route('products.import.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </form>

        </div>
    </div>

</div>
@endsection