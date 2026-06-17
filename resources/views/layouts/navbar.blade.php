<nav class="navbar navbar-dark bg-primary shadow sticky-top">
    <div class="container-fluid px-4">

        <a href="/dashboard" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 alt="Logo"
                 width="42"
                 height="42"
                 class="rounded-circle border border-white me-2"
                 style="object-fit: cover;">

            <div class="lh-sm">
                <div class="fw-bold">Dynagear Stock</div>
                <small class="text-white-50">Inventory System</small>
            </div>
        </a>

        <div class="d-flex align-items-center gap-3">

            <div class="text-white d-none d-md-block">
                <i class="bi bi-person-circle me-1"></i>
                {{ Auth::user()->name }}
                <span class="badge bg-warning text-dark ms-1">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>

            <form action="/logout" method="POST" class="mb-0">
                @csrf

                <button type="submit" class="btn btn-warning btn-sm px-3">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Logout
                </button>
            </form>

        </div>

    </div>
</nav>