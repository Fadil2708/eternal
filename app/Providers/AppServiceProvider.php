<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Certificate;
use App\Models\Evaluation;
use App\Models\FinalReport;
use App\Models\Internship;
use App\Models\Logbook;
use App\Models\Testimonial;
use App\Policies\ApplicationPolicy;
use App\Policies\CertificatePolicy;
use App\Policies\EvaluationPolicy;
use App\Policies\FinalReportPolicy;
use App\Policies\InternshipPolicy;
use App\Policies\LogbookPolicy;
use App\Policies\TestimonialPolicy;
use App\View\Composers\LayoutComposer;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        URL::forceRootUrl(config('app.url'));

        Gate::policy(Application::class, ApplicationPolicy::class);
        Gate::policy(Certificate::class, CertificatePolicy::class);
        Gate::policy(Internship::class, InternshipPolicy::class);
        Gate::policy(Logbook::class, LogbookPolicy::class);
        Gate::policy(Evaluation::class, EvaluationPolicy::class);
        Gate::policy(FinalReport::class, FinalReportPolicy::class);
        Gate::policy(Testimonial::class, TestimonialPolicy::class);

        View::composer('layouts.app', LayoutComposer::class);
        View::composer('*', LayoutComposer::class);

        View::share('cspNonce', base64_encode(random_bytes(16)));
    }
}
