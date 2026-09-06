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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Paksa penggunaan HTTPS jika APP_URL menggunakan https
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
        
        URL::forceRootUrl(config('app.url'));

        // Fix Docker port mapping: internal 8080 vs external 8082
        // After TrustProxies runs, getPort() reads X-Forwarded-Port instead of SERVER_PORT
        // nginx always passes empty X-Forwarded-Port to PHP-FPM, so we MUST override it
        $request = request();
        $hostPort = parse_url('http://' . $request->getHttpHost(), PHP_URL_PORT);
        if ($hostPort) {
            $request->server->set('SERVER_PORT', (string) $hostPort);
            $request->headers->set('X-Forwarded-Port', (string) $hostPort);
        }

        if ($request->is('livewire*')) {
            Log::info('SIGNATURE DEBUG', [
                'url'         => $request->url(),
                'getHost'     => $request->getHost(),
                'getPort'     => $request->getPort(),
                'getHttpHost' => $request->getHttpHost(),
                'getScheme'   => $request->getScheme(),
                'SERVER_PORT' => $request->server->get('SERVER_PORT'),
                'hostHeader'  => $request->headers->get('HOST'),
                'queryString' => $request->server->get('QUERY_STRING'),
                'uri'         => $request->getRequestUri(),
                'baseUrl'     => $request->getBaseUrl(),
                'pathInfo'    => $request->getPathInfo(),
            ]);
        }

        if ($request->is('livewire*') && $request->query('signature')) {
            $url = $request->url();
            $queryString = collect(explode('&', (string) $request->server->get('QUERY_STRING')))
                ->reject(fn ($p) => Str::before($p, '=') === 'signature')
                ->join('&');
            $original = rtrim($url . '?' . $queryString, '?');
            $key = config('app.key');
            $computed = hash_hmac('sha256', $original, $key);
            $provided = $request->query('signature', '');

            Log::info('HMAC DEBUG', [
                'original'     => $original,
                'app_key'      => $key,
                'computed_sig' => $computed,
                'provided_sig' => $provided,
                'match'        => hash_equals($computed, $provided),
                'key_starts'   => substr($key, 0, 10),
            ]);
        }

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
