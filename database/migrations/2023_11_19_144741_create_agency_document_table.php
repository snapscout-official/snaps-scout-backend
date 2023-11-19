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
        Schema::create('agency_document', function (Blueprint $table) {
            $table->id();
            $table->string('document_name');
            $table->foreignId('agency_owner')->constrained('agency', 'agency_id');
            $table->boolean('is_categorized')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_document');
    }
};
