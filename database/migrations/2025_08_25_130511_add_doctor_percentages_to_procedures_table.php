<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
            // Remove the old column
            $table->dropColumn('doctor_percentage');

            // Add the new columns
            $table->decimal('general_normal_doctor_percentage', 5, 2)->default(0)->after('welfare_emergency_fee');
            $table->decimal('general_emergency_doctor_percentage', 5, 2)->default(0)->after('general_normal_doctor_percentage');
            $table->decimal('welfare_normal_doctor_percentage', 5, 2)->default(0)->after('general_emergency_doctor_percentage');
            $table->decimal('welfare_emergency_doctor_percentage', 5, 2)->default(0)->after('welfare_normal_doctor_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
            // Re-add the old column if you ever need to rollback
            $table->decimal('doctor_percentage', 5, 2)->default(0);

            // Remove the new columns
            $table->dropColumn([
                'general_normal_doctor_percentage',
                'general_emergency_doctor_percentage',
                'welfare_normal_doctor_percentage',
                'welfare_emergency_doctor_percentage'
            ]);
        });
    }
};