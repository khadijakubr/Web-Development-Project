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
        // Add promo_id to cart_items table
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('promo_id')->nullable()->constrained('promos')->onDelete('set null');
        });

        // Add promo_id to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('promo_id')->nullable()->constrained('promos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeignIdFor('promo_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeignIdFor('promo_id');
        });
    }
};
