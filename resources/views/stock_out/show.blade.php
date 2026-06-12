@extends('layouts.app')

@section('title', 'Detail Stok Keluar')

@section('content')

<div class="card shadow border-0 mb-4">

    <div class="card-header bg-danger text-white">
        <h4 class="mb-0">
            Detail Stok Keluar
        </h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="200">Tanggal</th>
                <td>{{ $stockOut->tanggal }}</td>
            </tr>

            <tr>
                <th>Gudang</th>
                <td>
                    {{ $stockOut->warehouse->nama_gudang ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Tujuan</th>
                <td>
                    {{ $stockOut->tujuan ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Nomor SO</th>
                <td>
                    {{ $stockOut->nomor_so ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>
                    {{ $stockOut->keterangan ?? '-' }}
                </td>
            </tr>

        </table>

    </div>

</div>

<div class="card shadow border-0">

    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">
            Detail Barang Keluar
        </h5>
    </div>

    <div class="table-responsive">

        @php
            $totalQty = 0;
        @endphp

        <table class="table table-bordered align-middle mb-0">

            <thead class="table-danger">
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Satuan</th>
                    <th width="120">Qty</th>
                </tr>
            </thead>

            <tbody>

                @foreach($stockOut->details as $detail)

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

        <a href="/stock-out"
           class="btn btn-secondary">
            Kembali
        </a>

    </div>

</div>

@endsection