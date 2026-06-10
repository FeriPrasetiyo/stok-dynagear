@extends('layouts.app')

@section('title', 'Purchase Order')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Purchase Order
        </h3>

        <p class="text-muted mb-0">
            Daftar Purchase Order Supplier
        </p>
    </div>

    <a href="/purchase-orders/create"
       class="btn btn-success">
        + Buat PO
    </a>

</div>

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

<div class="card shadow border-0">

    <div class="table-responsive">

        <table class="table table-bordered align-middle mb-0">

            <thead class="table-primary">

                <tr>
                    <th>No PO</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th width="250">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($purchaseOrders as $po)

                    <tr>

                        <td>{{ $po->nomor_po }}</td>

                        <td>{{ $po->tanggal }}</td>

                        <td>
                            {{ $po->supplier->nama_supplier ?? '-' }}
                        </td>

                        <td>

                            @if($po->status == 'draft')
                                <span class="badge bg-secondary">Draft</span>

                            @elseif($po->status == 'approved')
                                <span class="badge bg-primary">Approved</span>

                            @elseif($po->status == 'received')
                                <span class="badge bg-success">Received</span>

                            @else
                                <span class="badge bg-danger">Cancelled</span>

                            @endif

                        </td>

                        <td>

                            <a href="/purchase-orders/{{ $po->id }}"
                               class="btn btn-info btn-sm">
                                Detail
                            </a>

                            @if($po->status == 'draft')

                                <form action="/purchase-orders/{{ $po->id }}/approve"
                                      method="POST"
                                      class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">
                                        Approve
                                    </button>

                                </form>

                            @endif

                            <form action="/purchase-orders/{{ $po->id }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus PO ini?')">

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

                        <td colspan="5"
                            class="text-center">

                            Belum ada Purchase Order

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-3">
    {{ $purchaseOrders->links() }}
</div>

@endsection