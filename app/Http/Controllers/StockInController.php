<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\Warehouse;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index(Request $request)
    {
        $stockIns = StockIn::with(
            'details.product.unit',
            'warehouse'
        )
        ->when($request->search, function ($query) use ($request) {

            $query->where(function ($q) use ($request) {
                $q->where('supplier', 'like', '%'.$request->search.'%')
                  ->orWhere('nomor_dokumen', 'like', '%'.$request->search.'%')
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

        return view('stock_in.index', compact('stockIns'));
    }

    public function create()
    {
        $products = Product::with('unit')
            ->orderBy('nama_barang')
            ->get();

        $warehouses = Warehouse::orderBy('nama_gudang')->get();

        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('stock_in.create', compact(
            'products',
            'warehouses',
            'suppliers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'tanggal' => 'required|date',
            'supplier' => 'required',
            'nomor_dokumen' => 'nullable',
            'keterangan' => 'nullable',
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

            activity_log(
                'CREATE',
                'STOK MASUK',
                'Menambahkan stok masuk No Dokumen: '.($stockIn->nomor_dokumen ?? '-')
            );

        });

        return redirect('/stock-in')
            ->with('success', 'Stok masuk berhasil disimpan');
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load(
            'warehouse',
            'details.product.unit'
        );

        return view('stock_in.show', compact('stockIn'));
    }

    public function destroy(StockIn $stockIn)
    {
        $nomorDokumen = $stockIn->nomor_dokumen;

        $stockIn->delete();

        activity_log(
            'DELETE',
            'STOK MASUK',
            'Menghapus stok masuk No Dokumen: '.($nomorDokumen ?? '-')
        );

        return redirect('/stock-in')
            ->with('success', 'Data stok masuk berhasil dihapus');
    }
}