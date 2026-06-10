<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);

        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang' => 'required',
        ]);

        Warehouse::create($request->all());

        return redirect('/warehouses')
            ->with('success', 'Gudang berhasil ditambahkan');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'nama_gudang' => 'required',
        ]);

        $warehouse->update($request->all());

        return redirect('/warehouses')
            ->with('success', 'Gudang berhasil diupdate');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return redirect('/warehouses')
            ->with('success', 'Gudang berhasil dihapus');
    }
}