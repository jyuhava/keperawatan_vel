<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Implementation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nursing_intervention_id',
        'user_id',
        'implementation_datetime',
        'activities_performed',
        'method_used',
        'patient_response',
        'vital_signs_post',
        'complications',
        'completion_status',
        'reason_not_completed',
        'modifications_made',
        'follow_up_needed',
        'student_reflection',
        'notes',
    ];

    protected $casts = [
        'implementation_datetime' => 'datetime',
        'activities_performed' => 'array',
        'vital_signs_post' => 'array',
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
}
