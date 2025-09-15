<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'supervisor_id',
        'student_id', 
        'supervise_type',
        'supervise_id',
        'status',
        'supervisor_notes',
        'feedback_points',
        'grade',
        'viewed_at',
        'reviewed_at',
        'approved_at',
        'requires_revision',
        'revision_notes',
        'competency_assessment',
    ];

    protected $casts = [
        'feedback_points' => 'array',
        'competency_assessment' => 'array',
        'viewed_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'requires_revision' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the supervised record (polymorphic-like behavior)
     */
    public function getSupervisedRecord()
    {
        switch ($this->supervise_type) {
            case 'assessment':
                return Assessment::find($this->supervise_id);
            case 'diagnosis':
                return NursingDiagnosis::find($this->supervise_id);
            case 'intervention':
                return NursingIntervention::find($this->supervise_id);
            case 'implementation':
                return Implementation::find($this->supervise_id);
            case 'evaluation':
                return Evaluation::find($this->supervise_id);
            default:
                return null;
        }
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan tipe supervisi
     */
    public function scopeByType($query, $type)
    {
        return $query->where('supervise_type', $type);
    }

    /**
     * Scope untuk supervisor tertentu
     */
    public function scopeBySupervisor($query, $supervisorId)
    {
        return $query->where('supervisor_id', $supervisorId);
    }

    /**
     * Scope untuk student tertentu
     */
    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Mark as viewed
     */
    public function markAsViewed()
    {
        $this->update([
            'status' => 'viewed',
            'viewed_at' => now(),
        ]);
    }

    /**
     * Mark as reviewed with feedback
     */
    public function markAsReviewed($notes = null, $feedbackPoints = null, $grade = null)
    {
        $this->update([
            'status' => 'reviewed',
            'reviewed_at' => now(),
            'supervisor_notes' => $notes,
            'feedback_points' => $feedbackPoints,
            'grade' => $grade,
        ]);
    }

    /**
     * Approve the supervised work
     */
    public function approve($notes = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'supervisor_notes' => $notes,
            'requires_revision' => false,
        ]);
    }

    /**
     * Request revision
     */
    public function requestRevision($revisionNotes)
    {
        $this->update([
            'status' => 'needs_revision',
            'requires_revision' => true,
            'revision_notes' => $revisionNotes,
        ]);
    }

    /**
     * Reject the work
     */
    public function reject($notes)
    {
        $this->update([
            'status' => 'rejected',
            'supervisor_notes' => $notes,
        ]);
    }
}
