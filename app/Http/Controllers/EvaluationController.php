<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\NursingIntervention;
use App\Models\User;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = Evaluation::with(['nursingIntervention.nursingDiagnosis.patient', 'user', 'supervisor']);
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        } elseif ($user->isDosen()) {
            $query->where('supervisor_id', $user->id);
        }
        
        $evaluations = $query->orderBy('evaluation_date', 'desc')->paginate(10);
        
        return view('evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        
        // Only students can create evaluations
        if (!$user->isMahasiswa()) {
            abort(403, 'Only students can create evaluations.');
        }
        
        $interventions = NursingIntervention::with(['nursingDiagnosis.patient'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['in_progress', 'completed'])
            ->get();
        
        $supervisors = User::where('role', 'dosen')->get();
        
        return view('evaluations.create', compact('interventions', 'supervisors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nursing_intervention_id' => 'required|exists:nursing_interventions,id',
            'supervisor_id' => 'nullable|exists:users,id',
            'evaluation_date' => 'required|date',
            'outcome_achievement' => 'required|array',
            'slki_indicators' => 'required|array',
            'progress_notes' => 'required|string',
            'overall_progress' => 'required|in:exceeded,met,partially_met,not_met',
            'barriers_identified' => 'nullable|string',
            'patient_satisfaction' => 'nullable|string',
            'family_feedback' => 'nullable|string',
            'modifications_needed' => 'nullable|array',
            'continuing_care_needs' => 'nullable|string',
            'discharge_recommendations' => 'nullable|string',
            'student_analysis' => 'required|string',
            'learning_outcomes' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Authorization check
        if (!auth()->user()->isMahasiswa()) {
            abort(403, 'Only students can create evaluations.');
        }

        $intervention = NursingIntervention::findOrFail($validated['nursing_intervention_id']);
        if ($intervention->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to create evaluation for this intervention.');
        }

        // Validate supervisor is a teacher
        if (isset($validated['supervisor_id'])) {
            $supervisor = User::findOrFail($validated['supervisor_id']);
            if (!$supervisor->isDosen()) {
                abort(422, 'Selected supervisor must be a teacher.');
            }
        }

        $validated['user_id'] = auth()->id();
        
        $evaluation = Evaluation::create($validated);

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', 'Evaluasi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        $user = auth()->user();
        
        // Authorization check
        if ($user->isMahasiswa() && $evaluation->user_id !== $user->id) {
            abort(403, 'Unauthorized to view this evaluation.');
        } elseif ($user->isDosen() && $evaluation->supervisor_id !== $user->id && $evaluation->supervisor_id !== null) {
            abort(403, 'Unauthorized to view this evaluation.');
        }

        $evaluation->load(['nursingIntervention.nursingDiagnosis.patient', 'user', 'supervisor']);
        
        return view('evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        $user = auth()->user();
        
        // Students can edit their own evaluations, supervisors can add feedback
        if ($user->isMahasiswa() && $evaluation->user_id !== $user->id) {
            abort(403, 'Unauthorized to edit this evaluation.');
        } elseif ($user->isDosen() && $evaluation->supervisor_id !== $user->id && $evaluation->supervisor_id !== null) {
            abort(403, 'Unauthorized to edit this evaluation.');
        }

        $interventions = collect();
        $supervisors = collect();
        
        if ($user->isMahasiswa()) {
            $interventions = NursingIntervention::with(['nursingDiagnosis.patient'])
                ->where('user_id', $user->id)
                ->whereIn('status', ['in_progress', 'completed'])
                ->get();
            $supervisors = User::where('role', 'dosen')->get();
        }
        
        return view('evaluations.edit', compact('evaluation', 'interventions', 'supervisors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $user = auth()->user();
        
        // Authorization check
        if ($user->isMahasiswa() && $evaluation->user_id !== $user->id) {
            abort(403, 'Unauthorized to update this evaluation.');
        } elseif ($user->isDosen() && $evaluation->supervisor_id !== $user->id && $evaluation->supervisor_id !== null) {
            abort(403, 'Unauthorized to update this evaluation.');
        }

        if ($user->isMahasiswa()) {
            // Student updating their evaluation
            $validated = $request->validate([
                'nursing_intervention_id' => 'required|exists:nursing_interventions,id',
                'supervisor_id' => 'nullable|exists:users,id',
                'evaluation_date' => 'required|date',
                'outcome_achievement' => 'required|array',
                'slki_indicators' => 'required|array',
                'progress_notes' => 'required|string',
                'overall_progress' => 'required|in:exceeded,met,partially_met,not_met',
                'barriers_identified' => 'nullable|string',
                'patient_satisfaction' => 'nullable|string',
                'family_feedback' => 'nullable|string',
                'modifications_needed' => 'nullable|array',
                'continuing_care_needs' => 'nullable|string',
                'discharge_recommendations' => 'nullable|string',
                'student_analysis' => 'required|string',
                'learning_outcomes' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);
        } else {
            // Supervisor adding feedback and grade
            $validated = $request->validate([
                'supervisor_feedback' => 'required|string',
                'supervisor_grade' => 'required|integer|min:0|max:100',
                'areas_for_improvement' => 'nullable|string',
            ]);
        }

        $evaluation->update($validated);

        return redirect()->route('evaluations.show', $evaluation)
            ->with('success', $user->isDosen() ? 'Feedback berhasil diberikan.' : 'Evaluasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        // Only students can delete their own evaluations
        if (!auth()->user()->isMahasiswa() || $evaluation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to delete this evaluation.');
        }

        $evaluation->delete();

        return redirect()->route('evaluations.index')
            ->with('success', 'Evaluasi berhasil dihapus.');
    }
}
