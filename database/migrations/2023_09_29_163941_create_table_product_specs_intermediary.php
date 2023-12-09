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
        Schema::create('product_specs_intermediary', function (Blueprint $table) {
            $table->id('code')->from(1000);
            $table->foreignId('product_id')->constrained('products', 'product_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('spec_name_id')->constrained('product_specs', 'code')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_product_specs_intermediary');
    }
};
