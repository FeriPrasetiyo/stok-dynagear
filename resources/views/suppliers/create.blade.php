@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')

<div class="container mt-4 mb-5">

    <div class="card shadow border-0">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Supplier</h4>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="/suppliers" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Supplier</label>
                    <input type="text"
                           name="nama_supplier"
                           class="form-control"
                           value="{{ old('nama_supplier') }}"
                           placeholder="Contoh: PT Sumber Sparepart"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text"
                           name="telepon"
                           class="form-control"
                           value="{{ old('telepon') }}"
                           placeholder="Contoh: 021xxxx">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email') }}"
                           placeholder="supplier@email.com">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              rows="3">{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan"
                              class="form-control"
                              rows="3">{{ old('keterangan') }}</textarea>
                </div>

                <button class="btn btn-success">
                    Simpan
                </button>

                <a href="/suppliers" class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>

</div>
@endsection