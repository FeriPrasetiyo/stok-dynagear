@extends('layouts.app')

@section('title', 'Request Barang')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Request Barang</h3>
        <p class="text-muted mb-0">Daftar permintaan barang</p>
    </div>

    <a href="/item-requests/create" class="btn btn-success">
        + Buat Request
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
                    <th>No Request</th>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th width="260">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($requests as $requestItem)
                    <tr>
                        <td>{{ $requestItem->nomor_request }}</td>
                        <td>{{ $requestItem->tanggal }}</td>
                        <td>{{ $requestItem->user->name ?? '-' }}</td>
                        <td>{{ $requestItem->tujuan ?? '-' }}</td>

                        <td>
                            @if($requestItem->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($requestItem->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>

                        <td>
    <a href="/item-requests/{{ $requestItem->id }}"
       class="btn btn-info btn-sm">
        Detail
    </a>

    @if(
        $requestItem->status == 'pending' &&
        in_array(auth()->user()->role, ['super_admin', 'manager_pl', 'admin_pl'])
    )
        <form action="/item-requests/{{ $requestItem->id }}/approve"
              method="POST"
              class="d-inline">
            @csrf

            <button class="btn btn-success btn-sm">
                Approve
            </button>
        </form>

        <form action="/item-requests/{{ $requestItem->id }}/reject"
              method="POST"
              class="d-inline">
            @csrf

            <button class="btn btn-warning btn-sm">
                Reject
            </button>
        </form>
    @endif

    @if($requestItem->status != 'approved')
        <form action="/item-requests/{{ $requestItem->id }}"
              method="POST"
              class="d-inline"
              onsubmit="return confirm('Hapus request ini?')">
            @csrf
            @method('DELETE')

            <button class="btn btn-danger btn-sm">
                Hapus
            </button>
        </form>
    @endif
</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada request barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $requests->links() }}
</div>

@endsection