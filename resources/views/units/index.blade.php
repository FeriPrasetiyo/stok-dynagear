@extends('layouts.app')

@section('title', 'Data Satuan')

@section('content')

<div class="card shadow border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <span>Data Satuan</span>

        <a href="/units/create" class="btn btn-light btn-sm">
            + Tambah Satuan
        </a>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Satuan</th>
                        <th>Kode</th>
                        <th>Keterangan</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($units as $unit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $unit->nama_satuan }}</td>
                            <td>{{ $unit->kode ?? '-' }}</td>
                            <td>{{ $unit->keterangan ?? '-' }}</td>
                            <td>
                                <a href="/units/{{ $unit->id }}/edit"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="/units/{{ $unit->id }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus satuan ini?')">
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
                            <td colspan="5" class="text-center">
                                Belum ada data satuan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $units->links() }}

    </div>
</div>

@endsection