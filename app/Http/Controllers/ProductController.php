<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::with('warehouse')
            ->when($search, function ($query) use ($search) {
                $query->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        $warehouses = Warehouse::orderBy('nama_gudang')->get();

        return view('products.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'kode_barang' => 'required|unique:products,kode_barang',
            'nama_barang' => 'required',
            'kategori' => 'nullable',
            'satuan' => 'required',
            'stok_awal' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
            'lokasi_rak' => 'nullable',
            'keterangan' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'warehouse_id',
            'kode_barang',
            'nama_barang',
            'kategori',
            'satuan',
            'stok_awal',
            'stok_minimum',
            'lokasi_rak',
            'keterangan',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')
                ->store('products', 'public');
        }

        Product::create($data);

        return redirect('/products')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Product $product)
    {
        $product->load('warehouse');
        
        $stockIn = \App\Models\StockInDetail::where('product_id', $product->id)
            ->sum('qty');

        $stockOut = \App\Models\StockOutDetail::where('product_id', $product->id)
            ->sum('qty');

        $stockActual = $product->stok_awal + $stockIn - $stockOut;

        $stockInDetails = \App\Models\StockInDetail::with('product')
            ->where('product_id', $product->id)
            ->latest()
            ->get();

        $stockOutDetails = \App\Models\StockOutDetail::with('product')
            ->where('product_id', $product->id)
            ->latest()
            ->get();

        return view('products.show', compact(
            'product',
            'stockIn',
            'stockOut',
            'stockActual',
            'stockInDetails',
            'stockOutDetails'
        ));
    }

    public function edit(Product $product)
    {
        $warehouses = Warehouse::orderBy('nama_gudang')->get();

        return view('products.edit', compact(
            'product',
            'warehouses'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'kode_barang' => 'required|unique:products,kode_barang,' . $product->id,
            'nama_barang' => 'required',
            'kategori' => 'nullable',
            'satuan' => 'required',
            'stok_awal' => 'required|numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
            'lokasi_rak' => 'nullable',
            'keterangan' => 'nullable',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'warehouse_id',
            'kode_barang',
            'nama_barang',
            'kategori',
            'satuan',
            'stok_awal',
            'stok_minimum',
            'lokasi_rak',
            'keterangan',
        ]);

        if ($request->hasFile('foto')) {

            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }

            $data['foto'] = $request->file('foto')
                ->store('products', 'public');
        }

        $product->update($data);

        return redirect('/products')
            ->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Product $product)
    {
        if ($product->foto) {
            Storage::disk('public')->delete($product->foto);
        }

        $product->delete();

        return redirect('/products')
            ->with('success', 'Barang berhasil dihapus');
    }
    public function importForm()
{
    return view('products.import');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:csv,txt',
    ]);

    $file = fopen($request->file('file')->getPathname(), 'r');

    $header = fgetcsv($file);

    while (($row = fgetcsv($file)) !== false) {
        Product::updateOrCreate(
            ['kode_barang' => $row[0]],
            [
                'nama_barang' => $row[1],
                'kategori' => $row[2] ?? null,
                'satuan' => $row[3] ?? 'pcs',
                'stok_awal' => $row[4] ?? 0,
                'stok_minimum' => $row[5] ?? 0,
                'lokasi_rak' => $row[6] ?? null,
                'keterangan' => $row[7] ?? null,
            ]
        );
    }

    fclose($file);

    activity_log(
        'IMPORT',
        'MASTER BARANG',
        'Import data barang dari CSV'
    );

    return redirect('/products')->with('success', 'Import barang berhasil');
}

public function qr(Product $product)
{
    activity_log(
        'PRINT',
        'QR BARANG',
        'Mencetak QR barang '.$product->nama_barang
    );

    return view('products.qr', compact('product'));
}
}