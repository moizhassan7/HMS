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
        // Global Medicine List
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('generic_name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->timestamps();
        });

        // Pharmacy Stocks
        Schema::create('pharmacy_stocks', function (Blueprint $table) {
            $table->id();
            // Linking to medicines table, but also keeping medicine_name as per requirement flexibility
            $table->foreignId('medicine_id')->nullable()->constrained('medicines')->onDelete('cascade');
            $table->string('medicine_name'); 
            $table->string('batch_number');
            $table->integer('quantity_available');
            $table->date('expiry_date');
            $table->decimal('price_per_unit', 10, 2);
            $table->timestamps();
        });

        // Radiology Procedures (Tests)
        Schema::create('radiology_procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2)->default(0);
            $table->timestamps();
        });

        // Prescriptions
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('visit_date');
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        // Prescription Medicines
        Schema::create('prescription_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->string('dosage')->nullable();
            $table->string('duration')->nullable();
            $table->text('instruction')->nullable();
            $table->enum('dispense_status', ['pending', 'dispensed'])->default('pending');
            $table->timestamps();
        });

        // Prescription Tests (Polymorphic-ish or Type based)
        Schema::create('prescription_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            // test_id can refer to 'tests' table (Pathology) or 'radiology_procedures' table (Radiology)
            $table->unsignedBigInteger('test_id'); 
            $table->enum('type', ['pathology', 'radiology']);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        // Radiology Results
        Schema::create('radiology_results', function (Blueprint $table) {
            $table->id();
            // Links to the specific test request in prescription_tests
            $table->foreignId('prescription_test_id')->constrained('prescription_tests')->onDelete('cascade');
            $table->foreignId('radiologist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('report_text')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiology_results');
        Schema::dropIfExists('prescription_tests');
        Schema::dropIfExists('prescription_medicines');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('radiology_procedures');
        Schema::dropIfExists('pharmacy_stocks');
        Schema::dropIfExists('medicines');
    }
};
