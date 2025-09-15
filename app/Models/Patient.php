<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medical_record_number',
        'name',
        'gender',
        'date_of_birth',
        'address',
        'phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_history',
        'allergies',
        'current_medications',
        'admission_date',
        'discharge_date',
        'status',
        'room_number',
        'chief_complaint',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'discharge_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function nursingDiagnoses()
    {
        return $this->hasMany(NursingDiagnosis::class);
    }

    /**
     * Helper methods
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function getDaysAdmittedAttribute()
    {
        if ($this->status === 'discharged' && $this->discharge_date) {
            return Carbon::parse($this->admission_date)->diffInDays(Carbon::parse($this->discharge_date));
        }
        return Carbon::parse($this->admission_date)->diffInDays(Carbon::now());
    }
}
