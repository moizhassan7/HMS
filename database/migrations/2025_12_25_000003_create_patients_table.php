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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('mr_number');
            $table->string('patient_type');
            $table->date('registration_date');
            $table->string('name');
            $table->string('marital_status');
            $table->date('date_of_birth');
            $table->string('relation_type');
            $table->string('guardian_name');
            $table->string('guardian_cnic');
            $table->integer('age');
            $table->boolean('is_welfare');
            $table->float('weight');
            $table->string('gender');
            $table->string('email');
            $table->string('cnic');
            $table->text('address');
            $table->string('mobile_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};