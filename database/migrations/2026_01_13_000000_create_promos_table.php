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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., "SAVE20"
            $table->enum('discount_type', ['percentage', 'fixed']); // Type of discount
            $table->decimal('discount_value', 8, 2); // 20 for 20% or 50 for $50 off
            $table->integer('max_uses')->nullable(); // NULL = unlimited
            $table->integer('current_uses')->default(0); // How many times used
            $table->dateTime('expiry_date')->nullable(); // When it expires
            $table->boolean('is_active')->default(true); // Enable/disable
            $table->text('description')->nullable(); // Admin notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
