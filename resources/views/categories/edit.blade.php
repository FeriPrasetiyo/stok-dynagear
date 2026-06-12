@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="mb-3">

    <h3 class="fw-bold">
        Edit Kategori
    </h3>

    <p class="text-muted mb-0">
        Ubah data kategori barang
    </p>

</div>

<div class="card shadow border-0">

    <div class="card-header bg-warning">

        <h4 class="mb-0">
            Edit Kategori
        </h4>

    </div>

    <div class="card-body">

        @if($errors->any())

            <div class="alert alert-danger">

                @foreach($errors->all() as $error)

                    <div>{{ $error }}</div>

                @endforeach

            </div>

        @endif

        <form action="/categories/{{ $category->id }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">
                    Nama Kategori
                </label>

                <input type="text"
                       name="nama_kategori"
                       class="form-control"
                       value="{{ old('nama_kategori', $category->nama_kategori) }}"
                       required>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Keterangan
                </label>

                <textarea name="keterangan"
                          class="form-control"
                          rows="3">{{ old('keterangan', $category->keterangan) }}</textarea>

            </div>

            <button class="btn btn-warning">
                Update
            </button>

            <a href="/categories"
               class="btn btn-secondary">
                Batal
            </a>

        </form>

    </div>

</div>

@endsection