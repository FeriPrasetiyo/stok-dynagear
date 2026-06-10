<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok PDF</title>
    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-size: 12px;
        }

        .logo {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
            }
        }
    </style>
</head>
<body>

<div class="container mt-4">

    <div class="no-print mb-3">
        <button onclick="window.print()" class="btn btn-danger">
            Print / Save PDF
        </button>

        <a href="/stock-report" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="d-flex align-items-center border-bottom pb-3 mb-3">

        <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
             class="logo me-3">

        <div>
            <h4 class="fw-bold mb-1">PT Dynagear</h4>
            <h5 class="mb-1">Laporan Stok Barang</h5>
            <small>Tanggal Cetak: {{ date('d-m-Y H:i') }}</small>
        </div>

    </div>

    <table class="table table-bordered table-sm">
        <thead class="table-light">
            <tr>
                <th>No</th>
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
            @foreach($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
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

    <div class="mt-5 d-flex justify-content-end">
        <div class="text-center">
            <p class="mb-5">Mengetahui,</p>
            <strong>_____________________</strong>
        </div>
    </div>

</div>

</body>
</html>