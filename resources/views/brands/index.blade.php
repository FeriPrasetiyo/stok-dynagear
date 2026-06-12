@extends('layouts.app')

@section('title', 'Data Merek')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-primary text-white d-flex justify-content-between">

        <span>Data Merek</span>

        <a href="/brands/create"
           class="btn btn-light btn-sm">
            + Tambah Merek
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
                        <th>Nama Merek</th>
                        <th>Keterangan</th>
                        <th width="180">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($brands as $brand)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $brand->nama_merek }}
                            </td>

                            <td>
                                {{ $brand->keterangan }}
                            </td>

                            <td>

                                <a href="/brands/{{ $brand->id }}/edit"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="/brands/{{ $brand->id }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus merek?')">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center">
                                Belum ada data merek
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">
    {{ $brands->links() }}
</div>

    </div>

</div>

@endsection