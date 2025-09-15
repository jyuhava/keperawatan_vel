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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nursing_intervention_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Student who performed evaluation
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('set null'); // Supervising teacher
            $table->date('evaluation_date');
            $table->json('outcome_achievement'); // Achievement status for each expected outcome
            $table->json('slki_indicators'); // SLKI indicator measurements
            $table->text('progress_notes'); // Progress toward goals
            $table->enum('overall_progress', ['exceeded', 'met', 'partially_met', 'not_met']);
            $table->text('barriers_identified')->nullable(); // Barriers to goal achievement
            $table->text('patient_satisfaction')->nullable(); // Patient feedback
            $table->text('family_feedback')->nullable(); // Family input
            $table->json('modifications_needed')->nullable(); // Changes needed to plan
            $table->text('continuing_care_needs')->nullable(); // Ongoing care requirements
            $table->text('discharge_recommendations')->nullable(); // Discharge planning updates
            $table->text('student_analysis')->nullable(); // Student's critical thinking
            $table->text('supervisor_feedback')->nullable(); // Teacher's comments and grades
            $table->integer('supervisor_grade')->nullable(); // Numerical grade from supervisor
            $table->text('learning_outcomes')->nullable(); // What student learned
            $table->text('areas_for_improvement')->nullable(); // Areas student needs to work on
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
