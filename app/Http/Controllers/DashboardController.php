<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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
        $products = Product::orderBy('nama_barang')->get();
        // $warehouses = Warehouse::withCount('products')->get();

        $totalBarang = $products->count();

        $totalStok = 0;
        $stokMinimumProducts = [];

        foreach ($products as $product) {
            $stokAktual = $this->currentStock($product->id);
            $totalStok += $stokAktual;

            if ($stokAktual <= $product->stok_minimum) {
                $product->stok_aktual = $stokAktual;
                $stokMinimumProducts[] = $product;
            }
        }

        $stokMinimumCount = count($stokMinimumProducts);

        $stokMasukHariIni = StockIn::whereDate('tanggal', date('Y-m-d'))->count();
        $stokKeluarHariIni = StockOut::whereDate('tanggal', date('Y-m-d'))->count();
        $warehouseSummary = Warehouse::all()->map(function ($warehouse) {

    $stokAwal = Product::where('warehouse_id', $warehouse->id)
        ->sum('stok_awal');

    return [
        'nama_gudang' => $warehouse->nama_gudang,
        'stok' => $stokAwal,
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