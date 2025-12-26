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
        Schema::table('medicines', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->integer('min_stock_level')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            if (Schema::hasColumn('medicines', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('medicines', 'location_id')) {
                $table->dropForeign(['location_id']);
                $table->dropColumn('location_id');
            }
            if (Schema::hasColumn('medicines', 'min_stock_level')) {
                $table->dropColumn('min_stock_level');
            }
        });
    }
};
