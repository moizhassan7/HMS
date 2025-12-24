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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('test_id')->nullable(); // Custom ID string
            $table->string('name');
            $table->decimal('price', 15, 2)->default(0);
            $table->string('type')->nullable();
            $table->foreignId('test_head_id')->nullable()->constrained('test_heads')->nullOnDelete();
            $table->integer('priority')->default(0);
            $table->string('report_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
