@extends('layouts.app')

@section('title', 'Kategori Barang')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="fw-bold mb-1">
            Kategori Barang
        </h3>

        <p class="text-muted mb-0">
            Data kategori master barang
        </p>
    </div>

    <a href="/categories/create"
       class="btn btn-success">
        + Tambah Kategori
    </a>

</div>

<div class="card shadow border-0">

    <div class="table-responsive">

        <table class="table table-bordered align-middle mb-0">

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
                        <td colspan="3"
                            class="text-center py-4">
                            Belum ada kategori.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3">
    {{ $categories->withQueryString()->links() }}
</div>

@endsection