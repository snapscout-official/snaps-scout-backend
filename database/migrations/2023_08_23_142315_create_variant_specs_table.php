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
        Schema::create('variant_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('variants', 'var_code');
            $table->foreignId('specs_id')->constrained('product_specs', 'code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_specs');
    }
};
