<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('procedures', function (Blueprint $table) {
          

            // Add the new columns
            $table->decimal('general_normal_doctor_percentage', 5, 2)->default(0)->after('welfare_emergency_fee');
            $table->decimal('general_emergency_doctor_percentage', 5, 2)->default(0)->after('general_normal_doctor_percentage');
            $table->decimal('welfare_normal_doctor_percentage', 5, 2)->default(0)->after('general_emergency_doctor_percentage');
            $table->decimal('welfare_emergency_doctor_percentage', 5, 2)->default(0)->after('welfare_normal_doctor_percentage');
        });
    }

   
    
};