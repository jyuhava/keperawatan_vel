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
        Schema::create('supervision_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supervisor_id')->constrained('users')->onDelete('cascade'); // Dosen
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Mahasiswa
            $table->string('supervise_type'); // 'assessment', 'diagnosis', 'intervention', 'implementation', 'evaluation'
            $table->unsignedBigInteger('supervise_id'); // ID dari record yang disupervisi
            $table->enum('status', ['viewed', 'reviewed', 'needs_revision', 'approved', 'rejected'])->default('viewed');
            $table->text('supervisor_notes')->nullable();
            $table->json('feedback_points')->nullable(); // Structured feedback
            $table->integer('grade')->nullable(); // 0-100
            $table->datetime('viewed_at')->nullable();
            $table->datetime('reviewed_at')->nullable(); 
            $table->datetime('approved_at')->nullable();
            $table->boolean('requires_revision')->default(false);
            $table->text('revision_notes')->nullable();
            $table->json('competency_assessment')->nullable(); // Penilaian kompetensi
            $table->timestamps();

            // Index for faster queries
            $table->index(['supervisor_id', 'student_id']);
            $table->index(['supervise_type', 'supervise_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervision_logs');
    }
};
