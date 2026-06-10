@extends('layouts.app')

@section('title', 'Edit Gudang')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-warning">

        <h4 class="mb-0">
            Edit Gudang
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

        <form action="/warehouses/{{ $warehouse->id }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">
                    Nama Gudang
                </label>

                <input type="text"
                       name="nama_gudang"
                       class="form-control"
                       value="{{ $warehouse->nama_gudang }}"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Lokasi
                </label>

                <input type="text"
                       name="lokasi"
                       class="form-control"
                       value="{{ $warehouse->lokasi }}">

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Keterangan
                </label>

                <textarea name="keterangan"
                          rows="3"
                          class="form-control">{{ $warehouse->keterangan }}</textarea>

            </div>

            <button class="btn btn-warning">
                Update
            </button>

            <a href="/warehouses"
               class="btn btn-secondary">
                Batal
            </a>

        </form>

    </div>

</div>

@endsection