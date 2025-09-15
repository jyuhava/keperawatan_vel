<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Assessment;
use App\Models\NursingDiagnosis;
use App\Models\NursingIntervention;
use App\Models\Implementation;
use App\Models\Evaluation;
use App\Observers\AssessmentObserver;
use App\Observers\NursingDiagnosisObserver;
use App\Observers\ImplementationObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers for supervision system
        Assessment::observe(AssessmentObserver::class);
        NursingDiagnosis::observe(NursingDiagnosisObserver::class);
        Implementation::observe(ImplementationObserver::class);
    }
}
