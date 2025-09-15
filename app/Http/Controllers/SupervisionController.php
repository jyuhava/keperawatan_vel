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
                    $query->latest()->take(3);
                }
            ])
            ->get();

        // Get statistics
        $stats = [
            'total_students' => User::where('role', 'mahasiswa')->count(),
            'active_patients' => Patient::count(),
            'recent_assessments' => Assessment::where('created_at', '>=', now()->subWeek())->count(),
            'pending_evaluations' => Implementation::whereNull('evaluation_id')->count()
        ];

        // Get recent student activities
        $recentActivities = DB::table('implementations')
            ->join('users', 'implementations.user_id', '=', 'users.id')
            ->join('patients', 'implementations.patient_id', '=', 'patients.id')
            ->select(
                'implementations.*',
                'users.name as student_name',
                'users.student_id',
                'patients.name as patient_name'
            )
            ->latest('implementations.created_at')
            ->take(10)
            ->get();

        return view('supervision.monitor-students', compact('students', 'stats', 'recentActivities'));
    }
}
