<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Assessment;
use App\Models\Implementation;
use App\Models\SupervisionLog;
use App\Models\NursingDiagnosis;
use App\Models\NursingIntervention;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Advanced supervision dashboard for teachers
     */
    public function supervisionDashboard()
    {
        $supervisorId = Auth::id();
        
        // Get supervision statistics
        $stats = [
            'total_supervised' => SupervisionLog::bySupervisor($supervisorId)->count(),
            'pending_reviews' => SupervisionLog::bySupervisor($supervisorId)->byStatus('viewed')->count(),
            'needs_revision' => SupervisionLog::bySupervisor($supervisorId)->byStatus('needs_revision')->count(),
            'approved_today' => SupervisionLog::bySupervisor($supervisorId)->byStatus('approved')
                ->whereDate('approved_at', today())->count(),
        ];

        // Get items needing attention (viewed but not reviewed)
        $pendingItems = SupervisionLog::with(['student', 'supervisor'])
            ->bySupervisor($supervisorId)
            ->byStatus('viewed')
            ->latest('viewed_at')
            ->take(10)
            ->get()
            ->map(function ($log) {
                $record = $log->getSupervisedRecord();
                return (object) [
                    'id' => $log->id,
                    'student_name' => $log->student->name,
                    'student_id' => $log->student->student_id,
                    'type' => ucfirst($log->supervise_type),
                    'title' => $this->getRecordTitle($record, $log->supervise_type),
                    'viewed_at' => $log->viewed_at,
                    'supervise_type' => $log->supervise_type,
                    'supervise_id' => $log->supervise_id,
                ];
            });

        // Get recent supervision activities
        $recentActivities = SupervisionLog::with(['student'])
            ->bySupervisor($supervisorId)
            ->whereIn('status', ['reviewed', 'approved', 'rejected'])
            ->latest('updated_at')
            ->take(15)
            ->get();

        // Get students progress summary
        $studentProgress = $this->getStudentProgressSummary($supervisorId);

        return view('supervision.dashboard', compact('stats', 'pendingItems', 'recentActivities', 'studentProgress'));
    }

    /**
     * Get supervision details for specific item
     */
    public function supervisionDetail($logId)
    {
        $log = SupervisionLog::with(['student', 'supervisor'])->findOrFail($logId);
        
        // Ensure current user is the supervisor
        if ($log->supervisor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to supervision log.');
        }

        $record = $log->getSupervisedRecord();
        
        // Get additional context based on type
        $context = $this->getSupervisionContext($log, $record);
        
        return view('supervision.detail', compact('log', 'record', 'context'));
    }

    /**
     * Update supervision status and feedback
     */
    public function updateSupervision(Request $request, $logId)
    {
        $log = SupervisionLog::findOrFail($logId);
        
        // Ensure current user is the supervisor
        if ($log->supervisor_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'action' => 'required|in:review,approve,request_revision,reject',
            'supervisor_notes' => 'nullable|string',
            'feedback_points' => 'nullable|array',
            'grade' => 'nullable|integer|min:0|max:100',
            'revision_notes' => 'nullable|string',
            'competency_assessment' => 'nullable|array',
        ]);

        switch ($validated['action']) {
            case 'review':
                $log->markAsReviewed(
                    $validated['supervisor_notes'] ?? null,
                    $validated['feedback_points'] ?? null,
                    $validated['grade'] ?? null
                );
                break;
                
            case 'approve':
                $log->approve($validated['supervisor_notes'] ?? null);
                break;
                
            case 'request_revision':
                $log->requestRevision($validated['revision_notes'] ?? 'Revision diperlukan');
                break;
                
            case 'reject':
                $log->reject($validated['supervisor_notes'] ?? 'Ditolak');
                break;
        }

        // Update competency assessment if provided
        if (!empty($validated['competency_assessment'])) {
            $log->update(['competency_assessment' => $validated['competency_assessment']]);
        }

        return redirect()->route('supervision.dashboard')->with('success', 'Supervision updated successfully!');
    }

    /**
     * Get all supervision items for a specific student
     */
    public function studentSupervision($studentId)
    {
        $student = User::where('role', 'mahasiswa')->findOrFail($studentId);
        $supervisorId = Auth::id();
        
        $supervisionLogs = SupervisionLog::with(['supervisor'])
            ->byStudent($studentId)
            ->bySupervisor($supervisorId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get student statistics
        $studentStats = [
            'total_submissions' => $supervisionLogs->total(),
            'approved' => SupervisionLog::byStudent($studentId)->bySupervisor($supervisorId)->byStatus('approved')->count(),
            'pending' => SupervisionLog::byStudent($studentId)->bySupervisor($supervisorId)->byStatus('viewed')->count(),
            'needs_revision' => SupervisionLog::byStudent($studentId)->bySupervisor($supervisorId)->byStatus('needs_revision')->count(),
            'average_grade' => SupervisionLog::byStudent($studentId)->bySupervisor($supervisorId)->whereNotNull('grade')->avg('grade'),
        ];

        return view('supervision.student', compact('student', 'supervisionLogs', 'studentStats'));
    }

    /**
     * Helper method to get record title based on type
     */
    private function getRecordTitle($record, $type)
    {
        if (!$record) return 'Record not found';
        
        switch ($type) {
            case 'assessment':
                return $record->patient->name ?? 'Assessment';
            case 'diagnosis':
                return $record->diagnosis_title ?? 'Nursing Diagnosis';
            case 'intervention':
                return $record->intervention_title ?? 'Nursing Intervention';
            case 'implementation':
                return $record->nursingIntervention->intervention_title ?? 'Implementation';
            case 'evaluation':
                return $record->nursingIntervention->intervention_title ?? 'Evaluation';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get supervision context for detailed view
     */
    private function getSupervisionContext($log, $record)
    {
        $context = [];
        
        if ($record) {
            switch ($log->supervise_type) {
                case 'assessment':
                    $context['patient'] = $record->patient;
                    break;
                case 'diagnosis':
                    $context['patient'] = $record->patient;
                    $context['assessment'] = $record->patient->assessments()->latest()->first();
                    break;
                case 'intervention':
                    $context['diagnosis'] = $record->nursingDiagnosis;
                    $context['patient'] = $record->nursingDiagnosis->patient;
                    break;
                case 'implementation':
                    $context['intervention'] = $record->nursingIntervention;
                    $context['diagnosis'] = $record->nursingIntervention->nursingDiagnosis;
                    $context['patient'] = $record->nursingIntervention->nursingDiagnosis->patient;
                    break;
                case 'evaluation':
                    $context['intervention'] = $record->nursingIntervention;
                    $context['diagnosis'] = $record->nursingIntervention->nursingDiagnosis;
                    $context['patient'] = $record->nursingIntervention->nursingDiagnosis->patient;
                    break;
            }
        }
        
        return $context;
    }

    /**
     * Get student progress summary
     */
    private function getStudentProgressSummary($supervisorId)
    {
        return DB::table('supervision_logs')
            ->join('users', 'supervision_logs.student_id', '=', 'users.id')
            ->where('supervision_logs.supervisor_id', $supervisorId)
            ->select(
                'users.id',
                'users.name',
                'users.student_id',
                DB::raw('COUNT(*) as total_submissions'),
                DB::raw("COUNT(CASE WHEN status = 'approved' THEN 1 END) as approved_count"),
                DB::raw("COUNT(CASE WHEN status = 'needs_revision' THEN 1 END) as revision_count"),
                DB::raw('AVG(CASE WHEN grade IS NOT NULL THEN grade END) as avg_grade')
            )
            ->groupBy('users.id', 'users.name', 'users.student_id')
            ->orderBy('users.name')
            ->get();
    }
}
