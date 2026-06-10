<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Stok Keluar</title>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-danger text-white">

            Tambah Stok Keluar

        </div>

        <div class="card-body">

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="/stock-out"
                  method="POST">

                @csrf

                <div class="mb-3">

                    <label>Tanggal</label>

                    <input type="date"
                           name="tanggal"
                           value="{{ date('Y-m-d') }}"
                           class="form-control"
                           required>

                </div>
                
                <div class="mb-3">
    <label>Gudang</label>

    <select name="warehouse_id"
            class="form-control"
            required>
        <option value="">
            Pilih Gudang
        </option>

        @foreach($warehouses as $warehouse)
            <option value="{{ $warehouse->id }}">
                {{ $warehouse->nama_gudang }}
            </option>
        @endforeach
    </select>
</div>

                <div class="mb-3">

                    <label>Tujuan</label>

                    <input type="text"
                           name="tujuan"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Nomor SO</label>

                    <input type="text"
                           name="nomor_so"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Keterangan</label>

                    <textarea name="keterangan"
                              class="form-control"></textarea>

                </div>

                <hr>

                <h5>Barang Keluar</h5>

                <div id="items">

                    <div class="row mb-2 item-row">

                        <div class="col-md-7">

                            <select name="product_id[]"
                                    class="form-control"
                                    required>

                                <option value="">
                                    Pilih Barang
                                </option>

                                @foreach($products as $product)

                                    <option value="{{ $product->id }}">
                                        {{ $product->nama_barang }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-3">

                            <input type="number"
                                   name="qty[]"
                                   class="form-control"
                                   placeholder="Qty"
                                   required>

                        </div>

                    </div>

                </div>

                <button type="button"
                        id="addItem"
                        class="btn btn-secondary btn-sm">

                    + Tambah Barang

                </button>

                <hr>

                <button class="btn btn-danger">
                    Simpan
                </button>

                <a href="/stock-out"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>

    </div>

</div>

<script>

document.getElementById('addItem').addEventListener('click', function(){

    let html = `
        <div class="row mb-2 item-row">

            <div class="col-md-7">

                <select name="product_id[]"
                        class="form-control"
                        required>

                    <option value="">
                        Pilih Barang
                    </option>

                    @foreach($products as $product)

                    <option value="{{ $product->id }}">
                        {{ $product->nama_barang }}
                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3">

                <input type="number"
                       name="qty[]"
                       class="form-control"
                       placeholder="Qty"
                       required>

            </div>

            <div class="col-md-2">

                <button type="button"
                        class="btn btn-danger remove">

                    X

                </button>

            </div>

        </div>
    `;

    document.getElementById('items')
            .insertAdjacentHTML('beforeend', html);

});

document.addEventListener('click', function(e){

    if(e.target.classList.contains('remove')){

        e.target.closest('.item-row').remove();

    }

});

</script>

</body>
</html>