@extends('layouts.app')

@section('title', 'Purchase Order')

@section('content')

@php
    $role = auth()->user()->role ?? '';

    $canApprovePurchaseOrder = in_array($role, [
        'super_admin',
        'manager_pl',
        'admin_pl',
    ]);

    $canCreatePurchaseOrder = in_array($role, [
        'super_admin',
        'manager_pl',
        'admin_pl',
        'purchasing',
    ]);

    $canDeletePurchaseOrder = in_array($role, [
        'super_admin',
        'manager_pl',
        'admin_pl',
        'purchasing',
    ]);
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Purchase Order
        </h3>

        <p class="text-muted mb-0">
            Daftar Purchase Order Supplier
        </p>
    </div>

    @if($canCreatePurchaseOrder)
        <a href="/purchase-orders/create"
           class="btn btn-success">
            + Buat PO
        </a>
    @endif

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
                           placeholder="Cari No PO / Supplier / Status...">
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

                    <a href="/purchase-orders"
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
                                <span class="badge bg-secondary">
                                    Draft
                                </span>

                            @elseif($po->status == 'approved')
                                <span class="badge bg-primary">
                                    Approved
                                </span>

                            @elseif($po->status == 'received')
                                <span class="badge bg-success">
                                    Received
                                </span>

                            @else
                                <span class="badge bg-danger">
                                    Cancelled
                                </span>
                            @endif
                        </td>

                        <td>

                            <a href="/purchase-orders/{{ $po->id }}"
                               class="btn btn-info btn-sm">
                                Detail
                            </a>

                            @if($canApprovePurchaseOrder && $po->status == 'draft')
                                <form action="/purchase-orders/{{ $po->id }}/approve"
                                      method="POST"
                                      class="d-inline">
                                    @csrf

                                    <button type="submit"
                                            class="btn btn-success btn-sm">
                                        Approve
                                    </button>
                                </form>
                            @endif

                            @if($canDeletePurchaseOrder && $po->status != 'received')
                                <form action="/purchase-orders/{{ $po->id }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus PO ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            @endif

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
    {{ $purchaseOrders->withQueryString()->links() }}
</div>

@endsection