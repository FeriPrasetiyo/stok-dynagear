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
        $status = $request->status;
        $sort = $request->sort;

        $products = Product::with([
                'brand',
                'unit',
                'category',
                'warehouse',
            ])
            ->withSum('stockInDetails as total_stock_in', 'qty')
            ->withSum('stockOutDetails as total_stock_out', 'qty')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_barang', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%")
                        ->orWhereHas('brand', function ($brand) use ($search) {
                            $brand->where('nama_merek', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($category) use ($search) {
                            $category->where('nama_category', 'like', "%{$search}%");
                        });
                });
            })
            ->get();

        foreach ($products as $product) {
            $product->stock_actual =
                $product->stok_awal
                + ($product->total_stock_in ?? 0)
                - ($product->total_stock_out ?? 0);
        }

        if ($status == 'tersedia') {
            $products = $products->where('stock_actual', '>', 0);
        }

        if ($status == 'kosong') {
            $products = $products->where('stock_actual', '<=', 0);
        }

        if ($sort == 'stok_terbanyak') {
            $products = $products->sortByDesc('stock_actual');
        } elseif ($sort == 'stok_terkecil') {
            $products = $products->sortBy('stock_actual');
        } else {
            $products = $products->sortBy('nama_barang');
        }

        $page = request()->get('page', 1);
        $perPage = 20;

        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $products->forPage($page, $perPage),
            $products->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('sales.stock_search', compact(
            'products',
            'search',
            'status',
            'sort'
        ));
    }
}