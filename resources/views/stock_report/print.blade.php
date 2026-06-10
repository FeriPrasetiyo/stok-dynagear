<!DOCTYPE html>
<html>
<head>
    <title>Print Laporan Stok</title>
    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <div class="text-center mb-4">
        <h4 class="fw-bold">Laporan Stok Barang</h4>
        <p class="mb-0">Dynagear Stock Management</p>
        <small>Tanggal Cetak: {{ date('d-m-Y H:i') }}</small>
    </div>

    <div class="no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary">
            Print / Save PDF
        </button>

        <a href="/stock-report" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <table class="table table-bordered table-sm">
        <thead>
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
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->kode_barang }}</td>
                    <td>{{ $product->nama_barang }}</td>
                    <td>{{ $product->kategori ?? '-' }}</td>
                    <td>{{ $product->stok_awal }}</td>
                    <td>{{ $product->stock_in }}</td>
                    <td>{{ $product->stock_out }}</td>
                    <td>{{ $product->stock_actual }}</td>
                    <td>{{ $product->stok_minimum }}</td>
                    <td>
                        @if($product->stock_actual <= $product->stok_minimum)
                            Stok Minimum
                        @else
                            Aman
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>