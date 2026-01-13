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
        Schema::table('orders', function (Blueprint $table) {
            // Add discount and final_price columns if they don't exist
            if (!Schema::hasColumn('orders', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->nullable();
            }
            if (!Schema::hasColumn('orders', 'final_price')) {
                $table->decimal('final_price', 10, 2)->default(0)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['discount', 'final_price']);
        });
    }
};
