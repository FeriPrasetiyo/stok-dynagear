<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    private function getProductsWithStock(Request $request)
    {
        $products = Product::with([
                'warehouse',
                'brand',
                'unit',
                'category',
            ])
            ->when($request->brand_id, function ($query) use ($request) {
                $query->where('brand_id', $request->brand_id);
            })
            ->orderBy('nama_barang')
            ->get();

        foreach ($products as $product) {
            $stockIn = StockInDetail::where('product_id', $product->id)->sum('qty');
            $stockOut = StockOutDetail::where('product_id', $product->id)->sum('qty');

            $product->stock_in = $stockIn;
            $product->stock_out = $stockOut;
            $product->stock_actual = $product->stok_awal + $stockIn - $stockOut;
        }

        return $products;
    }

    public function index(Request $request)
    {
        $brands = Brand::orderBy('nama_merek')->get();

        $products = $this->getProductsWithStock($request);

        return view('stock_report.index', compact(
            'products',
            'brands'
        ));
    }

    public function export(Request $request)
    {
        $products = $this->getProductsWithStock($request);

        $filename = 'laporan_stok_'.date('Y-m-d_H-i-s').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Kode Barang',
                'Nama Barang',
                'Kategori',
                'Brand',
                'Unit',
                'Stok Awal',
                'Masuk',
                'Keluar',
                'Stok Aktual',
                'Stok Minimum',
                'Status',
            ]);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->kode_barang,
                    $product->nama_barang,
                    $product->category->nama_category ?? '-',
                    $product->brand->nama_merek ?? '-',
                    $product->unit->nama_satuan ?? '-',
                    $product->stok_awal,
                    $product->stock_in,
                    $product->stock_out,
                    $product->stock_actual,
                    $product->stok_minimum,
                    $product->stock_actual <= $product->stok_minimum ? 'Stok Minimum' : 'Aman',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function print(Request $request)
    {
        $products = $this->getProductsWithStock($request);

        activity_log(
            'PRINT',
            'LAPORAN STOK',
            'Mencetak laporan stok'
        );

        return view('stock_report.print', compact('products'));
    }

    public function pdf(Request $request)
    {
        $products = $this->getProductsWithStock($request);

        activity_log(
            'PDF',
            'LAPORAN STOK',
            'Membuka laporan stok versi PDF'
        );

        return view('stock_report.pdf', compact('products'));
    }
}