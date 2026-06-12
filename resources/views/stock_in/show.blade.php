@extends('layouts.app')

@section('title', 'Detail Stok Masuk')

@section('content')

<div class="card shadow border-0 mb-4">

    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            Detail Stok Masuk
        </h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="200">Tanggal</th>
                <td>{{ $stockIn->tanggal }}</td>
            </tr>

            <tr>
                <th>Gudang</th>
                <td>
                    {{ $stockIn->warehouse->nama_gudang ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Supplier</th>
                <td>
                    {{ $stockIn->supplier ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>No Dokumen</th>
                <td>
                    {{ $stockIn->nomor_dokumen ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>
                    {{ $stockIn->keterangan ?? '-' }}
                </td>
            </tr>

        </table>

    </div>

</div>

<div class="card shadow border-0">

    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            Detail Barang
        </h5>
    </div>

    <div class="table-responsive">

        @php
            $totalQty = 0;
        @endphp

        <table class="table table-bordered align-middle mb-0">

            <thead class="table-success">

                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th width="120">Qty</th>
                </tr>

            </thead>

            <tbody>

                @foreach($stockIn->details as $detail)

                    @php
                        $totalQty += $detail->qty;
                    @endphp

                    <tr>

                        <td>
                            {{ $detail->product->kode_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->product->nama_barang ?? '-' }}
                        </td>

                        <td>

                            {{ $detail->product->unit->nama_satuan ?? '-' }}

                            @if(
                                $detail->product &&
                                $detail->product->unit &&
                                $detail->product->unit->kode
                            )
                                ({{ $detail->product->unit->kode }})
                            @endif

                        </td>

                        <td>
                            {{ $detail->qty }}
                        </td>

                    </tr>

                @endforeach

                <tr class="table-light">

                    <th colspan="3" class="text-end">
                        Total Qty
                    </th>

                    <th>
                        {{ $totalQty }}
                    </th>

                </tr>

            </tbody>

        </table>

    </div>

    <div class="card-footer bg-white">

        <a href="/stock-in"
           class="btn btn-secondary">
            Kembali
        </a>

    </div>

</div>

@endsection