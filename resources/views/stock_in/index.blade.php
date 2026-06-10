<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stok Masuk - Dynagear Stock</title>

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

        <a href="/stock-in/create"
           class="btn btn-light btn-sm">
            + Stok Masuk
        </a>

    </div>
</nav>

<div class="container mt-4">

    <h3 class="mb-3">
        Data Stok Masuk
    </h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0">

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="table-primary">

                    <tr>
                        <th>Tanggal</th>
                        <th>Gudang</th>
                        <th>Supplier</th>
                        <th>No Dokumen</th>
                        <th width="180">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($stockIns as $stock)

                        <tr>

                            <td>
                                {{ $stock->tanggal }}
                            </td>

                            <td>{{ $stock->warehouse->nama_gudang ?? '-' }}</td>

                            <td>
                                {{ $stock->supplier }}
                            </td>

                            <td>
                                {{ $stock->nomor_dokumen }}
                            </td>

                            <td>

                                <a href="/stock-in/{{ $stock->id }}"
                                   class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <form action="/stock-in/{{ $stock->id }}"
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
                            <td colspan="4"
                                class="text-center">
                                Belum ada data
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">
        {{ $stockIns->links() }}
    </div>

</div>

</body>
</html>