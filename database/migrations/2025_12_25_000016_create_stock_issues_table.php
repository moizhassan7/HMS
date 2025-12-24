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
        Schema::create('stock_issues', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->date('issue_date')->nullable();
            $table->time('issue_time')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('employee_department')->nullable();
            $table->string('employee_designation')->nullable();
            $table->integer('total_issued_quantity')->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_issues');
    }
};
