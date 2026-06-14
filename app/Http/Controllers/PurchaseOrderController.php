<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
{
    $purchaseOrders = PurchaseOrder::with('supplier')

        ->when($request->search, function ($query) use ($request) {

            $query->where(function ($q) use ($request) {

                $q->where('nomor_po', 'like', '%'.$request->search.'%')
                  ->orWhere('status', 'like', '%'.$request->search.'%')
                  ->orWhereHas('supplier', function ($supplierQuery) use ($request) {
                      $supplierQuery->where(
                          'nama_supplier',
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

    return view(
        'purchase_orders.index',
        compact('purchaseOrders')
    );
}

    public function create()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        $products = Product::orderBy('nama_barang')->get();

        return view('purchase_orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_po' => 'required|unique:purchase_orders,nomor_po',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'product_id.*' => 'required|exists:products,id',
            'qty.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $po = PurchaseOrder::create([
                'tanggal' => $request->tanggal,
                'nomor_po' => $request->nomor_po,
                'supplier_id' => $request->supplier_id,
                'status' => 'draft',
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->product_id as $index => $productId) {
                $po->details()->create([
                    'product_id' => $productId,
                    'qty' => $request->qty[$index],
                    'keterangan' => $request->detail_keterangan[$index] ?? null,
                ]);
            }
        });

        return redirect('/purchase-orders')
            ->with('success', 'Purchase Order berhasil dibuat');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('supplier', 'details.product');

        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'PO hanya bisa di-approve jika status masih draft');
        }

        $purchaseOrder->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'PO berhasil di-approve');
    }

    public function cancel(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'PO yang sudah received tidak bisa dibatalkan');
        }

        $purchaseOrder->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'PO berhasil dibatalkan');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'PO yang sudah received tidak bisa dihapus');
        }

        $purchaseOrder->delete();

        return redirect('/purchase-orders')
            ->with('success', 'PO berhasil dihapus');
    }

public function receive(PurchaseOrder $purchaseOrder)
{
    $purchaseOrder->load('supplier', 'details.product');

    if ($purchaseOrder->status !== 'approved') {
        return back()->with('error', 'PO hanya bisa diterima jika status approved');
    }

    $receiveQty = request('receive_qty', []);

    DB::transaction(function () use ($purchaseOrder, $receiveQty) {

        $stockIn = \App\Models\StockIn::create([
            'warehouse_id' => null,
            'tanggal' => date('Y-m-d'),
            'supplier' => $purchaseOrder->supplier->nama_supplier ?? '-',
            'nomor_dokumen' => $purchaseOrder->nomor_po,
            'keterangan' => 'Receive dari Purchase Order',
        ]);

        foreach ($purchaseOrder->details as $detail) {

            $qtyTerima = (int) ($receiveQty[$detail->id] ?? 0);

            $sisa = $detail->qty - ($detail->qty_received ?? 0);

            if ($qtyTerima <= 0) {
                continue;
            }

            if ($qtyTerima > $sisa) {
                $qtyTerima = $sisa;
            }

            $stockIn->details()->create([
                'product_id' => $detail->product_id,
                'qty' => $qtyTerima,
            ]);

            $detail->update([
                'qty_received' => ($detail->qty_received ?? 0) + $qtyTerima,
            ]);
        }

        $purchaseOrder->refresh();

        $allReceived = $purchaseOrder->details()
            ->whereColumn('qty_received', '<', 'qty')
            ->count() == 0;

        if ($allReceived) {
            $purchaseOrder->update([
                'status' => 'received',
            ]);
        }

        activity_log(
            'RECEIVE',
            'PURCHASE ORDER',
            'Receive barang dari PO '.$purchaseOrder->nomor_po
        );
    });

    return back()->with('success', 'Barang PO berhasil diterima');
}
}