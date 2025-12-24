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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // General, Welfare, etc.
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('speciality_id')->nullable()->constrained('specialities')->nullOnDelete();
            $table->string('room_location')->nullable();
            $table->string('name');
            $table->string('performed_for')->nullable(); // OPD, Indoor, etc.
            $table->decimal('general_normal_fee', 15, 2)->default(0);
            $table->decimal('general_emergency_fee', 15, 2)->default(0);
            $table->decimal('welfare_normal_fee', 15, 2)->default(0);
            $table->decimal('welfare_emergency_fee', 15, 2)->default(0);
            $table->decimal('general_normal_doctor_percentage', 5, 2)->default(0);
            $table->decimal('general_emergency_doctor_percentage', 5, 2)->default(0);
            $table->decimal('welfare_normal_doctor_percentage', 5, 2)->default(0);
            $table->decimal('welfare_emergency_doctor_percentage', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
