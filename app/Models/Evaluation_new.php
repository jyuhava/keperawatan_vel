<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nursing_intervention_id',
        'user_id',
        'supervisor_id',
        'evaluation_date',
        'outcome_achievement',
        'slki_indicators',
        'progress_notes',
        'overall_progress',
        'barriers_identified',
        'patient_satisfaction',
        'family_feedback',
        'modifications_needed',
        'continuing_care_needs',
        'discharge_recommendations',
        'student_analysis',
        'supervisor_feedback',
        'supervisor_grade',
        'learning_outcomes',
        'areas_for_improvement',
        'notes',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'outcome_achievement' => 'array',
        'slki_indicators' => 'array',
        'modifications_needed' => 'array',
    ];

    /**
     * Relationships
     */
    public function nursingIntervention()
    {
        return $this->belongsTo(NursingIntervention::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
