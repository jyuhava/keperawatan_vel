<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Assessment;
use App\Models\NursingDiagnosis;
use App\Models\NursingIntervention;
use App\Models\Implementation;
use App\Models\Evaluation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'patients' => $this->getPatientStats($user),
            'assessments' => $this->getAssessmentStats($user),
            'diagnoses' => $this->getDiagnosisStats($user),
            'interventions' => $this->getInterventionStats($user),
            'implementations' => $this->getImplementationStats($user),
            'evaluations' => $this->getEvaluationStats($user),
        ];

        // Additional stats for admin
        if ($user->isAdmin()) {
            $stats['users'] = [
                'total' => User::count(),
                'students' => User::where('role', 'mahasiswa')->count(),
                'teachers' => User::where('role', 'dosen')->count(),
                'admins' => User::where('role', 'admin')->count(),
            ];
        }

        // Recent activities based on role
        $recentActivities = $this->getRecentActivities($user);

        return view('dashboard', compact('stats', 'recentActivities'));
    }

    public function admin()
    {
        // Ensure user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access to admin dashboard.');
        }

        // Admin specific statistics
        $adminStats = [
            'total_users' => User::count(),
            'active_students' => User::where('role', 'mahasiswa')->where('is_active', true)->count(),
            'total_patients' => Patient::count(),
            'system_health' => $this->calculateSystemHealth(),
            'recent_activities' => $this->getAdminRecentActivities(),
            'user_growth' => $this->getUserGrowthStats(),
            'popular_diagnoses' => $this->getPopularDiagnoses(),
            'system_status' => $this->getSystemStatus(),
        ];

        return view('admin-dashboard', compact('adminStats'));
    }

    private function getPatientStats($user)
    {
        $query = Patient::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        return [
            'total' => $query->count(),
            'active' => $query->where('status', 'active')->count(),
            'discharged' => $query->where('status', 'discharged')->count(),
        ];
    }

    private function getAssessmentStats($user)
    {
        $query = Assessment::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        return [
            'total' => $query->count(),
            'this_month' => $query->whereMonth('created_at', now()->month)->count(),
        ];
    }

    private function getDiagnosisStats($user)
    {
        $query = NursingDiagnosis::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        return [
            'total' => $query->count(),
            'active' => $query->where('status', 'active')->count(),
            'high_priority' => $query->where('priority', 'high')->count(),
        ];
    }

    private function getInterventionStats($user)
    {
        $query = NursingIntervention::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        return [
            'total' => $query->count(),
            'in_progress' => $query->where('status', 'in_progress')->count(),
            'completed' => $query->where('status', 'completed')->count(),
        ];
    }

    private function getImplementationStats($user)
    {
        $query = Implementation::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        return [
            'total' => $query->count(),
            'completed' => $query->where('completion_status', 'completed')->count(),
            'today' => $query->whereDate('implementation_datetime', today())->count(),
        ];
    }

    private function getEvaluationStats($user)
    {
        $query = Evaluation::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        } elseif ($user->isDosen()) {
            $query->where('supervisor_id', $user->id);
        }
        
        return [
            'total' => $query->count(),
            'pending_feedback' => $query->whereNull('supervisor_feedback')->count(),
            'this_week' => $query->whereBetween('evaluation_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
        ];
    }

    private function calculateSystemHealth()
    {
        // Simple system health calculation
        $factors = [
            'database' => $this->checkDatabaseHealth(),
            'storage' => $this->checkStorageHealth(),
            'users' => $this->checkUserActivity(),
        ];

        $healthScore = array_sum($factors) / count($factors) * 100;
        return round($healthScore, 1);
    }

    private function checkDatabaseHealth()
    {
        try {
            // Simple database connectivity check
            User::count();
            return 1.0;
        } catch (\Exception $e) {
            return 0.0;
        }
    }

    private function checkStorageHealth()
    {
        // Simulate storage check
        return 0.9; // 90% health
    }

    private function checkUserActivity()
    {
        $activeUsers = User::where('updated_at', '>=', now()->subDays(7))->count();
        $totalUsers = User::count();
        
        return $totalUsers > 0 ? $activeUsers / $totalUsers : 1.0;
    }

    private function getAdminRecentActivities()
    {
        // Get recent activities across the system
        $activities = collect();
        
        // Recent user registrations
        $recentUsers = User::latest()->take(5)->get();
        foreach ($recentUsers as $user) {
            $activities->push([
                'type' => 'user_registered',
                'user' => $user->name,
                'action' => 'registered to the system',
                'target' => 'Role: ' . ucfirst($user->role),
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'person-add',
                'color' => 'green'
            ]);
        }

        // Recent patient records
        $recentPatients = Patient::with('user')->latest()->take(5)->get();
        foreach ($recentPatients as $patient) {
            $activities->push([
                'type' => 'patient_created',
                'user' => $patient->user->name ?? 'Unknown',
                'action' => 'created patient record',
                'target' => $patient->name,
                'time' => $patient->created_at->diffForHumans(),
                'icon' => 'medical',
                'color' => 'blue'
            ]);
        }

        return $activities->sortByDesc('time')->take(10)->values();
    }

    private function getUserGrowthStats()
    {
        return [
            'this_month' => User::whereMonth('created_at', now()->month)->count(),
            'last_month' => User::whereMonth('created_at', now()->subMonth()->month)->count(),
            'growth_rate' => $this->calculateGrowthRate()
        ];
    }

    private function calculateGrowthRate()
    {
        $thisMonth = User::whereMonth('created_at', now()->month)->count();
        $lastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();
        
        if ($lastMonth == 0) return 0;
        
        return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1);
    }

    private function getPopularDiagnoses()
    {
        return NursingDiagnosis::select('diagnosis_name')
            ->selectRaw('COUNT(*) as usage_count')
            ->groupBy('diagnosis_name')
            ->orderByDesc('usage_count')
            ->take(5)
            ->get();
    }

    private function getSystemStatus()
    {
        return [
            'server' => 'online',
            'database' => 'healthy',
            'storage' => '78% used',
            'backup' => 'completed 2h ago',
            'performance' => 94
        ];
    }

    private function getRecentActivities($user)
    {
        $activities = collect();

        if ($user->isMahasiswa()) {
            // Recent patient additions
            $recentPatients = Patient::where('user_id', $user->id)
                ->latest()
                ->take(3)
                ->get();
            
            foreach ($recentPatients as $patient) {
                $activities->push([
                    'type' => 'patient_added',
                    'description' => "Added patient: {$patient->name}",
                    'date' => $patient->created_at,
                    'icon' => 'person-add',
                    'color' => 'blue',
                ]);
            }

            // Recent implementations
            $recentImplementations = Implementation::where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->with('nursingIntervention')
                ->get();
            
            foreach ($recentImplementations as $implementation) {
                $activities->push([
                    'type' => 'implementation',
                    'description' => "Implemented: {$implementation->nursingIntervention->intervention_title}",
                    'date' => $implementation->created_at,
                    'icon' => 'clipboard',
                    'color' => 'green',
                ]);
            }
        } elseif ($user->isDosen()) {
            // Recent evaluations to review
            $pendingEvaluations = Evaluation::where('supervisor_id', $user->id)
                ->whereNull('supervisor_feedback')
                ->latest()
                ->take(5)
                ->with('user', 'nursingIntervention')
                ->get();
            
            foreach ($pendingEvaluations as $evaluation) {
                $activities->push([
                    'type' => 'evaluation_pending',
                    'description' => "Pending review from {$evaluation->user->name}",
                    'date' => $evaluation->created_at,
                    'icon' => 'document-text',
                    'color' => 'yellow',
                ]);
            }
        }

        return $activities->sortByDesc('date')->take(10);
    }
}
