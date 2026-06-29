<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            $table->dropForeign('item_requests_user_id_foreign');
        });
    }

    public function down(): void
    {
        Schema::table('item_requests', function (Blueprint $table) {
            $table->foreign('user_id', 'item_requests_user_id_foreign')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }
};