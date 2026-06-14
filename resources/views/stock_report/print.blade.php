<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            font-size:12px;
        }

        .logo{
            width:70px;
            height:70px;
            object-fit:contain;
        }

        .header{
            border-bottom:2px solid #000;
            padding-bottom:10px;
            margin-bottom:20px;
        }

        .table th{
            background:#e9ecef;
        }

        @media print{

            .no-print{
                display:none;
            }

            body{
                margin:0;
            }

        }

    </style>
</head>
<body>

<div class="container mt-3">

    <div class="no-print mb-3">

        <button onclick="window.print()"
                class="btn btn-danger">
            Print / Save PDF
        </button>

        <a href="/stock-report"
           class="btn btn-secondary">
            Kembali
        </a>

    </div>

    <div class="header">

        <div class="row align-items-center">

            <div class="col-2">

                <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                     class="logo">

            </div>

            <div class="col-10 text-center">

                <h3 class="fw-bold mb-1">
                    PT DYNAGEAR
                </h3>

                <h5 class="mb-1">
                    LAPORAN STOK BARANG
                </h5>

                <small>
                    Dicetak :
                    {{ date('d-m-Y H:i:s') }}
                </small>

            </div>

        </div>

    </div>

    <div class="row mb-3">

        <div class="col-md-4">

            <table class="table table-bordered table-sm">

                <tr>
                    <th width="40%">Total Barang</th>
                    <td>{{ count($products) }}</td>
                </tr>

                <tr>
                    <th>Tanggal Cetak</th>
                    <td>{{ date('d-m-Y') }}</td>
                </tr>

            </table>

        </div>

    </div>

    <table class="table table-bordered table-sm">

        <thead>

            <tr class="text-center">

                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Category</th>
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

                <td>
                    {{ $product->kode_barang }}
                </td>

                <td>
                    {{ $product->nama_barang }}
                </td>

                <td>
                    {{ $product->category->nama_category ?? '-' }}
                </td>

                <td class="text-end">
                    {{ $product->stok_awal }}
                </td>

                <td class="text-end">
                    {{ $product->stock_in }}
                </td>

                <td class="text-end">
                    {{ $product->stock_out }}
                </td>

                <td class="text-end fw-bold">
                    {{ $product->stock_actual }}
                </td>

                <td class="text-end">
                    {{ $product->stok_minimum }}
                </td>

                <td>

                    @if($product->stock_actual <= $product->stok_minimum)

                        <span class="badge bg-danger">
                            Minimum
                        </span>

                    @else

                        <span class="badge bg-success">
                            Aman
                        </span>

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    <div class="row mt-5">

        <div class="col-6 text-center">

            Mengetahui,

            <br><br><br><br>

            ___________________

            <br>

            Manager

        </div>

        <div class="col-6 text-center">

            Dibuat Oleh,

            <br><br><br><br>

            ___________________

            <br>

            Admin Gudang

        </div>

    </div>

</div>

</body>
</html>