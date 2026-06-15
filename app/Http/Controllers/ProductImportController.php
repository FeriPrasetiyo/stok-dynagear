<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductImportController extends Controller
{
    public function index()
    {
        return view('products.import');
    }

    public function template()
    {
        $filename = 'template_products.csv';
        $path = storage_path($filename);

        $handle = fopen($path, 'w');

        fputcsv($handle, [
            'warehouse_id',
            'brand_id',
            'unit_id',
            'category_id',
            'kode_barang',
            'nama_barang',
            'stok_awal',
            'stok_minimum',
        ]);

        fclose($handle);

        return response()->download($path);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        $spreadsheet = IOFactory::load($request->file('file'));
        $rows = $spreadsheet->getActiveSheet()->toArray();

        session(['import_rows' => $rows]);

        return view('products.preview', compact('rows'));
    }

    public function store()
    {
        $rows = session('import_rows', []);

        foreach (array_slice($rows, 1) as $row) {
            if (empty($row[4])) {
                continue;
            }

            $warehouseId = Warehouse::where('id', $row[0])->exists() ? $row[0] : null;
            $brandId = Brand::where('id', $row[1])->exists() ? $row[1] : null;
            $unitId = Unit::where('id', $row[2])->exists() ? $row[2] : null;
            $categoryId = Category::where('id', $row[3])->exists() ? $row[3] : null;

            Product::updateOrCreate(
                ['kode_barang' => $row[4]],
                [
                    'warehouse_id'  => $warehouseId,
                    'brand_id'      => $brandId,
                    'unit_id'       => $unitId,
                    'category_id'   => $categoryId,
                    'nama_barang'   => $row[5] ?? null,
                    'stok_awal'     => $row[6] ?? 0,
                    'stok_minimum'  => $row[7] ?? 0,
                ]
            );
        }

        session()->forget('import_rows');

        return redirect()
            ->route('products.index')
            ->with('success', 'Data berhasil diimport ke products.');
    }
}