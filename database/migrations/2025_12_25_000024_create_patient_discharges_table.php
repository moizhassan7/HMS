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
        Schema::create('patient_discharges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indoor_patient_id')->constrained('indoor_patients')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('discharge_date')->nullable();
            $table->time('discharge_time')->nullable();
            $table->string('discharge_status')->nullable();
            $table->text('discharge_summary')->nullable();
            $table->text('medication_at_discharge')->nullable();
            $table->text('follow_up_instructions')->nullable();
            $table->foreignId('certifying_doctor_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->string('payment_clearance_status')->nullable();
            $table->text('cause')->nullable();
            $table->boolean('is_anesthesia')->default(false);
            $table->string('anesthesia_type')->nullable();
            $table->json('diagnoses')->nullable();
            $table->json('consultants')->nullable();
            $table->decimal('total_bill', 15, 2)->default(0);
            $table->decimal('admission_fee', 15, 2)->default(0);
            $table->decimal('advance_fee', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('amount_receivable', 15, 2)->default(0);
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->decimal('current_remaining', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_discharges');
    }
};
