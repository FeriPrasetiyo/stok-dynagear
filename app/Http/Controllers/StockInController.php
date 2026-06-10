<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StockInController extends Controller
{
    public function index()
    {
        $stockIns = StockIn::with('details.product', 'warehouse')
    ->latest()
    ->paginate(10);
        return view('stock_in.index', compact('stockIns'));
    }

    public function create()
{
    $products = Product::orderBy('nama_barang')->get();
    $warehouses = Warehouse::orderBy('nama_gudang')->get();

    return view('stock_in.create', compact('products', 'warehouses'));
}

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'tanggal' => 'required|date',
            'product_id.*' => 'required|exists:products,id',
            'qty.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $stockIn = StockIn::create([
                'warehouse_id' => $request->warehouse_id,
                'tanggal' => $request->tanggal,
                'supplier' => $request->supplier,
                'nomor_dokumen' => $request->nomor_dokumen,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->product_id as $index => $productId) {
                $stockIn->details()->create([
                    'product_id' => $productId,
                    'qty' => $request->qty[$index],
                ]);
            }
        });

        return redirect('/stock-in')
            ->with('success', 'Stok masuk berhasil disimpan');
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load('details.product');

        return view('stock_in.show', compact('stockIn'));
    }

    public function destroy(StockIn $stockIn)
    {
        $stockIn->delete();

        return redirect('/stock-in')
            ->with('success', 'Data stok masuk berhasil dihapus');
    }
}