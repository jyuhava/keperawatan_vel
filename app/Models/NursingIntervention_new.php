<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursingIntervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'nursing_diagnosis_id',
        'user_id',
        'siki_code',
        'intervention_title',
        'definition',
        'activities',
        'expected_outcomes',
        'outcome_criteria',
        'frequency',
        'scheduled_time',
        'start_date',
        'end_date',
        'priority',
        'status',
        'rationale',
        'special_instructions',
        'notes',
    ];

    protected $casts = [
        'activities' => 'array',
        'expected_outcomes' => 'array',
        'outcome_criteria' => 'array',
        'scheduled_time' => 'datetime:H:i',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function nursingDiagnosis()
    {
        return $this->belongsTo(NursingDiagnosis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function implementations()
    {
        return $this->hasMany(Implementation::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
