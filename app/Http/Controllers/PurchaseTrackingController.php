<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\PurchaseOrderDetail;
use Illuminate\Http\Request;

class PurchaseTrackingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $brandId = $request->brand_id;
        $status = $request->status;

        $brands = Brand::orderBy('nama_merek')->get();

        $details = PurchaseOrderDetail::with([
                'purchaseOrder',
                'product.brand',
                'product.unit',
                'product.category',
            ])
            ->whereHas('purchaseOrder', function ($query) use ($status) {
                $query->whereIn('status', [
                    'draft',
                    'approved',
                    'ordered',
                    'partial_received',
                    'received',
                ]);

                if ($status) {
                    $query->where('status', $status);
                }
            })
            ->when($brandId, function ($query) use ($brandId) {
                $query->whereHas('product', function ($product) use ($brandId) {
                    $product->where('brand_id', $brandId);
                });
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($product) use ($search) {
                    $product->where('kode_barang', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%")
                        ->orWhereHas('brand', function ($brand) use ($search) {
                            $brand->where('nama_merek', 'like', "%{$search}%");
                        })
                        ->orWhereHas('category', function ($category) use ($search) {
                            $category->where('nama_category', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('sales.purchase_tracking', compact(
            'details',
            'brands',
            'search',
            'brandId',
            'status'
        ));
    }
}