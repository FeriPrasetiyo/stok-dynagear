@extends('layouts.app')

@section('title', 'Tambah Gudang')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-success text-white">

        <h4 class="mb-0">
            Tambah Gudang
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

        <form action="/warehouses"
              method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Nama Gudang
                </label>

                <input type="text"
                       name="nama_gudang"
                       class="form-control"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Lokasi
                </label>

                <input type="text"
                       name="lokasi"
                       class="form-control">

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Keterangan
                </label>

                <textarea name="keterangan"
                          rows="3"
                          class="form-control"></textarea>

            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="/warehouses"
               class="btn btn-secondary">
                Batal
            </a>

        </form>

    </div>

</div>

@endsection