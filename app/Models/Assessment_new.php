<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'vital_signs',
        'physical_examination',
        'mental_status',
        'pain_assessment',
        'nutritional_status',
        'skin_condition',
        'mobility_status',
        'respiratory_status',
        'cardiovascular_status',
        'neurological_status',
        'gastrointestinal_status',
        'genitourinary_status',
        'psychosocial_assessment',
        'spiritual_assessment',
        'family_support',
        'discharge_planning',
        'notes',
    ];

    protected $casts = [
        'vital_signs' => 'array',
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
}
