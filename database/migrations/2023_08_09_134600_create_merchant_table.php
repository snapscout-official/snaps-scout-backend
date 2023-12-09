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
        Schema::create('merchant', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id');
            $table->primary('merchant_id');
            $table->foreign('merchant_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->string('business_name')
                ->unique()
                ->nullable(false);
            $table->foreignId('location_id')
                ->constrained('locations', 'location_id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('category_id')
                ->constrained('merchant_category')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('philgeps_id')
                ->unique()
                ->constrained('philgeps')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant');
    }
};
