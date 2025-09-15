<?php

namespace App\Http\Controllers;

use App\Models\NursingDiagnosis;
use App\Models\Patient;
use Illuminate\Http\Request;

class NursingDiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = NursingDiagnosis::with(['patient', 'user']);
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $diagnoses = $query->orderBy('priority', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);
        
        return view('nursing-diagnoses.index', compact('diagnoses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        
        $query = Patient::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $patients = $query->where('status', 'active')->get();
        
        return view('nursing-diagnoses.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'sdki_code' => 'nullable|string|max:20',
            'diagnosis_title' => 'required|string|max:255',
            'definition' => 'required|string',
            'signs_symptoms' => 'required|array',
            'signs_symptoms.subjective' => 'nullable|array',
            'signs_symptoms.objective' => 'nullable|array',
            'related_factors' => 'nullable|array',
            'risk_factors' => 'nullable|array',
            'priority' => 'required|in:high,medium,low',
            'date_identified' => 'required|date',
            'target_date' => 'nullable|date|after:date_identified',
            'rationale' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Authorization check
        $patient = Patient::findOrFail($validated['patient_id']);
        if (auth()->user()->isMahasiswa() && $patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to create diagnosis for this patient.');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'active';
        
        $diagnosis = NursingDiagnosis::create($validated);

        return redirect()->route('nursing-diagnoses.show', $diagnosis)
            ->with('success', 'Diagnosis keperawatan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NursingDiagnosis $nursingDiagnosis)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $nursingDiagnosis->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to view this diagnosis.');
        }

        $nursingDiagnosis->load(['patient', 'user', 'nursingInterventions']);
        
        return view('nursing-diagnoses.show', compact('nursingDiagnosis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NursingDiagnosis $nursingDiagnosis)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $nursingDiagnosis->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to edit this diagnosis.');
        }

        $user = auth()->user();
        $query = Patient::query();
        
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $patients = $query->where('status', 'active')->get();
        
        return view('nursing-diagnoses.edit', compact('nursingDiagnosis', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NursingDiagnosis $nursingDiagnosis)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $nursingDiagnosis->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to update this diagnosis.');
        }

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'sdki_code' => 'nullable|string|max:20',
            'diagnosis_title' => 'required|string|max:255',
            'definition' => 'required|string',
            'signs_symptoms' => 'required|array',
            'signs_symptoms.subjective' => 'nullable|array',
            'signs_symptoms.objective' => 'nullable|array',
            'related_factors' => 'nullable|array',
            'risk_factors' => 'nullable|array',
            'priority' => 'required|in:high,medium,low',
            'status' => 'required|in:active,resolved,inactive',
            'date_identified' => 'required|date',
            'target_date' => 'nullable|date|after:date_identified',
            'rationale' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $nursingDiagnosis->update($validated);

        return redirect()->route('nursing-diagnoses.show', $nursingDiagnosis)
            ->with('success', 'Diagnosis keperawatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NursingDiagnosis $nursingDiagnosis)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $nursingDiagnosis->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to delete this diagnosis.');
        }

        $nursingDiagnosis->delete();

        return redirect()->route('nursing-diagnoses.index')
            ->with('success', 'Diagnosis keperawatan berhasil dihapus.');
    }
}
