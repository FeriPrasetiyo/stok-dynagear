<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SalesStockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $brandId = $request->brand_id;

        $brands = Brand::orderBy('nama_merek', 'asc')->get();

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
            ->when($brandId, function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            })
            ->get();

        foreach ($products as $product) {
            $product->stock_actual =
                ($product->stok_awal ?? 0)
                + ($product->total_stock_in ?? 0)
                - ($product->total_stock_out ?? 0);
        }

        $products = $products
            ->filter(function ($product) {
                return $product->stock_actual > 0;
            })
            ->sortBy('kode_barang', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        $page = request()->get('page', 1);
        $perPage = 20;

        $products = new LengthAwarePaginator(
            $products->forPage($page, $perPage)->values(),
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
            'brandId',
            'brands'
        ));
    }
}