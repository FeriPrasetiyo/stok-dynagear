<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10);

        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_merek' => 'required',
            'keterangan' => 'nullable',
        ]);

        Brand::create([
            'nama_merek' => $request->nama_merek,
            'keterangan' => $request->keterangan,
        ]);

        activity_log(
            'CREATE',
            'MEREK',
            'Menambahkan merek: '.$request->nama_merek
        );

        return redirect('/brands')
            ->with('success', 'Merek berhasil ditambahkan');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'nama_merek' => 'required',
            'keterangan' => 'nullable',
        ]);

        $brand->update([
            'nama_merek' => $request->nama_merek,
            'keterangan' => $request->keterangan,
        ]);

        activity_log(
            'UPDATE',
            'MEREK',
            'Mengubah merek: '.$brand->nama_merek
        );

        return redirect('/brands')
            ->with('success', 'Merek berhasil diupdate');
    }

    public function destroy(Brand $brand)
    {
        $namaMerek = $brand->nama_merek;

        $brand->delete();

        activity_log(
            'DELETE',
            'MEREK',
            'Menghapus merek: '.$namaMerek
        );

        return redirect('/brands')
            ->with('success', 'Merek berhasil dihapus');
    }
}