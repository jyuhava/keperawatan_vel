<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Patient;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = Assessment::with(['patient', 'user']);
        
        // Students can only see their own assessments
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $assessments = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('assessments.index', compact('assessments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        
        $query = Patient::query();
        
        // Students can only create assessments for their own patients
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $patients = $query->where('status', 'active')->get();
        
        return view('assessments.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'vital_signs' => 'required|array',
            'vital_signs.blood_pressure_systolic' => 'required|numeric|min:60|max:300',
            'vital_signs.blood_pressure_diastolic' => 'required|numeric|min:30|max:200',
            'vital_signs.heart_rate' => 'required|numeric|min:30|max:220',
            'vital_signs.respiratory_rate' => 'required|numeric|min:8|max:60',
            'vital_signs.temperature' => 'required|numeric|min:32|max:45',
            'vital_signs.oxygen_saturation' => 'nullable|numeric|min:70|max:100',
            'vital_signs.pain_scale' => 'nullable|integer|min:0|max:10',
            'physical_examination' => 'nullable|string',
            'mental_status' => 'nullable|string',
            'pain_assessment' => 'nullable|string',
            'nutritional_status' => 'nullable|string',
            'skin_condition' => 'nullable|string',
            'mobility_status' => 'nullable|string',
            'respiratory_status' => 'nullable|string',
            'cardiovascular_status' => 'nullable|string',
            'neurological_status' => 'nullable|string',
            'gastrointestinal_status' => 'nullable|string',
            'genitourinary_status' => 'nullable|string',
            'psychosocial_assessment' => 'nullable|string',
            'spiritual_assessment' => 'nullable|string',
            'family_support' => 'nullable|string',
            'discharge_planning' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Authorization check - students can only create for their own patients
        $patient = Patient::findOrFail($validated['patient_id']);
        if (auth()->user()->isMahasiswa() && $patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to create assessment for this patient.');
        }

        $validated['user_id'] = auth()->id();
        
        $assessment = Assessment::create($validated);

        return redirect()->route('assessments.show', $assessment)
            ->with('success', 'Assessment berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assessment $assessment)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $assessment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to view this assessment.');
        }

        $assessment->load(['patient', 'user']);
        
        return view('assessments.show', compact('assessment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assessment $assessment)
    {
        // Authorization check - only creator can edit
        if (auth()->user()->isMahasiswa() && $assessment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to edit this assessment.');
        }

        $user = auth()->user();
        $query = Patient::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $patients = $query->where('status', 'active')->get();
        
        return view('assessments.edit', compact('assessment', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assessment $assessment)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $assessment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to update this assessment.');
        }

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'vital_signs' => 'required|array',
            'vital_signs.blood_pressure_systolic' => 'required|numeric|min:60|max:300',
            'vital_signs.blood_pressure_diastolic' => 'required|numeric|min:30|max:200',
            'vital_signs.heart_rate' => 'required|numeric|min:30|max:220',
            'vital_signs.respiratory_rate' => 'required|numeric|min:8|max:60',
            'vital_signs.temperature' => 'required|numeric|min:32|max:45',
            'vital_signs.oxygen_saturation' => 'nullable|numeric|min:70|max:100',
            'vital_signs.pain_scale' => 'nullable|integer|min:0|max:10',
            'physical_examination' => 'nullable|string',
            'mental_status' => 'nullable|string',
            'pain_assessment' => 'nullable|string',
            'nutritional_status' => 'nullable|string',
            'skin_condition' => 'nullable|string',
            'mobility_status' => 'nullable|string',
            'respiratory_status' => 'nullable|string',
            'cardiovascular_status' => 'nullable|string',
            'neurological_status' => 'nullable|string',
            'gastrointestinal_status' => 'nullable|string',
            'genitourinary_status' => 'nullable|string',
            'psychosocial_assessment' => 'nullable|string',
            'spiritual_assessment' => 'nullable|string',
            'family_support' => 'nullable|string',
            'discharge_planning' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $assessment->update($validated);

        return redirect()->route('assessments.show', $assessment)
            ->with('success', 'Assessment berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assessment $assessment)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $assessment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to delete this assessment.');
        }

        $assessment->delete();

        return redirect()->route('assessments.index')
            ->with('success', 'Assessment berhasil dihapus.');
    }
}
