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
        Schema::create('opd_appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_number')->nullable();
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();
            $table->string('mr_number')->nullable();
            $table->string('patient_name')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('doctor_code')->nullable();
            $table->string('doctor_name')->nullable();
            $table->decimal('doctor_fee', 15, 2)->default(0);
            $table->string('referred_by')->nullable();
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->string('token_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_appointments');
    }
};
