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
        $products = Product::with('unit')
            ->orderBy('nama_barang')
            ->get();

        $product = null;
        $mutations = [];
        $saldo = 0;

        if ($request->product_id) {

            $product = Product::with('unit')
                ->findOrFail($request->product_id);

            $saldo = $product->stok_awal;

            $mutations[] = [
                'tanggal' => $product->created_at,
                'jenis' => 'STOK AWAL',
                'masuk' => $product->stok_awal,
                'keluar' => 0,
                'saldo' => $saldo,
            ];

            $stockIns = StockInDetail::with('stockIn')
                ->where('product_id', $product->id)
                ->get();

            foreach ($stockIns as $item) {

                $saldo += $item->qty;

                $mutations[] = [
                    'tanggal' => $item->stockIn->tanggal ?? $item->created_at,
                    'jenis' => 'STOK MASUK',
                    'masuk' => $item->qty,
                    'keluar' => 0,
                    'saldo' => $saldo,
                ];
            }

            $stockOuts = StockOutDetail::with('stockOut')
                ->where('product_id', $product->id)
                ->get();

            foreach ($stockOuts as $item) {

                $saldo -= $item->qty;

                $mutations[] = [
                    'tanggal' => $item->stockOut->tanggal ?? $item->created_at,
                    'jenis' => 'STOK KELUAR',
                    'masuk' => 0,
                    'keluar' => $item->qty,
                    'saldo' => $saldo,
                ];
            }

            usort($mutations, function ($a, $b) {
                return strtotime($a['tanggal']) <=> strtotime($b['tanggal']);
            });

            $saldo = 0;

            foreach ($mutations as $index => $row) {
                if ($row['jenis'] == 'STOK AWAL') {
                    $saldo = $row['masuk'];
                } else {
                    $saldo = $saldo + $row['masuk'] - $row['keluar'];
                }

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