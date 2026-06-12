@extends('layouts.app')

@section('title', 'Stok Masuk')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Data Stok Masuk
        </h3>

        <p class="text-muted mb-0">
            Daftar transaksi barang masuk
        </p>
    </div>

    <a href="/stock-in/create"
       class="btn btn-success">
        + Stok Masuk
    </a>

</div>

<div class="card shadow border-0 mb-3">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-md-4">

                    <label class="form-label">
                        Pencarian
                    </label>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Supplier, No Dokumen, Gudang">

                </div>

                <div class="col-md-3">

                    <label class="form-label">
                        Start Date
                    </label>

                    <input type="date"
                           name="start_date"
                           value="{{ request('start_date') }}"
                           class="form-control">

                </div>

                <div class="col-md-3">

                    <label class="form-label">
                        End Date
                    </label>

                    <input type="date"
                           name="end_date"
                           value="{{ request('end_date') }}"
                           class="form-control">

                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">

                    <button class="btn btn-primary">
                        Cari
                    </button>

                    <a href="/stock-in"
                       class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="card shadow border-0">

    <div class="table-responsive">

        <table class="table table-bordered align-middle mb-0">

            <thead class="table-primary">

                <tr>
                    <th>Tanggal</th>
                    <th>Gudang</th>
                    <th>Supplier</th>
                    <th>No Dokumen</th>
                    <th width="180">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($stockIns as $stock)

                    <tr>

                        <td>
                            {{ \Carbon\Carbon::parse($stock->tanggal)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $stock->warehouse->nama_gudang ?? '-' }}
                        </td>

                        <td>
                            {{ $stock->supplier ?? '-' }}
                        </td>

                        <td>
                            {{ $stock->nomor_dokumen ?? '-' }}
                        </td>

                        <td>

                            <a href="/stock-in/{{ $stock->id }}"
                               class="btn btn-info btn-sm">
                                Detail
                            </a>

                            <form action="/stock-in/{{ $stock->id }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus data ini?')">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-4">

                            Belum ada data stok masuk

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3">

    {{ $stockIns->withQueryString()->links() }}

</div>

@endsection