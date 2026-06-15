<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;
use Illuminate\Http\Request;

class SalesStockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $products = Product::with([
                'brand',
                'unit',
                'category',
                'warehouse',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($q) use ($search) {
                        $q->where('nama_merek', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('nama_category', 'like', "%{$search}%");
                    });
            })
            ->orderBy('nama_barang')
            ->paginate(20)
            ->withQueryString();

        foreach ($products as $product) {
            $stockIn = StockInDetail::where('product_id', $product->id)->sum('qty');
            $stockOut = StockOutDetail::where('product_id', $product->id)->sum('qty');

            $product->stock_actual = $product->stok_awal + $stockIn - $stockOut;
        }

        return view('sales.stock_search', compact(
            'products',
            'search'
        ));
    }
}