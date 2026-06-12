<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockOut;
use App\Models\StockOutDetail;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    private function currentStock($productId)
    {
        $stockAwal = Product::where('id', $productId)->value('stok_awal') ?? 0;
        $stockIn = StockInDetail::where('product_id', $productId)->sum('qty');
        $stockOut = StockOutDetail::where('product_id', $productId)->sum('qty');

        return $stockAwal + $stockIn - $stockOut;
    }

    public function index(Request $request)
{
    $stockOuts = StockOut::with(
        'details.product.unit',
        'warehouse'
    )
    ->when($request->search, function ($query) use ($request) {

        $query->where(function ($q) use ($request) {

            $q->where('nomor_so', 'like', '%'.$request->search.'%')
              ->orWhere('tujuan', 'like', '%'.$request->search.'%')
              ->orWhereHas('warehouse', function ($warehouseQuery) use ($request) {
                  $warehouseQuery->where(
                      'nama_gudang',
                      'like',
                      '%'.$request->search.'%'
                  );
              });

        });

    })
    ->when($request->start_date, function ($query) use ($request) {
        $query->whereDate('tanggal', '>=', $request->start_date);
    })
    ->when($request->end_date, function ($query) use ($request) {
        $query->whereDate('tanggal', '<=', $request->end_date);
    })
    ->latest()
    ->paginate(10);

    return view('stock_out.index', compact('stockOuts'));
}

    public function create()
    {
        $products = Product::with('unit')
    ->orderBy('nama_barang')
    ->get();
        $warehouses = Warehouse::orderBy('nama_gudang')->get();

        return view('stock_out.create', compact('products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'tanggal' => 'required|date',
            'product_id.*' => 'required|exists:products,id',
            'qty.*' => 'required|integer|min:1',
        ]);

        foreach ($request->product_id as $index => $productId) {
            $qty = (int) $request->qty[$index];
            $stock = $this->currentStock($productId);

            if ($qty > $stock) {
                return back()
                    ->withInput()
                    ->with('error', 'Stok tidak cukup untuk salah satu barang.');
            }
        }

        DB::transaction(function () use ($request) {

            $stockOut = StockOut::create([
                'warehouse_id' => $request->warehouse_id,
                'tanggal' => $request->tanggal,
                'tujuan' => $request->tujuan,
                'nomor_so' => $request->nomor_so,
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->product_id as $index => $productId) {

                $qty = (int) $request->qty[$index];

                $stockOut->details()->create([
                    'product_id' => $productId,
                    'qty' => $qty,
                ]);

                $product = Product::find($productId);
                $stokAktual = $this->currentStock($productId);

                if ($product && $stokAktual <= $product->stok_minimum) {
                    activity_log(
                        'WARNING',
                        'STOK MINIMUM',
                        'Barang '.$product->nama_barang.' mencapai stok minimum. Stok saat ini: '.$stokAktual
                    );
                }
            }

            activity_log(
                'CREATE',
                'STOK KELUAR',
                'Menambahkan transaksi stok keluar No: '.$stockOut->nomor_so
            );
        });

        return redirect('/stock-out')
            ->with('success', 'Stok keluar berhasil disimpan');
    }

    public function show(StockOut $stockOut)
{
    $stockOut->load(
        'warehouse',
        'details.product.unit'
    );

    return view('stock_out.show', compact('stockOut'));
}

    public function destroy(StockOut $stockOut)
    {
        $nomorSo = $stockOut->nomor_so;

        $stockOut->delete();

        activity_log(
            'DELETE',
            'STOK KELUAR',
            'Menghapus transaksi stok keluar No: '.$nomorSo
        );

        return redirect('/stock-out')
            ->with('success', 'Data stok keluar berhasil dihapus');
    }
}