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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id')->from(1000);
            $table->string('product_name')->unique();
            $table->unsignedBigInteger('sub_code');
            $table->foreign('sub_code')->references('sub_id')->on('sub_category');
            $table->unsignedBigInteger('third_code')->nullable();
            $table->foreign('third_code')->references('third_id')->on('third_category');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
