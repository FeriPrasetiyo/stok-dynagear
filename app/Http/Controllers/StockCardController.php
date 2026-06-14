<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInDetail;
use App\Models\StockOutDetail;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::orderBy('nama_barang')
            ->get();

        $product = null;
        $mutations = [];
        $saldo = 0;

        if ($request->product_id) {

            $product = Product::with([
                'unit',
                'brand',
                'warehouse',
                'category',
            ])->findOrFail($request->product_id);

            $mutations[] = [
                'tanggal' => $product->created_at,
                'jenis' => 'STOK AWAL',
                'dokumen' => '-',
                'keterangan' => 'Stok Awal Barang',
                'masuk' => $product->stok_awal,
                'keluar' => 0,
                'saldo' => 0,
            ];

            $stockIns = StockInDetail::with('stockIn')
                ->where('product_id', $product->id)
                ->get();

            foreach ($stockIns as $item) {
                $mutations[] = [
                    'tanggal' => $item->created_at,
                    'jenis' => 'STOK MASUK',
                    'dokumen' => $item->stockIn->nomor_dokumen ?? '-',
                    'keterangan' => $item->stockIn->keterangan ?? '-',
                    'masuk' => $item->qty,
                    'keluar' => 0,
                    'saldo' => 0,
                ];
            }

            $stockOuts = StockOutDetail::with('stockOut')
                ->where('product_id', $product->id)
                ->get();

            foreach ($stockOuts as $item) {
                $mutations[] = [
                    'tanggal' => $item->created_at,
                    'jenis' => 'STOK KELUAR',
                    'dokumen' => $item->stockOut->nomor_so ?? '-',
                    'keterangan' => $item->stockOut->keterangan ?? '-',
                    'masuk' => 0,
                    'keluar' => $item->qty,
                    'saldo' => 0,
                ];
            }

            usort($mutations, function ($a, $b) {
                return strtotime($a['tanggal']) <=> strtotime($b['tanggal']);
            });

            $saldo = 0;

            foreach ($mutations as $index => $row) {
                $saldo = $saldo + $row['masuk'] - $row['keluar'];

                $mutations[$index]['saldo'] = $saldo;
            }
        }

        return view('stock_card.index', compact(
            'products',
            'product',
            'mutations',
            'saldo'
        ));
    }
}