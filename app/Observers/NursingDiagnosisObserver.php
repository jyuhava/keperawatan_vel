<?php

namespace App\Observers;

use App\Models\NursingDiagnosis;
use App\Models\SupervisionLog;
use App\Models\User;

class NursingDiagnosisObserver
{
    public function created(NursingDiagnosis $diagnosis): void
    {
        $this->createSupervisionLog($diagnosis);
    }

    public function updated(NursingDiagnosis $diagnosis): void
    {
        SupervisionLog::where('supervise_type', 'diagnosis')
            ->where('supervise_id', $diagnosis->id)
            ->where('status', '!=', 'viewed')
            ->update(['status' => 'viewed', 'viewed_at' => null]);
    }

    private function createSupervisionLog(NursingDiagnosis $diagnosis)
    {
        $supervisors = User::where('role', 'dosen')->pluck('id');
        
        if ($supervisors->isNotEmpty()) {
            SupervisionLog::create([
                'supervisor_id' => $supervisors->first(),
                'student_id' => $diagnosis->user_id,
                'supervise_type' => 'diagnosis',
                'supervise_id' => $diagnosis->id,
                'status' => 'viewed',
                'viewed_at' => now(),
            ]);
        }
    }
}
