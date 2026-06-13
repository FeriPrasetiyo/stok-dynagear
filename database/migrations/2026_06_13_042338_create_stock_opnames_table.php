<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_opnames', function (Blueprint $table) {

            $table->id();

            $table->date('tanggal');

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->integer('stok_sistem')->default(0);

            $table->integer('stok_fisik')->default(0);

            $table->integer('selisih')->default(0);

            $table->text('keterangan')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};