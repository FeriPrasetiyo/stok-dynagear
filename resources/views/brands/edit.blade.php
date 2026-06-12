@extends('layouts.app')

@section('title', 'Edit Merek')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-warning">
        Edit Merek
    </div>

    <div class="card-body">

        <form action="/brands/{{ $brand->id }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">
                    Nama Merek
                </label>

                <input type="text"
                       name="nama_merek"
                       class="form-control"
                       value="{{ $brand->nama_merek }}"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Keterangan
                </label>

                <textarea name="keterangan"
                          class="form-control"
                          rows="3">{{ $brand->keterangan }}</textarea>

            </div>

            <button class="btn btn-warning">
                Update
            </button>

            <a href="/brands"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection