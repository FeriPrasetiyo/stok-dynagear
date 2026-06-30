<nav class="navbar navbar-dark bg-primary shadow sticky-top">
    <div class="container-fluid px-3 px-lg-4">

        <div class="d-flex align-items-center min-w-0">

            <button class="btn btn-light d-lg-none me-2"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar"
                    aria-controls="mobileSidebar">
                <i class="bi bi-list fs-4"></i>
            </button>

            <a href="/dashboard"
               class="navbar-brand d-flex align-items-center mb-0 min-w-0">

                <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                     alt="Logo"
                     width="42"
                     height="42"
                     class="rounded-circle border border-white me-2 flex-shrink-0"
                     style="object-fit: cover;">

                <div class="lh-sm text-truncate">
                    <div class="fw-bold text-truncate">
                        Dynagear Stock
                    </div>

                    <small class="text-white-50 d-none d-sm-block">
                        Inventory System
                    </small>
                </div>

            </a>

        </div>

        <div class="d-flex align-items-center gap-2 flex-shrink-0">

            <div class="text-white d-none d-md-block">
                <i class="bi bi-person-circle me-1"></i>
                {{ Auth::user()->name }}

                <span class="badge bg-warning text-dark ms-1">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>

            <a href="https://portal.dynagear.co.id/dashboard"
               class="btn btn-warning btn-portal-back">

                <i class="bi bi-arrow-left-circle me-1"></i>

                <span class="d-none d-sm-inline">
                    Kembali Portal
                </span>

                <span class="d-inline d-sm-none">
                    Portal
                </span>

            </a>

        </div>

    </div>
</nav>