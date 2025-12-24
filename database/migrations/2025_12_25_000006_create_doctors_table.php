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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('type');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('speciality_id')->constrained('specialities');
            $table->string('room_location');
            $table->string('employee_group');
            $table->json('working_days');
            $table->text('address');
            $table->string('mobile_number');
            $table->string('office_phone');
            $table->string('reception_phone');
            $table->string('accounts_of');
            $table->float('fee');
            $table->string('picture')->nullable();
            $table->boolean('is_active');
            $table->float('general_normal_fee');
            $table->float('general_emergency_fee');
            $table->float('welfare_normal_fee');
            $table->float('welfare_emergency_fee');
            $table->float('general_normal_percentage');
            $table->float('general_emergency_percentage');
            $table->float('welfare_normal_percentage');
            $table->float('welfare_emergency_percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};