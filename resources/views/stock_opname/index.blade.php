@extends('layouts.app')

@section('title', 'Stock Opname')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="fw-bold mb-1">
            Data Stock Opname
        </h3>

        <p class="text-muted mb-0">
            Riwayat pemeriksaan stok fisik barang
        </p>
    </div>

    <a href="/stock-opname/create"
       class="btn btn-warning">
        + Stock Opname
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
                           placeholder="Kode / nama barang...">
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

                    <a href="/stock-opname"
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

            <thead class="table-warning">
                <tr>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>Barang</th>
                    <th>Satuan</th>
                    <th>Stok Sistem</th>
                    <th>Stok Fisik</th>
                    <th>Selisih</th>
                    <th>Keterangan</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($opnames as $opname)

                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($opname->tanggal)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $opname->product->kode_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $opname->product->nama_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $opname->product->unit->nama_satuan ?? '-' }}
                        </td>

                        <td>
                            {{ $opname->stok_sistem }}
                        </td>

                        <td>
                            {{ $opname->stok_fisik }}
                        </td>

                        <td>
                            @if($opname->selisih == 0)
                                <span class="badge bg-success">
                                    0
                                </span>
                            @elseif($opname->selisih > 0)
                                <span class="badge bg-primary">
                                    +{{ $opname->selisih }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    {{ $opname->selisih }}
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $opname->keterangan ?? '-' }}
                        </td>

                        <td>
                            <form action="/stock-opname/{{ $opname->id }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus data ini?')">

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
                        <td colspan="9"
                            class="text-center py-4">
                            Belum ada data stock opname
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3">
    {{ $opnames->withQueryString()->links() }}
</div>

@endsection