<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursingDiagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'sdki_code',
        'diagnosis_title',
        'definition',
        'signs_symptoms',
        'related_factors',
        'risk_factors',
        'priority',
        'status',
        'date_identified',
        'target_date',
        'rationale',
        'notes',
    ];

    protected $casts = [
        'signs_symptoms' => 'array',
        'related_factors' => 'array',
        'risk_factors' => 'array',
        'date_identified' => 'date',
        'target_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nursingInterventions()
    {
        return $this->hasMany(NursingIntervention::class);
    }
}
