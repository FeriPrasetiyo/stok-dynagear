<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stock Opname - Dynagear Stock</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">

        <a href="/dashboard"
           class="navbar-brand">
            Dynagear Stock
        </a>

        <a href="/stock-opname/create"
           class="btn btn-light btn-sm">
            + Stock Opname
        </a>

    </div>
</nav>

<div class="container mt-4 mb-5">

    <h3 class="mb-3">
        Data Stock Opname
    </h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0">

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="table-warning">

                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Stok Sistem</th>
                        <th>Stok Fisik</th>
                        <th>Selisih</th>
                        <th>Keterangan</th>
                        <th width="120">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($opnames as $opname)

                        <tr>

                            <td>
                                {{ $opname->tanggal }}
                            </td>

                            <td>
                                {{ $opname->product->nama_barang }}
                            </td>

                            <td>
                                {{ $opname->stok_sistem }}
                            </td>

                            <td>
                                {{ $opname->stok_fisik }}
                            </td>

                            <td>

                                @if($opname->selisih == 0)

                                    <span class="badge bg-success">
                                        0
                                    </span>

                                @elseif($opname->selisih > 0)

                                    <span class="badge bg-primary">
                                        +{{ $opname->selisih }}
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        {{ $opname->selisih }}
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $opname->keterangan }}
                            </td>

                            <td>

                                <form action="/stock-opname/{{ $opname->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center">

                                Belum ada data stock opname

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">
        {{ $opnames->links() }}
    </div>

</div>

</body>
</html>