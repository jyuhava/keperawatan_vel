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
        Schema::create('nursing_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Student who created the diagnosis
            $table->string('sdki_code')->nullable(); // SDKI diagnosis code
            $table->string('diagnosis_title');
            $table->text('definition');
            $table->json('signs_symptoms'); // Subjective and objective data
            $table->json('related_factors')->nullable(); // Contributing factors
            $table->json('risk_factors')->nullable(); // For risk diagnoses
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->enum('status', ['active', 'resolved', 'inactive'])->default('active');
            $table->date('date_identified');
            $table->date('target_date')->nullable();
            $table->text('rationale');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nursing_diagnoses');
    }
};
