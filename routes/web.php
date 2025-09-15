<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\NursingDiagnosisController;
use App\Http\Controllers\NursingInterventionController;
use App\Http\Controllers\ImplementationController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Dashboard (Admin Only)
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/admin', [DashboardController::class, 'admin'])->name('admin.dashboard');
        
        // Advanced Admin Functions
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard.detailed');
            Route::post('/export', [App\Http\Controllers\AdminController::class, 'exportData'])->name('export');
            Route::post('/backup', [App\Http\Controllers\AdminController::class, 'performBackup'])->name('backup');
            Route::post('/maintenance', [App\Http\Controllers\AdminController::class, 'performMaintenance'])->name('maintenance');
        });
    });

    // Patient management - Students can CRUD their own, Teachers can view all, Admin can view all
    Route::middleware('check.role:mahasiswa,dosen,admin')->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('assessments', AssessmentController::class);
        Route::resource('nursing-diagnoses', NursingDiagnosisController::class);
        Route::resource('nursing-interventions', NursingInterventionController::class);
        Route::resource('implementations', ImplementationController::class);
        Route::resource('evaluations', EvaluationController::class);
    });

    // User Management (Admin Only)
    Route::middleware(['check.role:admin'])->group(function () {
        Route::resource('users', UserManagementController::class);
        Route::patch('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::patch('users/{user}/update-password', [UserManagementController::class, 'updatePassword'])->name('users.update-password');
    });

    // Teaching Materials & Supervision (Dosen and Admin)
    Route::middleware(['check.role:dosen,admin'])->group(function () {
        // Student Monitoring
        Route::get('/monitor-mahasiswa', [App\Http\Controllers\SupervisionController::class, 'monitorStudents'])->name('supervision.monitor');
        
        // Teaching Materials
        Route::get('/materi-ajar/panduan-sdki', [App\Http\Controllers\TeachingMaterialController::class, 'panduanSdki'])->name('materials.sdki');
        Route::get('/materi-ajar/materi-slki', [App\Http\Controllers\TeachingMaterialController::class, 'materiSlki'])->name('materials.slki');
        Route::get('/materi-ajar/panduan-siki', [App\Http\Controllers\TeachingMaterialController::class, 'panduanSiki'])->name('materials.siki');
    });

    // Help & Support (All authenticated users)
    Route::prefix('bantuan')->name('help.')->group(function () {
        Route::get('/panduan-user', [App\Http\Controllers\HelpController::class, 'userGuide'])->name('user-guide');
        Route::get('/faq', [App\Http\Controllers\HelpController::class, 'faq'])->name('faq');
        Route::get('/kontak', [App\Http\Controllers\HelpController::class, 'contact'])->name('contact');
    });

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
