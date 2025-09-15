<?php

namespace App\Http\Controllers;

use App\Models\Implementation;
use App\Models\NursingIntervention;
use Illuminate\Http\Request;

class ImplementationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = Implementation::with(['nursingIntervention.nursingDiagnosis.patient', 'user']);
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $implementations = $query->orderBy('implementation_datetime', 'desc')->paginate(10);
        
        return view('implementations.index', compact('implementations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        
        $query = NursingIntervention::with(['nursingDiagnosis.patient']);
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $interventions = $query->whereIn('status', ['planned', 'in_progress'])->get();
        
        return view('implementations.create', compact('interventions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nursing_intervention_id' => 'required|exists:nursing_interventions,id',
            'implementation_datetime' => 'required|date',
            'activities_performed' => 'required|array',
            'method_used' => 'required|string',
            'patient_response' => 'required|string',
            'vital_signs_post' => 'nullable|array',
            'vital_signs_post.blood_pressure_systolic' => 'nullable|numeric|min:60|max:300',
            'vital_signs_post.blood_pressure_diastolic' => 'nullable|numeric|min:30|max:200',
            'vital_signs_post.heart_rate' => 'nullable|numeric|min:30|max:220',
            'vital_signs_post.respiratory_rate' => 'nullable|numeric|min:8|max:60',
            'vital_signs_post.temperature' => 'nullable|numeric|min:32|max:45',
            'vital_signs_post.oxygen_saturation' => 'nullable|numeric|min:70|max:100',
            'vital_signs_post.pain_scale' => 'nullable|integer|min:0|max:10',
            'complications' => 'nullable|string',
            'completion_status' => 'required|in:completed,partially_completed,not_completed',
            'reason_not_completed' => 'required_if:completion_status,not_completed|nullable|string',
            'modifications_made' => 'nullable|string',
            'follow_up_needed' => 'nullable|string',
            'student_reflection' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Authorization check
        $intervention = NursingIntervention::findOrFail($validated['nursing_intervention_id']);
        if (auth()->user()->isMahasiswa() && $intervention->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to create implementation for this intervention.');
        }

        $validated['user_id'] = auth()->id();
        
        $implementation = Implementation::create($validated);

        // Update intervention status to in_progress if it's still planned
        if ($intervention->status === 'planned') {
            $intervention->update(['status' => 'in_progress']);
        }

        return redirect()->route('implementations.show', $implementation)
            ->with('success', 'Implementasi berhasil didokumentasikan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Implementation $implementation)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $implementation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to view this implementation.');
        }

        $implementation->load(['nursingIntervention.nursingDiagnosis.patient', 'user']);
        
        return view('implementations.show', compact('implementation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Implementation $implementation)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $implementation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to edit this implementation.');
        }

        $user = auth()->user();
        $query = NursingIntervention::with(['nursingDiagnosis.patient']);
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $interventions = $query->whereIn('status', ['planned', 'in_progress'])->get();
        
        return view('implementations.edit', compact('implementation', 'interventions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Implementation $implementation)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $implementation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to update this implementation.');
        }

        $validated = $request->validate([
            'nursing_intervention_id' => 'required|exists:nursing_interventions,id',
            'implementation_datetime' => 'required|date',
            'activities_performed' => 'required|array',
            'method_used' => 'required|string',
            'patient_response' => 'required|string',
            'vital_signs_post' => 'nullable|array',
            'vital_signs_post.blood_pressure_systolic' => 'nullable|numeric|min:60|max:300',
            'vital_signs_post.blood_pressure_diastolic' => 'nullable|numeric|min:30|max:200',
            'vital_signs_post.heart_rate' => 'nullable|numeric|min:30|max:220',
            'vital_signs_post.respiratory_rate' => 'nullable|numeric|min:8|max:60',
            'vital_signs_post.temperature' => 'nullable|numeric|min:32|max:45',
            'vital_signs_post.oxygen_saturation' => 'nullable|numeric|min:70|max:100',
            'vital_signs_post.pain_scale' => 'nullable|integer|min:0|max:10',
            'complications' => 'nullable|string',
            'completion_status' => 'required|in:completed,partially_completed,not_completed',
            'reason_not_completed' => 'required_if:completion_status,not_completed|nullable|string',
            'modifications_made' => 'nullable|string',
            'follow_up_needed' => 'nullable|string',
            'student_reflection' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $implementation->update($validated);

        return redirect()->route('implementations.show', $implementation)
            ->with('success', 'Implementasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Implementation $implementation)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $implementation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to delete this implementation.');
        }

        $implementation->delete();

        return redirect()->route('implementations.index')
            ->with('success', 'Implementasi berhasil dihapus.');
    }
}
