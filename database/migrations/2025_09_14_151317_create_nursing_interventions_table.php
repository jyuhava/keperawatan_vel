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
        Schema::create('nursing_interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nursing_diagnosis_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Student who created the intervention
            $table->string('siki_code')->nullable(); // SIKI intervention code
            $table->string('intervention_title');
            $table->text('definition');
            $table->json('activities'); // Specific nursing activities
            $table->json('expected_outcomes'); // SLKI outcomes
            $table->json('outcome_criteria'); // Measurable criteria
            $table->enum('frequency', ['once', 'daily', 'twice_daily', 'three_times_daily', 'four_times_daily', 'as_needed', 'continuous']);
            $table->time('scheduled_time')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->enum('status', ['planned', 'in_progress', 'completed', 'discontinued'])->default('planned');
            $table->text('rationale');
            $table->text('special_instructions')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nursing_interventions');
    }
};
