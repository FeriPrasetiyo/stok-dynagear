<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockOut;
use App\Models\StockOutDetail;
use App\Models\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemRequestController extends Controller
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
        $requests = ItemRequest::with('user')
            ->latest()
            ->paginate(10);

        return view('item_requests.index', compact('requests'));
    }

    public function create()
    {
        $products = Product::orderBy('nama_barang')->get();

        return view('item_requests.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_request' => 'required|unique:item_requests,nomor_request',
            'product_id.*' => 'required|exists:products,id',
            'qty.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $itemRequest = ItemRequest::create([
                'tanggal' => $request->tanggal,
                'user_id' => auth()->id(),
                'nomor_request' => $request->nomor_request,
                'tujuan' => $request->tujuan,
                'status' => 'pending',
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->product_id as $index => $productId) {
                $itemRequest->details()->create([
                    'product_id' => $productId,
                    'qty' => $request->qty[$index],
                ]);
            }
        });

        return redirect('/item-requests')
            ->with('success', 'Request barang berhasil dibuat');
    }

    public function show(ItemRequest $itemRequest)
    {
        $itemRequest->load('user', 'details.product');

        return view('item_requests.show', compact('itemRequest'));
    }

    public function approve(ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending') {
            return back()->with('error', 'Request sudah diproses');
        }

        $itemRequest->load('details.product');

        foreach ($itemRequest->details as $detail) {
            $stock = $this->currentStock($detail->product_id);

            if ($detail->qty > $stock) {
                return back()->with(
                    'error',
                    'Stok tidak cukup untuk barang: '.$detail->product->nama_barang
                );
            }
        }

        DB::transaction(function () use ($itemRequest) {
            $stockOut = StockOut::create([
                'tanggal' => date('Y-m-d'),
                'tujuan' => $itemRequest->tujuan,
                'nomor_so' => $itemRequest->nomor_request,
                'keterangan' => 'Auto dari request barang',
            ]);

            foreach ($itemRequest->details as $detail) {
                $stockOut->details()->create([
                    'product_id' => $detail->product_id,
                    'qty' => $detail->qty,
                ]);
            }

            $itemRequest->update([
                'status' => 'approved',
            ]);
        });

        return back()->with('success', 'Request berhasil di-approve dan stok keluar otomatis dibuat');
    }

    public function reject(ItemRequest $itemRequest)
    {
        if ($itemRequest->status !== 'pending') {
            return back()->with('error', 'Request sudah diproses');
        }

        $itemRequest->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Request berhasil ditolak');
    }

    public function destroy(ItemRequest $itemRequest)
    {
        if ($itemRequest->status === 'approved') {
            return back()->with('error', 'Request approved tidak bisa dihapus');
        }

        $itemRequest->delete();

        return redirect('/item-requests')
            ->with('success', 'Request berhasil dihapus');
    }
}