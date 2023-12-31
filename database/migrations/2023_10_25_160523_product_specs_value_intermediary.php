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
        Schema::create('products_specs_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spec_name_id')->constrained('product_specs', 'code')
                ->cascadeOnDelete()
                ->cascadeOnDelete();
            $table->foreignId('spec_value_id')->constrained('specs_value')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
