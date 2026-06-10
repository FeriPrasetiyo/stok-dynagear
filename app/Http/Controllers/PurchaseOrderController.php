<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')
            ->latest()
            ->paginate(10);

        return view('purchase_orders.index', compact('purchaseOrders'));
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
    $purchaseOrder->load('supplier', 'details');
    if ($purchaseOrder->status !== 'approved') {
        return back()->with('error', 'PO hanya bisa diterima jika status approved');
    }

    DB::transaction(function () use ($purchaseOrder) {

        $stockIn = \App\Models\StockIn::create([
            'warehouse_id' => null,
            'tanggal' => date('Y-m-d'),
            'supplier' => $purchaseOrder->supplier->nama_supplier ?? '-',
            'nomor_dokumen' => $purchaseOrder->nomor_po,
            'keterangan' => 'Auto dari Purchase Order',
        ]);

        foreach ($purchaseOrder->details as $detail) {
            $stockIn->details()->create([
                'product_id' => $detail->product_id,
                'qty' => $detail->qty,
            ]);

            $detail->update([
                'qty_received' => $detail->qty,
            ]);
        }

        $purchaseOrder->update([
            'status' => 'received',
        ]);

        activity_log(
            'RECEIVE',
            'PURCHASE ORDER',
            'PO '.$purchaseOrder->nomor_po.' diterima dan masuk ke stok'
        );
    });

    return back()->with('success', 'PO berhasil diterima dan stok masuk otomatis dibuat');
}
}