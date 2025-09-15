<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'student_id',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Role-based helper methods
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }
    
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }
    
    /**
     * Relationships
     */
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
    
    public function nursingDiagnoses()
    {
        return $this->hasMany(NursingDiagnosis::class);
    }
    
    public function nursingInterventions()
    {
        return $this->hasMany(NursingIntervention::class);
    }
    
    public function implementations()
    {
        return $this->hasMany(Implementation::class);
    }
    
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
    
    public function supervisedEvaluations()
    {
        return $this->hasMany(Evaluation::class, 'supervisor_id');
    }
}
