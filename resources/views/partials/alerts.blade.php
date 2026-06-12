@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <strong>Berhasil!</strong>

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif


@if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show">

        <strong>Error!</strong>

        {{ session('error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif


@if(session('warning'))

    <div class="alert alert-warning alert-dismissible fade show">

        <strong>Peringatan!</strong>

        {{ session('warning') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif


@if(session('info'))

    <div class="alert alert-info alert-dismissible fade show">

        <strong>Info!</strong>

        {{ session('info') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif


@if($errors->any())

    <div class="alert alert-danger alert-dismissible fade show">

        <strong>Terdapat kesalahan:</strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif