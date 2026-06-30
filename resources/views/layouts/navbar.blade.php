<nav class="navbar navbar-dark bg-primary shadow sticky-top">
    <div class="container-fluid px-3 px-lg-4">

        <div class="d-flex align-items-center">

            {{-- Tombol menu khusus mobile --}}
            <button class="btn btn-light d-lg-none me-2"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar"
                    aria-controls="mobileSidebar">
                <i class="bi bi-list fs-4"></i>
            </button>

            {{-- Logo --}}
            <a href="/dashboard"
               class="navbar-brand d-flex align-items-center mb-0">

                <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                     alt="Logo"
                     width="42"
                     height="42"
                     class="rounded-circle border border-white me-2"
                     style="object-fit: cover;">

                <div class="lh-sm">
                    <div class="fw-bold">
                        Dynagear Stock
                    </div>

                    <small class="text-white-50 d-none d-sm-block">
                        Inventory System
                    </small>
                </div>

            </a>

        </div>

        <div class="d-flex align-items-center gap-2">

            <div class="text-white d-none d-md-block">
                <i class="bi bi-person-circle me-1"></i>
                {{ Auth::user()->name }}

                <span class="badge bg-warning text-dark ms-1">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>

            <a href="https://portal.dynagear.co.id/dashboard"
               class="btn btn-warning">
                Kembali Portal
            </a>

        </div>

    </div>
</nav>