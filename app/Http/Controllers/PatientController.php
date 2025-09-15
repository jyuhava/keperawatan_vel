<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = Patient::with('user');
        
        // Students can only see their own patients
        if ($user->isMahasiswa()) {
            $query->where('user_id', $user->id);
        }
        
        $patients = $query->latest()->paginate(10);
        
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'admission_date' => 'required|date',
            'room_number' => 'nullable|string|max:20',
            'chief_complaint' => 'nullable|string',
        ]);

        // Generate medical record number
        $lastRecord = Patient::latest('id')->first();
        $nextNumber = $lastRecord ? $lastRecord->id + 1 : 1;
        $validated['medical_record_number'] = 'MR' . date('Y') . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        // Add user_id
        $validated['user_id'] = auth()->id();

        Patient::create($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $patient->load('user', 'assessments', 'nursingDiagnoses');
        
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'admission_date' => 'required|date',
            'discharge_date' => 'nullable|date',
            'status' => 'required|in:active,discharged,transferred',
            'room_number' => 'nullable|string|max:20',
            'chief_complaint' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        // Authorization check
        if (auth()->user()->isMahasiswa() && $patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
