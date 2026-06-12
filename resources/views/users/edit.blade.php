@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="card shadow border-0">
<div class="card-header bg-warning">
    <h4 class="mb-0">
        Edit User
    </h4>
</div>

<div class="card-body">

    @if($errors->any())
        <div class="alert alert-danger">

            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

        </div>
    @endif

    <form action="/users/{{ $user->id }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>

            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $user->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Email</label>

            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $user->email) }}"
                   required>
        </div>

        <div class="mb-3">
            <label>Password Baru</label>

            <input type="password"
                   name="password"
                   class="form-control">

            <small class="text-muted">
                Kosongkan jika tidak ingin mengganti password
            </small>
        </div>

        <div class="mb-4">

            <label>Role</label>

            <select name="role"
                    class="form-control"
                    required>

                <option value="admin"
                    {{ $user->role == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>

                <option value="manager"
                    {{ $user->role == 'manager' ? 'selected' : '' }}>
                    Manager
                </option>

                <option value="purchasing"
                    {{ $user->role == 'purchasing' ? 'selected' : '' }}>
                    Purchasing
                </option>

                <option value="gudang"
                    {{ $user->role == 'gudang' ? 'selected' : '' }}>
                    Gudang
                </option>

                <option value="sales"
                    {{ $user->role == 'sales' ? 'selected' : '' }}>
                    Sales
                </option>

            </select>

        </div>

        <button class="btn btn-warning">
            Update User
        </button>

        <a href="/users"
           class="btn btn-secondary">
            Batal
        </a>

    </form>

</div>

</div>

@endsection
