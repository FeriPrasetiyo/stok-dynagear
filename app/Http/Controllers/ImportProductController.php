<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportProductController extends Controller
{
    public function index()
    {
        return view('import-products.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new ImportProductsImport, $request->file('file'));

        return back()->with('success', 'Data produk berhasil diimport.');
    }
}