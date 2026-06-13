<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasColumn('categories', 'nama_kategori') &&
            !Schema::hasColumn('categories', 'nama_category')
        ) {
            Schema::table('categories', function (Blueprint $table) {
                $table->renameColumn('nama_kategori', 'nama_category');
            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasColumn('categories', 'nama_category') &&
            !Schema::hasColumn('categories', 'nama_kategori')
        ) {
            Schema::table('categories', function (Blueprint $table) {
                $table->renameColumn('nama_category', 'nama_kategori');
            });
        }
    }
};