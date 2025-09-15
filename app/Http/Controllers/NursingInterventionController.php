<?php

namespace App\Http\Controllers;

use App\Models\NursingIntervention;
use App\Models\NursingDiagnosis;
use Illuminate\Http\Request;

class NursingInterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = NursingIntervention::with(['nursingDiagnosis.patient', 'user']);
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $interventions = $query->orderBy('priority', 'desc')
                              ->orderBy('start_date', 'desc')
                              ->paginate(10);
        
        return view('nursing-interventions.index', compact('interventions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        
        $query = NursingDiagnosis::with('patient');
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $diagnoses = $query->where('status', 'active')->get();
        
        return view('nursing-interventions.create', compact('diagnoses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nursing_diagnosis_id' => 'required|exists:nursing_diagnoses,id',
            'siki_code' => 'nullable|string|max:20',
            'intervention_title' => 'required|string|max:255',
            'definition' => 'required|string',
            'activities' => 'required|array',
            'expected_outcomes' => 'required|array',
            'outcome_criteria' => 'required|array',
            'frequency' => 'required|in:once,daily,twice_daily,three_times_daily,four_times_daily,as_needed,continuous',
            'scheduled_time' => 'nullable|date_format:H:i',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'priority' => 'required|in:high,medium,low',
            'rationale' => 'required|string',
            'special_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Authorization check
        $diagnosis = NursingDiagnosis::findOrFail($validated['nursing_diagnosis_id']);
        if (auth()->user()->isMahasiswa() && $diagnosis->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to create intervention for this diagnosis.');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'planned';
        
        $intervention = NursingIntervention::create($validated);

        return redirect()->route('nursing-interventions.show', $intervention)
            ->with('success', 'Intervensi keperawatan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NursingIntervention $nursingIntervention)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $nursingIntervention->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to view this intervention.');
        }

        $nursingIntervention->load(['nursingDiagnosis.patient', 'user', 'implementations', 'evaluations']);
        
        return view('nursing-interventions.show', compact('nursingIntervention'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NursingIntervention $nursingIntervention)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $nursingIntervention->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to edit this intervention.');
        }

        $user = auth()->user();
        $query = NursingDiagnosis::with('patient');
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $diagnoses = $query->where('status', 'active')->get();
        
        return view('nursing-interventions.edit', compact('nursingIntervention', 'diagnoses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NursingIntervention $nursingIntervention)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $nursingIntervention->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to update this intervention.');
        }

        $validated = $request->validate([
            'nursing_diagnosis_id' => 'required|exists:nursing_diagnoses,id',
            'siki_code' => 'nullable|string|max:20',
            'intervention_title' => 'required|string|max:255',
            'definition' => 'required|string',
            'activities' => 'required|array',
            'expected_outcomes' => 'required|array',
            'outcome_criteria' => 'required|array',
            'frequency' => 'required|in:once,daily,twice_daily,three_times_daily,four_times_daily,as_needed,continuous',
            'scheduled_time' => 'nullable|date_format:H:i',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'priority' => 'required|in:high,medium,low',
            'status' => 'required|in:planned,in_progress,completed,discontinued',
            'rationale' => 'required|string',
            'special_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $nursingIntervention->update($validated);

        return redirect()->route('nursing-interventions.show', $nursingIntervention)
            ->with('success', 'Intervensi keperawatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NursingIntervention $nursingIntervention)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $nursingIntervention->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to delete this intervention.');
        }

        $nursingIntervention->delete();

        return redirect()->route('nursing-interventions.index')
            ->with('success', 'Intervensi keperawatan berhasil dihapus.');
    }
}
