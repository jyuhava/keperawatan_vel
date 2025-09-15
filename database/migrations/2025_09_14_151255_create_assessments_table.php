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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Student who created the assessment
            $table->json('vital_signs'); // Blood pressure, temperature, pulse, respiration, etc.
            $table->text('physical_examination')->nullable();
            $table->text('mental_status')->nullable();
            $table->text('pain_assessment')->nullable();
            $table->text('nutritional_status')->nullable();
            $table->text('skin_condition')->nullable();
            $table->text('mobility_status')->nullable();
            $table->text('respiratory_status')->nullable();
            $table->text('cardiovascular_status')->nullable();
            $table->text('neurological_status')->nullable();
            $table->text('gastrointestinal_status')->nullable();
            $table->text('genitourinary_status')->nullable();
            $table->text('psychosocial_assessment')->nullable();
            $table->text('spiritual_assessment')->nullable();
            $table->text('family_support')->nullable();
            $table->text('discharge_planning')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
