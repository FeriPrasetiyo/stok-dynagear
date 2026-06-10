@extends('layouts.app')

@section('title', 'Activity Log')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">Activity Log</h3>
        <p class="text-muted mb-0">Riwayat aktivitas pengguna sistem</p>
    </div>
</div>

<div class="card shadow border-0 mb-3">
    <div class="card-body">
        <form method="GET">
            <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari action / module / deskripsi..."
                       value="{{ request('search') }}">

                <button class="btn btn-primary">
                    Cari
                </button>

                <a href="/activity-logs" class="btn btn-secondary">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow border-0">
    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-primary">
                <tr>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $log->user->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-dark">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td>{{ $log->module ?? '-' }}</td>
                        <td>{{ $log->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada activity log.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $logs->withQueryString()->links() }}
</div>

@endsection