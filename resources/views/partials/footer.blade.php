<footer class="bg-white border-top py-3 mt-5">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6">

                <small class="text-muted">

                    © {{ date('Y') }}
                    Dynagear Stock Management System

                </small>

            </div>

            <div class="col-md-6 text-md-end">

                <small class="text-muted">

                    Login sebagai :

                    <strong>
                        {{ Auth::user()->name }}
                    </strong>

                    ({{ ucfirst(Auth::user()->role) }})

                </small>

            </div>

        </div>

    </div>

</footer>