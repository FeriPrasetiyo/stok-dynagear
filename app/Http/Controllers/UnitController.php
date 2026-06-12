<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->paginate(10);

        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required',
            'kode' => 'nullable',
            'keterangan' => 'nullable',
        ]);

        Unit::create([
            'nama_satuan' => $request->nama_satuan,
            'kode' => $request->kode,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/units')
            ->with('success', 'Satuan berhasil ditambahkan');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'nama_satuan' => 'required',
            'kode' => 'nullable',
            'keterangan' => 'nullable',
        ]);

        $unit->update([
            'nama_satuan' => $request->nama_satuan,
            'kode' => $request->kode,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/units')
            ->with('success', 'Satuan berhasil diupdate');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect('/units')
            ->with('success', 'Satuan berhasil dihapus');
    }
}