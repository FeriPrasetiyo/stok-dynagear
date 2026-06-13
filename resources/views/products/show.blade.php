@extends('layouts.app')

@section('title', 'Judul Halaman')

@section('content')

<div class="card shadow border-0 mb-4">
        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    @if($product->foto)
                        <img src="{{ asset('storage/'.$product->foto) }}"
                             class="img-fluid rounded border"
                             style="width:100%; height:280px; object-fit:cover;">
                    @else
                        <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                             style="height:280px;">
                            <span class="text-muted">Tidak ada foto</span>
                        </div>
                    @endif

                    <div class="text-center mt-3">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode(url('/products/'.$product->id)) }}"alt="QR Code">

                        <div class="small text-muted mt-2">
                            {{ $product->kode_barang }}
                        </div>
                    </div>

                    <div class="mt-3">

    <a href="/products/{{ $product->id }}/qr"
       class="btn btn-success btn-sm">
        Cetak QR
    </a>

</div>

                </div>

                <div class="col-md-8">

                    <h3 class="fw-bold text-primary">
                        {{ $product->nama_barang }}
                    </h3>

                    <p class="text-muted">
                        {{ $product->keterangan ?? '-' }}
                    </p>

                    <table class="table table-bordered">
                        <tr>
                            <th width="180">Kode Barang</th>
                            <td>{{ $product->kode_barang }}</td>
                        </tr>

                        <tr>
                            <th>category</th>
                            <td>{{ $product->category ?? '-' }}</td>
                        </tr>

                        <tr>
    <th>Merek</th>
    <td>
        {{ $product->brand->nama_merek ?? '-' }}
    </td>
</tr>

                        <tr>
    <th>Gudang</th>
    <td>
        {{ $product->warehouse->nama_gudang ?? '-' }}
    </td>
</tr>

                        <tr>
    <th>Satuan</th>
    <td>
        @if($product->unit)

            {{ $product->unit->nama_satuan }}

            @if($product->unit->kode)
                ({{ $product->unit->kode }})
            @endif

        @else

            -

        @endif
    </td>
</tr>

                        <tr>
                            <th>Lokasi Rak</th>
                            <td>{{ $product->lokasi_rak ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Stok Awal</th>
                            <td>{{ $product->stok_awal }}</td>
                        </tr>

                        <tr>
                            <th>Stok Masuk</th>
                            <td>
                                <span class="badge bg-success">
                                    {{ $stockIn }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Stok Keluar</th>
                            <td>
                                <span class="badge bg-danger">
                                    {{ $stockOut }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Stok Aktual</th>
                            <td>
                                <strong>{{ $stockActual }}</strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Stok Minimum</th>
                            <td>{{ $product->stok_minimum }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($stockActual <= $product->stok_minimum)
                                    <span class="badge bg-danger">Stok Minimum</span>
                                @else
                                    <span class="badge bg-success">Aman</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <a href="/products/{{ $product->id }}/edit"
                       class="btn btn-warning">
                        Edit Barang
                    </a>

                </div>

            </div>

        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-success text-white">
            Riwayat Stok Masuk
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th>Tanggal</th>
                            <th>Qty</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($stockInDetails as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $item->qty }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    Belum ada stok masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-danger text-white">
            Riwayat Stok Keluar
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>Tanggal</th>
                            <th>Qty</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($stockOutDetails as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $item->qty }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    Belum ada stok keluar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection