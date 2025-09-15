<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Assessment;
use App\Models\Implementation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupervisionController extends Controller
{
    /**
     * Monitor student progress and activities
     */
    public function monitorStudents()
    {
        // Get all students with their recent activities
        $students = User::where('role', 'mahasiswa')
            ->with([
                'patients' => function($query) {
                    $query->latest()->take(5);
                },
                'assessments' => function($query) {
                    $query->latest()->take(3);
                },
                'implementations' => function($query) {
                    $query->with(['nursingIntervention.nursingDiagnosis.patient'])
                          ->latest()->take(3);
                }
            ])
            ->get();

        // Get statistics
        $stats = [
            'total_students' => User::where('role', 'mahasiswa')->count(),
            'active_patients' => Patient::count(),
            'recent_assessments' => Assessment::where('created_at', '>=', now()->subWeek())->count(),
            'pending_evaluations' => Implementation::count() // Simplified for now
        ];

        // Get recent student activities using Eloquent relationships
        $recentActivities = Implementation::with([
                'user:id,name,student_id',
                'nursingIntervention.nursingDiagnosis.patient:id,name'
            ])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($implementation) {
                return (object) [
                    'id' => $implementation->id,
                    'student_name' => $implementation->user->name,
                    'student_id' => $implementation->user->student_id,
                    'patient_name' => $implementation->nursingIntervention->nursingDiagnosis->patient->name ?? 'N/A',
                    'action_type' => $implementation->completion_status,
                    'intervention_title' => $implementation->nursingIntervention->intervention_title ?? 'N/A',
                    'created_at' => $implementation->created_at,
                ];
            });

        return view('supervision.monitor-students', compact('students', 'stats', 'recentActivities'));
    }
}
