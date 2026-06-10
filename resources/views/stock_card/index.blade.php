<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kartu Stok - Dynagear Stock</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a href="/dashboard" class="navbar-brand">Dynagear Stock</a>

        <a href="/dashboard" class="btn btn-light btn-sm">
            Kembali
        </a>
    </div>
</nav>

<div class="container mt-4 mb-5">

    <h3 class="mb-3">Kartu Stok</h3>

    <div class="card shadow border-0 mb-4">
        <div class="card-body">

            <form method="GET">
                <label class="form-label">Pilih Barang</label>

                <select name="product_id"
                        class="form-control"
                        onchange="this.form.submit()">

                    <option value="">-- Pilih Barang --</option>

                    @foreach($products as $item)
                        <option value="{{ $item->id }}"
                            {{ request('product_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->kode_barang }} - {{ $item->nama_barang }}
                        </option>
                    @endforeach

                </select>
            </form>

        </div>
    </div>

    @if($product)

        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white">
                <strong>{{ $product->nama_barang }}</strong>
            </div>

            <div class="card-body">

                <p class="mb-1">
                    <strong>Kode:</strong> {{ $product->kode_barang }}
                </p>

                <p class="mb-1">
                    <strong>Kategori:</strong> {{ $product->kategori ?? '-' }}
                </p>

                <p class="mb-3">
                    <strong>Saldo Akhir:</strong>
                    <span class="badge bg-success">{{ $saldo }}</span>
                </p>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($mutations as $row)
                                <tr>
                                    <td>
                                        {{ date('d-m-Y H:i', strtotime($row['tanggal'])) }}
                                    </td>

                                    <td>
                                        @if($row['jenis'] == 'STOK MASUK')
                                            <span class="badge bg-success">STOK MASUK</span>
                                        @elseif($row['jenis'] == 'STOK KELUAR')
                                            <span class="badge bg-danger">STOK KELUAR</span>
                                        @else
                                            <span class="badge bg-secondary">STOK AWAL</span>
                                        @endif
                                    </td>

                                    <td>{{ $row['masuk'] }}</td>
                                    <td>{{ $row['keluar'] }}</td>
                                    <td>
                                        <strong>{{ $row['saldo'] }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>