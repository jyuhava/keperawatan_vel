<?php

namespace App\Observers;

use App\Models\Implementation;
use App\Models\SupervisionLog;
use App\Models\User;

class ImplementationObserver
{
    public function created(Implementation $implementation): void
    {
        $this->createSupervisionLog($implementation);
    }

    public function updated(Implementation $implementation): void
    {
        SupervisionLog::where('supervise_type', 'implementation')
            ->where('supervise_id', $implementation->id)
            ->where('status', '!=', 'viewed')
            ->update(['status' => 'viewed', 'viewed_at' => null]);
    }

    private function createSupervisionLog(Implementation $implementation)
    {
        $supervisors = User::where('role', 'dosen')->pluck('id');
        
        if ($supervisors->isNotEmpty()) {
            SupervisionLog::create([
                'supervisor_id' => $supervisors->first(),
                'student_id' => $implementation->user_id,
                'supervise_type' => 'implementation',
                'supervise_id' => $implementation->id,
                'status' => 'viewed',
                'viewed_at' => now(),
            ]);
        }
    }
}
