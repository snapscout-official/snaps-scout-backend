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
        Schema::create('product_product_list', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products', 'product_id');
            $table->foreignId('product_list_id')->constrained('product_lists', 'list_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_product_list');
    }
};
