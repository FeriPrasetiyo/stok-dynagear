@extends('layouts.app')

@section('title', 'Data Supplier')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="fw-bold mb-1">
            Data Supplier
        </h3>

        <p class="text-muted mb-0">
            Master data supplier barang
        </p>
    </div>

    <a href="/suppliers/create"
       class="btn btn-success">
        + Supplier
    </a>

</div>

<div class="card shadow border-0 mb-3">

    <div class="card-body">

        <form method="GET">

            <div class="input-group">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Cari nama supplier, telepon, email...">

                <button class="btn btn-primary">
                    Cari
                </button>

                <a href="/suppliers"
                   class="btn btn-secondary">
                    Reset
                </a>

            </div>

        </form>

    </div>

</div>

<div class="row">

    @forelse($suppliers as $supplier)

        <div class="col-12 col-md-6 col-lg-4 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <h5 class="fw-bold text-primary">
                        {{ $supplier->nama_supplier }}
                    </h5>

                    <hr>

                    <p class="mb-2">
                        <strong>Telepon :</strong>
                        {{ $supplier->telepon ?? '-' }}
                    </p>

                    <p class="mb-2">
                        <strong>Email :</strong>
                        {{ $supplier->email ?? '-' }}
                    </p>

                    <p class="mb-2">
                        <strong>Alamat :</strong>
                        {{ $supplier->alamat ?? '-' }}
                    </p>

                    <p class="mb-0">
                        <strong>Keterangan :</strong>
                        {{ $supplier->keterangan ?? '-' }}
                    </p>

                </div>

                <div class="card-footer bg-white border-0">

                    <div class="d-grid gap-2">

                        <a href="/suppliers/{{ $supplier->id }}/edit"
                           class="btn btn-warning">
                            Edit
                        </a>

                        <form action="/suppliers/{{ $supplier->id }}"
                              method="POST"
                              onsubmit="return confirm('Hapus supplier ini?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger w-100">
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="alert alert-info text-center">

                Belum ada data supplier.

            </div>

        </div>

    @endforelse

</div>

<div class="mt-3">

    {{ $suppliers->withQueryString()->links() }}

</div>

@endsection