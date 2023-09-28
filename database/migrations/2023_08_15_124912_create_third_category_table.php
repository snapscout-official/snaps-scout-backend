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
        Schema::create('third_category', function (Blueprint $table) {
            $table->id('third_id');
            $table->string('third_name');
            $table->foreignId('sub_id')->constrained('sub_category', 'sub_id')
                ->cascadeOnDelete();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('third_category');
    }
};
