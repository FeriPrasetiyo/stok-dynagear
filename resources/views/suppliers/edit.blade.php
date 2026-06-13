@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')

<div class="container mt-4 mb-5">

    <div class="card shadow border-0">

        <div class="card-header bg-warning">
            <h4 class="mb-0">Edit Supplier</h4>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="/suppliers/{{ $supplier->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Supplier</label>
                    <input type="text"
                           name="nama_supplier"
                           class="form-control"
                           value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text"
                           name="telepon"
                           class="form-control"
                           value="{{ old('telepon', $supplier->telepon) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $supplier->email) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              rows="3">{{ old('alamat', $supplier->alamat) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="3">{{ old('keterangan', $supplier->keterangan) }}</textarea>
                </div>

                <button class="btn btn-warning">
                    Update
                </button>

                <a href="/suppliers" class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>

</div>

@endsection