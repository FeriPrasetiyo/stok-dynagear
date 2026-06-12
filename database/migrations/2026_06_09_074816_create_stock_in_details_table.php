<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('stock_in_details', function (Blueprint $table) {

        $table->id();

        $table->unsignedBigInteger('stock_in_id');
        $table->unsignedBigInteger('product_id');

        $table->integer('qty');

        $table->timestamps();

        $table->foreign('stock_in_id')
            ->references('id')
            ->on('stock_ins')
            ->onDelete('cascade');

        $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in_details');
    }
};
