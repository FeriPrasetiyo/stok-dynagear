@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')

<div class="card shadow border-0">
    <div class="card-header bg-success text-white">
        Tambah Satuan
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/units" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Satuan</label>
                <input type="text"
                       name="nama_satuan"
                       class="form-control"
                       value="{{ old('nama_satuan') }}"
                       placeholder="Contoh: Pieces"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kode</label>
                <input type="text"
                       name="kode"
                       class="form-control"
                       value="{{ old('kode') }}"
                       placeholder="Contoh: PCS">
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan"
                          class="form-control"
                          rows="3">{{ old('keterangan') }}</textarea>
            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="/units" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection