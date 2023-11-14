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
        Schema::create('agency_categorized_document', function (Blueprint $table) {
            $table->id()->from(100);
            $table->foreignId('agency_id')->constrained('agency', 'agency_id');
            $table->unsignedBigInteger('total_products');
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_categorized_document');
    }
};
