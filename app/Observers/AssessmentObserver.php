<?php

namespace App\Observers;

use App\Models\Assessment;
use App\Models\SupervisionLog;
use App\Models\User;

class AssessmentObserver
{
    /**
     * Handle the Assessment "created" event.
     */
    public function created(Assessment $assessment): void
    {
        // Create supervision log when new assessment is created
        $this->createSupervisionLog($assessment);
    }

    /**
     * Handle the Assessment "updated" event.
     */
    public function updated(Assessment $assessment): void
    {
        // Update viewed status when assessment is modified
        SupervisionLog::where('supervise_type', 'assessment')
            ->where('supervise_id', $assessment->id)
            ->where('status', '!=', 'viewed')
            ->update(['status' => 'viewed', 'viewed_at' => null]);
    }

    private function createSupervisionLog(Assessment $assessment)
    {
        // Find available supervisors (dosen role)
        $supervisors = User::where('role', 'dosen')->pluck('id');
        
        // For now, assign to first available supervisor
        // In the future, you could implement more sophisticated assignment logic
        if ($supervisors->isNotEmpty()) {
            SupervisionLog::create([
                'supervisor_id' => $supervisors->first(),
                'student_id' => $assessment->user_id,
                'supervise_type' => 'assessment',
                'supervise_id' => $assessment->id,
                'status' => 'viewed',
                'viewed_at' => now(),
            ]);
        }
    }
}
