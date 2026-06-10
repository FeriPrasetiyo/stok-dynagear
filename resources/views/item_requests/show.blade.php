@extends('layouts.app')

@section('title', 'Detail Request Barang')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card shadow border-0 mb-4">
    <div class="card-header bg-primary text-white">
        Detail Request Barang
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200">No Request</th>
                <td>{{ $itemRequest->nomor_request }}</td>
            </tr>

            <tr>
                <th>Tanggal</th>
                <td>{{ $itemRequest->tanggal }}</td>
            </tr>

            <tr>
                <th>User</th>
                <td>{{ $itemRequest->user->name ?? '-' }}</td>
            </tr>

            <tr>
                <th>Tujuan</th>
                <td>{{ $itemRequest->tujuan ?? '-' }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if($itemRequest->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($itemRequest->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th>Keterangan</th>
                <td>{{ $itemRequest->keterangan ?? '-' }}</td>
            </tr>
        </table>

        @if($itemRequest->status == 'pending')
            <form action="/item-requests/{{ $itemRequest->id }}/approve"
                  method="POST"
                  class="d-inline">
                @csrf

                <button class="btn btn-success">
                    Approve
                </button>
            </form>

            <form action="/item-requests/{{ $itemRequest->id }}/reject"
                  method="POST"
                  class="d-inline">
                @csrf

                <button class="btn btn-warning">
                    Reject
                </button>
            </form>
        @endif

        <a href="/item-requests" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</div>

<div class="card shadow border-0">
    <div class="card-header bg-success text-white">
        Detail Barang
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead class="table-success">
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Qty Request</th>
                </tr>
            </thead>

            <tbody>
                @foreach($itemRequest->details as $detail)
                    <tr>
                        <td>{{ $detail->product->kode_barang }}</td>
                        <td>{{ $detail->product->nama_barang }}</td>
                        <td>{{ $detail->qty }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection