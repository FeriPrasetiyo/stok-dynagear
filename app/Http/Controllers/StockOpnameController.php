<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;
use App\Models\StockOpname;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    private function currentStock($productId)
    {
        $stockAwal = Product::where('id', $productId)->value('stok_awal') ?? 0;
        $stockIn = StockInDetail::where('product_id', $productId)->sum('qty');
        $stockOut = StockOutDetail::where('product_id', $productId)->sum('qty');

        return $stockAwal + $stockIn - $stockOut;
    }

    public function index()
    {
        $opnames = StockOpname::with('product')
            ->latest()
            ->paginate(10);

        return view('stock_opname.index', compact('opnames'));
    }

    public function create()
    {
        $products = Product::orderBy('nama_barang')->get();

        return view('stock_opname.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'stok_fisik' => 'required|integer|min:0',
            'keterangan' => 'nullable',
        ]);

        $stokSistem = $this->currentStock($request->product_id);
        $selisih = $request->stok_fisik - $stokSistem;

        StockOpname::create([
            'tanggal' => $request->tanggal,
            'product_id' => $request->product_id,
            'stok_sistem' => $stokSistem,
            'stok_fisik' => $request->stok_fisik,
            'selisih' => $selisih,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/stock-opname')
            ->with('success', 'Stock opname berhasil disimpan');
    }

    public function destroy(StockOpname $stockOpname)
    {
        $stockOpname->delete();

        return redirect('/stock-opname')
            ->with('success', 'Data stock opname berhasil dihapus');
    }
}