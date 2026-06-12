@extends('layouts.app')

@section('title', 'Edit Satuan')

@section('content')

<div class="card shadow border-0">
    <div class="card-header bg-warning">
        Edit Satuan
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/units/{{ $unit->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Satuan</label>
                <input type="text"
                       name="nama_satuan"
                       class="form-control"
                       value="{{ old('nama_satuan', $unit->nama_satuan) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kode</label>
                <input type="text"
                       name="kode"
                       class="form-control"
                       value="{{ old('kode', $unit->kode) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan"
                          class="form-control"
                          rows="3">{{ old('keterangan', $unit->keterangan) }}</textarea>
            </div>

            <button class="btn btn-warning">
                Update
            </button>

            <a href="/units" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>

@endsection