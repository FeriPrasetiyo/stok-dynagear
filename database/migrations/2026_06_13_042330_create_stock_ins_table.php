<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_ins', function (Blueprint $table) {

    $table->id();

    $table->foreignId('warehouse_id')
        ->nullable()
        ->constrained('warehouses')
        ->nullOnDelete();

    $table->date('tanggal');

    $table->string('supplier')->nullable();

    $table->string('nomor_dokumen')->nullable();

    $table->text('keterangan')->nullable();

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};