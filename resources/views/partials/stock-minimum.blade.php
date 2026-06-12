<div class="card shadow border-0 mt-4">

    <div class="card-header bg-danger text-white">
        Barang Stok Minimum
    </div>

    <div class="card-body">

        @if(count($stokMinimumProducts) > 0)

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-danger">

                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok Aktual</th>
                            <th>Stok Minimum</th>
                            <th>Lokasi Rak</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($stokMinimumProducts as $product)

                            <tr>

                                <td>
                                    {{ $product->kode_barang }}
                                </td>

                                <td>
                                    {{ $product->nama_barang }}
                                </td>

                                <td>
                                    {{ $product->kategori ?? '-' }}
                                </td>

                                <td>

                                    <span class="badge bg-danger">
                                        {{ $product->stok_aktual }}
                                    </span>

                                </td>

                                <td>
                                    {{ $product->stok_minimum }}
                                </td>

                                <td>
                                    {{ $product->lokasi_rak ?? '-' }}
                                </td>

                                <td>

                                    <a href="/products/{{ $product->id }}"
                                       class="btn btn-primary btn-sm">
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="alert alert-success mb-0">

                Semua stok masih aman.

            </div>

        @endif

    </div>

</div>