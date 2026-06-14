@extends('layouts.app')

@section('title', 'QR Barang')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-6">

        <div class="card shadow border-0">

            <div class="card-header bg-primary text-white text-center">

                <h4 class="mb-0">
                    QR Code Barang
                </h4>

            </div>

            <div class="card-body text-center">

                @if($product->foto)

                    <img src="{{ asset('storage/'.$product->foto) }}"
                         class="img-fluid rounded border mb-3"
                         style="height:220px;object-fit:cover;">

                @endif

                <h3 class="fw-bold text-primary">
                    {{ $product->nama_barang }}
                </h3>

                <p class="text-muted">
                    {{ $product->kode_barang }}
                </p>

                <div class="my-4">

                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(url('/products/'.$product->id)) }}"
                         alt="QR Code">

                </div>

                <table class="table table-bordered">

                    <tr>
                        <th width="35%">category</th>
                        <td>
                            {{ $product->category->name ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Merek</th>
                        <td>
                            {{ $product->brand->nama_merek ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Satuan</th>
                        <td>
                            {{ $product->unit->nama_satuan ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Gudang</th>
                        <td>
                            {{ $product->warehouse->nama_gudang ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Lokasi Rak</th>
                        <td>
                            {{ $product->lokasi_rak ?? '-' }}
                        </td>
                    </tr>

                </table>

                <div class="alert alert-info">

                    Scan QR untuk melihat detail barang.

                </div>

                <div class="d-flex justify-content-center gap-2">

                    <button onclick="window.print()"
                            class="btn btn-primary">

                        🖨 Cetak QR

                    </button>

                    <a href="/products/{{ $product->id }}"
                       class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

@media print {

    .navbar,
    .btn,
    footer,
    .alert {
        display: none !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    body {
        background: white !important;
    }

}

</style>

@endsection