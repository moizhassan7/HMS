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
        Schema::create('day_care_procedures', function (Blueprint $table) {
            $table->id();
            $table->string('mr_number');
            $table->string('patient_name');
            $table->integer('age');
            $table->string('gender');
            $table->string('procedure_id'); // This is not unique; it's a group ID
            $table->string('single_procedure_name'); // Added this column
            $table->enum('procedure_type', ['MAJOR', 'MINOR']);
            $table->decimal('fee', 10, 2);
            $table->boolean('is_operation')->default(false);
            $table->string('department_name')->nullable();
            $table->string('department_consultant_name')->nullable();
            $table->string('anesthesia_type')->nullable();
            $table->decimal('duration_in_hours', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_care_procedures');
    }
};