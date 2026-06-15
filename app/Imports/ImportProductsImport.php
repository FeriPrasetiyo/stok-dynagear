<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['kode_barang'])) {
            return null;
        }

        $warehouseId = Warehouse::where('id', $row['warehouse_id'] ?? null)->exists()
            ? $row['warehouse_id']
            : null;

        $brandId = Brand::where('id', $row['brand_id'] ?? null)->exists()
            ? $row['brand_id']
            : null;

        $unitId = Unit::where('id', $row['unit_id'] ?? null)->exists()
            ? $row['unit_id']
            : null;

        $categoryId = Category::where('id', $row['category_id'] ?? null)->exists()
            ? $row['category_id']
            : null;

        return Product::updateOrCreate(
            [
                'kode_barang' => $row['kode_barang'],
            ],
            [
                'warehouse_id'  => $warehouseId,
                'brand_id'      => $brandId,
                'unit_id'       => $unitId,
                'category_id'   => $categoryId,
                'nama_barang'   => $row['nama_barang'] ?? null,
                'stok_awal'     => $row['stok_awal'] ?? 0,
                'stok_minimum'  => $row['stok_minimum'] ?? 0,
            ]
        );
    }
}