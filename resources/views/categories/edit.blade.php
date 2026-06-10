<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Kategori - Dynagear Stock</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a href="/categories" class="navbar-brand">Dynagear Stock</a>

        <a href="/categories" class="btn btn-light btn-sm">
            Kembali
        </a>
    </div>
</nav>

<div class="container mt-4 mb-5">

    <div class="card shadow border-0">
        <div class="card-header bg-warning">
            <h4 class="mb-0">Edit Kategori</h4>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="/categories/{{ $category->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text"
                           name="nama_kategori"
                           class="form-control"
                           value="{{ old('nama_kategori', $category->nama_kategori) }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="3">{{ old('keterangan', $category->keterangan) }}</textarea>
                </div>

                <button class="btn btn-warning">
                    Update
                </button>

                <a href="/categories" class="btn btn-secondary">
                    Batal
                </a>
            </form>

        </div>
    </div>

</div>

</body>
</html>