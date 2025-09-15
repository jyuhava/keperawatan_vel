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
        Schema::create('implementations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nursing_intervention_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Student who performed the implementation
            $table->datetime('implementation_datetime');
            $table->json('activities_performed'); // Which activities were completed
            $table->text('method_used')->nullable(); // How the intervention was performed
            $table->text('patient_response')->nullable(); // Patient's response to intervention
            $table->json('vital_signs_post')->nullable(); // Vital signs after intervention if applicable
            $table->text('complications')->nullable(); // Any complications encountered
            $table->enum('completion_status', ['completed', 'partially_completed', 'not_completed']);
            $table->text('reason_not_completed')->nullable();
            $table->text('modifications_made')->nullable(); // Any changes to the original plan
            $table->text('follow_up_needed')->nullable(); // What follow-up is required
            $table->text('student_reflection')->nullable(); // Student's reflection on the implementation
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('implementations');
    }
};
