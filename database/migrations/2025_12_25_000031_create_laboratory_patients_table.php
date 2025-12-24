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
        Schema::create('laboratory_patients', function (Blueprint $table) {
            $table->id();
            $table->string('mr_no')->nullable();
            $table->string('patient_name');
            $table->string('gender')->nullable();
            $table->string('contact_no')->nullable();
            $table->integer('age')->nullable();
            $table->string('file_no')->nullable();
            $table->string('priority')->nullable();
            $table->boolean('self_referred')->default(false);
            $table->string('refer_by_doctor_name')->nullable();
            $table->json('selected_tests')->nullable();
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('due_amount', 15, 2)->default(0);
            $table->decimal('previous_due', 15, 2)->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_patients');
    }
};
