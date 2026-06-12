@extends('layouts.app')

@section('title', 'Data User')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Data User</h3>

    <a href="/users/create" class="btn btn-success">
        + Tambah User
    </a>
</div>

<div class="card shadow border-0">
    <div class="table-responsive">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($users as $user)

                <tr>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>

                        @if($user->role == 'admin')
                            <span class="badge bg-danger">Admin</span>

                        @elseif($user->role == 'manager')
                            <span class="badge bg-dark">Manager</span>

                        @elseif($user->role == 'gudang')
                            <span class="badge bg-success">Gudang</span>

                        @elseif($user->role == 'purchasing')
                            <span class="badge bg-info">Purchasing</span>

                        @else
                            <span class="badge bg-primary">Sales</span>
                        @endif

                    </td>

                    <td>

                        <a href="/users/{{ $user->id }}/edit"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>
</div>

@endsection