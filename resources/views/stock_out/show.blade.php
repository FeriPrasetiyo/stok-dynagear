<!DOCTYPE html>
<html lang="en">
<head>
    <title>Detail Stok Keluar</title>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-danger text-white">

            Detail Stok Keluar

        </div>

        <div class="card-body">

            <p>
                <strong>Tanggal :</strong>
                {{ $stockOut->tanggal }}
            </p>

            <p>
    <strong>Gudang :</strong>
    {{ $stockOut->warehouse->nama_gudang ?? '-' }}
</p>

            <p>
                <strong>Tujuan :</strong>
                {{ $stockOut->tujuan }}
            </p>

            <p>
                <strong>Nomor SO :</strong>
                {{ $stockOut->nomor_so }}
            </p>

            <p>
                <strong>Keterangan :</strong>
                {{ $stockOut->keterangan }}
            </p>

            <hr>

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>Barang</th>
                        <th>Qty</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($stockOut->details as $detail)

                    <tr>

                        <td>
                            {{ $detail->product->nama_barang }}
                        </td>

                        <td>
                            {{ $detail->qty }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <a href="/stock-out"
               class="btn btn-secondary">
                Kembali
            </a>

        </div>

    </div>

</div>

</body>
</html>