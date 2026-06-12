<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;

class StockReportController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('nama_barang')->get();

        foreach ($products as $product) {
            $stockIn = StockInDetail::where('product_id', $product->id)->sum('qty');
            $stockOut = StockOutDetail::where('product_id', $product->id)->sum('qty');

            $product->stock_in = $stockIn;
            $product->stock_out = $stockOut;
            $product->stock_actual = $product->stok_awal + $stockIn - $stockOut;
        }

        return view('stock_report.index', compact('products'));
    }

    public function export()
{
    $products = \App\Models\Product::orderBy('nama_barang')->get();

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
            'Stok Awal',
            'Masuk',
            'Keluar',
            'Stok Aktual',
            'Stok Minimum',
            'Status',
        ]);

        foreach ($products as $product) {
            $stockIn = \App\Models\StockInDetail::where('product_id', $product->id)->sum('qty');
            $stockOut = \App\Models\StockOutDetail::where('product_id', $product->id)->sum('qty');

            $stockActual = $product->stok_awal + $stockIn - $stockOut;

            fputcsv($file, [
                $product->kode_barang,
                $product->nama_barang,
                $product->kategori ?? '-',
                $product->stok_awal,
                $stockIn,
                $stockOut,
                $stockActual,
                $product->stok_minimum,
                $stockActual <= $product->stok_minimum ? 'Stok Minimum' : 'Aman',
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function print()
{
    $products = Product::with(['warehouse','brand','unit'])->get();

    foreach ($products as $product) {
        $stockIn = \App\Models\StockInDetail::where('product_id', $product->id)->sum('qty');
        $stockOut = \App\Models\StockOutDetail::where('product_id', $product->id)->sum('qty');

        $product->stock_in = $stockIn;
        $product->stock_out = $stockOut;
        $product->stock_actual = $product->stok_awal + $stockIn - $stockOut;
    }

    activity_log(
        'PRINT',
        'LAPORAN STOK',
        'Mencetak laporan stok'
    );

    return view('stock_report.print', compact('products'));
}

public function pdf()
{
    $products = Product::with(['warehouse','brand','unit'])->get();

    foreach ($products as $product) {
        $stockIn = \App\Models\StockInDetail::where('product_id', $product->id)->sum('qty');
        $stockOut = \App\Models\StockOutDetail::where('product_id', $product->id)->sum('qty');

        $product->stock_in = $stockIn;
        $product->stock_out = $stockOut;
        $product->stock_actual = $product->stok_awal + $stockIn - $stockOut;
    }

    activity_log(
        'PDF',
        'LAPORAN STOK',
        'Membuka laporan stok versi PDF'
    );

    return view('stock_report.pdf', compact('products'));
}
}