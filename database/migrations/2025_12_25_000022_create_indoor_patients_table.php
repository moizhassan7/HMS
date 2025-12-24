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
        Schema::create('indoor_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('mr_no')->nullable();
            $table->string('file_no')->nullable();
            $table->string('slip_no')->nullable();
            $table->dateTime('registration_date')->nullable();
            $table->string('admission_type')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable(); // Assuming ward is a room with is_ward=true
            $table->unsignedBigInteger('room_id')->nullable();
            $table->string('bed_no')->nullable();
            $table->decimal('admission_fee', 15, 2)->default(0);
            $table->decimal('advance_fee', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->foreignId('consultant_id')->nullable()->constrained('doctors')->nullOnDelete();
            $table->boolean('is_operation')->default(false);
            $table->date('operation_date')->nullable();
            $table->boolean('is_discharged')->default(false);
            $table->date('discharge_date')->nullable();
            $table->time('discharge_time')->nullable();
            $table->string('discharge_status')->nullable();
            $table->timestamps();

            // FK constraints for ward/room if needed, but might be polymorphic or just IDs
            // $table->foreign('ward_id')->references('id')->on('rooms');
            // $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indoor_patients');
    }
};
