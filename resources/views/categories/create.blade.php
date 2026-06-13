@extends('layouts.app')

@section('title', 'Tambah category')

@section('content')

<div class="card shadow border-0">
    
<div class="card-header bg-success text-white">
    <h4 class="mb-0">
        Tambah category
    </h4>
</div>

<div class="card-body">

    <form action="/categories" method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Nama category
            </label>

            <input type="text"
                   name="nama_category"
                   class="form-control"
                   value="{{ old('nama_category') }}"
                   placeholder="Contoh: Sparepart"
                   required>

        </div>

        <div class="mb-4">

            <label class="form-label">
                Keterangan
            </label>

            <textarea name="keterangan"
                      class="form-control"
                      rows="3">{{ old('keterangan') }}</textarea>

        </div>

        <button class="btn btn-success">
            Simpan
        </button>

        <a href="/categories"
           class="btn btn-secondary">
            Batal
        </a>

    </form>

</div>

</div>

@endsection
