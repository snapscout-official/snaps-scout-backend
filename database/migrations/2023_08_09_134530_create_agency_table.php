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
        Schema::create('agency', function (Blueprint $table) {
            $table->unsignedBigInteger('agency_id');
            $table->primary('agency_id');
            $table->foreign('agency_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->string('agency_name');
            $table->foreignId('location_id')
                ->constrained('locations', 'location_id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->constrained('agency_category')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('position')->nullable(false);
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency');
    }
};
