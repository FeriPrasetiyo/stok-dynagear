@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')

<div class="container mt-4 mb-5">

    <h3 class="mb-3">Kategori Barang</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->nama_kategori }}</td>
                            <td>{{ $category->keterangan ?? '-' }}</td>
                            <td>
                                <a href="/categories/{{ $category->id }}/edit"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="/categories/{{ $category->id }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini?')">
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
                            <td colspan="3" class="text-center">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>

</div>
@endsection