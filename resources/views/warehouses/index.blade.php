@extends('layouts.app')

@section('title', 'Data Gudang')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Data Gudang
        </h3>

        <p class="text-muted mb-0">
            Master Gudang Penyimpanan
        </p>
    </div>

    <a href="/warehouses/create"
       class="btn btn-success">
        + Tambah Gudang
    </a>

</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow border-0">

    <div class="table-responsive">

        <table class="table table-bordered align-middle mb-0">

            <thead class="table-primary">

                <tr>
                    <th>Nama Gudang</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th width="180">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($warehouses as $warehouse)

                    <tr>

                        <td>
                            {{ $warehouse->nama_gudang }}
                        </td>

                        <td>
                            {{ $warehouse->lokasi ?? '-' }}
                        </td>

                        <td>
                            {{ $warehouse->keterangan ?? '-' }}
                        </td>

                        <td>

                            <a href="/warehouses/{{ $warehouse->id }}/edit"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="/warehouses/{{ $warehouse->id }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus gudang ini?')">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4"
                            class="text-center">

                            Belum ada data gudang

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3">
    {{ $warehouses->links() }}
</div>

@endsection