<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Warehouse;

class DashboardController extends Controller
{
    private function currentStock($productId)
    {
        $stockAwal = Product::where('id', $productId)->value('stok_awal') ?? 0;

        $stockIn = StockInDetail::where('product_id', $productId)
            ->sum('qty');

        $stockOut = StockOutDetail::where('product_id', $productId)
            ->sum('qty');

        return $stockAwal + $stockIn - $stockOut;
    }

    public function index()
    {
        $products = Product::with('warehouse', 'unit')
            ->orderBy('nama_barang')
            ->get();

        $totalBarang = $products->count();

        $totalStok = 0;
        $stokMinimumProducts = [];

        foreach ($products as $product) {

            $stokAktual = $this->currentStock($product->id);

            $totalStok += $stokAktual;

            // Barang stok 0 tidak ditampilkan di dashboard
            if ($stokAktual > 0 && $stokAktual <= $product->stok_minimum) {

                $product->stok_aktual = $stokAktual;

                $stokMinimumProducts[] = $product;

            }
        }

        $stokMinimumProducts = collect($stokMinimumProducts)
            ->sortBy('stok_aktual')
            ->take(10);

        $stokMinimumCount = $stokMinimumProducts->count();

        $stokMasukHariIni = StockIn::whereDate('tanggal', date('Y-m-d'))->count();

        $stokKeluarHariIni = StockOut::whereDate('tanggal', date('Y-m-d'))->count();

        $warehouseSummary = Warehouse::orderBy('nama_gudang')
            ->get()
            ->map(function ($warehouse) {

                $products = Product::where('warehouse_id', $warehouse->id)->get();

                $totalStokGudang = 0;

                foreach ($products as $product) {
                    $totalStokGudang += $this->currentStock($product->id);
                }

                return [
                    'nama_gudang' => $warehouse->nama_gudang,
                    'stok' => $totalStokGudang,
                ];
            });

        return view('dashboard', compact(
            'totalBarang',
            'totalStok',
            'stokMinimumCount',
            'stokMasukHariIni',
            'stokKeluarHariIni',
            'stokMinimumProducts',
            'warehouseSummary'
        ));
    }
}