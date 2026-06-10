<!DOCTYPE html>
<html lang="en">
<head>
    <title>Supplier - Dynagear Stock</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a href="/dashboard" class="navbar-brand">Dynagear Stock</a>

        <a href="/suppliers/create" class="btn btn-light btn-sm">
            + Tambah Supplier
        </a>
    </div>
</nav>

<div class="container mt-4 mb-5">

    <h3 class="mb-3">Data Supplier</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($suppliers as $supplier)

            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">
                        <h5 class="fw-bold text-primary">
                            {{ $supplier->nama_supplier }}
                        </h5>

                        <p class="mb-1">
                            <strong>Telepon:</strong> {{ $supplier->telepon ?? '-' }}
                        </p>

                        <p class="mb-1">
                            <strong>Email:</strong> {{ $supplier->email ?? '-' }}
                        </p>

                        <p class="mb-1">
                            <strong>Alamat:</strong> {{ $supplier->alamat ?? '-' }}
                        </p>

                        <p class="mb-0">
                            <strong>Keterangan:</strong> {{ $supplier->keterangan ?? '-' }}
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0">
                        <div class="d-grid gap-2">

                            <a href="/suppliers/{{ $supplier->id }}/edit"
                               class="btn btn-warning">
                                Edit
                            </a>

                            <form action="/suppliers/{{ $supplier->id }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus supplier ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger w-100">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada data supplier.
                </div>
            </div>

        @endforelse
    </div>

    <div class="mt-3">
        {{ $suppliers->links() }}
    </div>

</div>

</body>
</html>