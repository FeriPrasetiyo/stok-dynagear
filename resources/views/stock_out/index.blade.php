<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stok Keluar - Dynagear Stock</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">

        <a href="/dashboard" class="navbar-brand">
            Dynagear Stock
        </a>

        <a href="/stock-out/create"
           class="btn btn-light btn-sm">
            + Stok Keluar
        </a>

    </div>
</nav>

<div class="container mt-4">

    <h3 class="mb-3">
        Data Stok Keluar
    </h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow border-0">

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="table-danger">

                    <tr>
                        <th>Tanggal</th>
                        <th>Gudang</th>
                        <th>Tujuan</th>
                        <th>Nomor SO</th>
                        <th width="180">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($stockOuts as $stock)

                        <tr>

                            <td>{{ $stock->tanggal }}</td>

                            <td>{{ $stock->warehouse->nama_gudang ?? '-' }}</td>

                            <td>{{ $stock->tujuan }}</td>

                            <td>{{ $stock->nomor_so }}</td>

                            <td>

                                <a href="/stock-out/{{ $stock->id }}"
                                   class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <form action="/stock-out/{{ $stock->id }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus data?')">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center">
                                Belum ada data
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">
        {{ $stockOuts->links() }}
    </div>

</div>

</body>
</html>