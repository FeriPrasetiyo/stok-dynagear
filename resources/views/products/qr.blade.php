<!DOCTYPE html>
<html>
<head>
    <title>QR Barang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media print {
            .no-print {
                display:none;
            }
        }
    </style>
</head>
<body>

<div class="container text-center mt-5">

    <h3>{{ $product->nama_barang }}</h3>

    <p>{{ $product->kode_barang }}</p>

    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(url('/products/'.$product->id)) }}">

    <div class="mt-4 no-print">

        <button onclick="window.print()"
                class="btn btn-primary">
            Print QR
        </button>

        <a href="/products/{{ $product->id }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </div>

</div>

</body>
</html>