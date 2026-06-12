<div class="card shadow border-0 mt-4">

    <div class="card-header bg-info text-white">
        Stok Per Gudang
    </div>

    <div class="card-body">

        @if(isset($warehouseSummary) && count($warehouseSummary) > 0)

            <div class="row">

                @foreach($warehouseSummary as $warehouse)

                    <div class="col-md-4 mb-3">

                        <div class="border rounded p-3 bg-light h-100">

                            <h6 class="fw-bold mb-2">
                                {{ $warehouse['nama_gudang'] }}
                            </h6>

                            <h3 class="text-primary fw-bold">
                                {{ number_format($warehouse['stok']) }}
                            </h3>

                            <small class="text-muted">
                                Total Stok Barang
                            </small>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="alert alert-info mb-0">

                Belum ada data gudang.

            </div>

        @endif

    </div>

</div>