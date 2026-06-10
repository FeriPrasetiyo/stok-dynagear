@extends('layouts.app')

@section('title', 'Backup Database')

@section('content')

<div class="card shadow border-0">

    <div class="card-header bg-dark text-white">
        Backup Database
    </div>

    <div class="card-body">

        <p>
            Download backup database sistem stok.
        </p>

        <form action="/backup/download"
              method="POST">

            @csrf

            <button class="btn btn-success">

                Download Backup

            </button>

        </form>

    </div>

</div>

@endsection