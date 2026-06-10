@extends('layouts.app')

@section('title', 'Detail Purchase Order')

@section('content')

<div class="card shadow border-0 mb-4">

    <div class="card-header bg-primary text-white">
        Detail Purchase Order
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="200">Nomor PO</th>
                <td>{{ $purchaseOrder->nomor_po }}</td>
            </tr>

            <tr>
                <th>Tanggal</th>
                <td>{{ $purchaseOrder->tanggal }}</td>
            </tr>

            <tr>
                <th>Supplier</th>
                <td>{{ $purchaseOrder->supplier->nama_supplier ?? '-' }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ strtoupper($purchaseOrder->status) }}</td>
            </tr>

        </table>

        <div class="mt-3">

            @if($purchaseOrder->status == 'draft')
                <form action="/purchase-orders/{{ $purchaseOrder->id }}/approve"
                      method="POST"
                      class="d-inline">
                    @csrf

                    <button class="btn btn-success">
                        Approve PO
                    </button>
                </form>
            @endif

            @if($purchaseOrder->status == 'approved')
                <form action="/purchase-orders/{{ $purchaseOrder->id }}/receive"
                      method="POST"
                      class="d-inline">
                    @csrf

                    <button class="btn btn-primary">
                        Terima Barang / Receive
                    </button>
                </form>
            @endif

            @if($purchaseOrder->status != 'received')
                <form action="/purchase-orders/{{ $purchaseOrder->id }}/cancel"
                      method="POST"
                      class="d-inline">
                    @csrf

                    <button class="btn btn-danger">
                        Cancel PO
                    </button>
                </form>
            @endif

            <a href="/purchase-orders" class="btn btn-secondary">
                Kembali
            </a>

        </div>

    </div>

</div>

<div class="card shadow border-0">

    <div class="card-header bg-success text-white">
        Detail Barang
    </div>

    <div class="table-responsive">

        <table class="table table-bordered mb-0">

            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Received</th>
                </tr>
            </thead>

            <tbody>
                @foreach($purchaseOrder->details as $detail)
                    <tr>
                        <td>{{ $detail->product->kode_barang }}</td>
                        <td>{{ $detail->product->nama_barang }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td>{{ $detail->qty_received ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection