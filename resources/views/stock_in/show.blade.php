<!DOCTYPE html>
<html lang="en">
<head>
    <title>Detail Stok Masuk</title>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            Detail Stok Masuk

        </div>

        <div class="card-body">

            <p>
                <strong>Tanggal :</strong>
                {{ $stockIn->tanggal }}
            </p>

            <p>
    <strong>Gudang :</strong>
    {{ $stockIn->warehouse->nama_gudang ?? '-' }}
</p>

            <p>
                <strong>Supplier :</strong>
                {{ $stockIn->supplier }}
            </p>

            <p>
                <strong>No Dokumen :</strong>
                {{ $stockIn->nomor_dokumen }}
            </p>

            <p>
                <strong>Keterangan :</strong>
                {{ $stockIn->keterangan }}
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

                    @foreach($stockIn->details as $detail)

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

            <a href="/stock-in"
               class="btn btn-secondary">
                Kembali
            </a>

        </div>

    </div>

</div>

</body>
</html>