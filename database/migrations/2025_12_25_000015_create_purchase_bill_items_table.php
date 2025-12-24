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
        Schema::create('purchase_bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_bill_id')->constrained('purchase_bills')->onDelete('cascade');
            $table->unsignedBigInteger('item_id')->nullable(); // Can be consumable or non-consumable
            $table->string('item_name')->nullable();
            $table->string('item_unit')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('sale_price', 15, 2)->default(0);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('discount_value', 15, 2)->default(0);
            $table->string('discount_type')->nullable(); // percentage or fixed
            $table->decimal('item_total', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_bill_items');
    }
};
