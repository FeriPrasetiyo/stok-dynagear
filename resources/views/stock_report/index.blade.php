@extends('layouts.app')

@section('title', 'Laporan Stok')

@section('content')

<div class="container mt-4 mb-5">

    <h3 class="mb-3">Laporan Stok</h3>
    <div class="mb-3">
    <a href="/stock-report/export"
       class="btn btn-success">
        Export CSV
    </a>
    <a href="/stock-report/print"
   class="btn btn-danger">
    Print / PDF
</a>
<a href="/stock-report/pdf"
   class="btn btn-danger">
    PDF
</a>
</div>

    <div class="card shadow border-0">

        <div class="table-responsive">

            <table class="table table-bordered align-middle mb-0">

                <thead class="table-primary">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok Awal</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Stok Aktual</th>
                        <th>Minimum</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)

                        <tr>
                            <td>{{ $product->kode_barang }}</td>

                            <td>{{ $product->nama_barang }}</td>

                            <td>{{ $product->kategori ?? '-' }}</td>

                            <td>{{ $product->stok_awal }}</td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $product->stock_in }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-danger">
                                    {{ $product->stock_out }}
                                </span>
                            </td>

                            <td>
                                <strong>{{ $product->stock_actual }}</strong>
                            </td>

                            <td>{{ $product->stok_minimum }}</td>

                            <td>
                                @if($product->stock_actual <= $product->stok_minimum)
                                    <span class="badge bg-danger">
                                        Stok Minimum
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        Aman
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="text-center">
                                Belum ada data barang.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>

        </div>

    </div>

</div>
@endsection