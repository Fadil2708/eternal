<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Eternal</title>
    <meta name="description" content="Eternal Internship Management System — pendaftaran, monitoring, dan evaluasi program magang & PKL secara digital.">

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/webp" sizes="512x512" href="{{ asset('images/TLK.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/TLK.webp') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" media="print" id="font-css">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap">
    </noscript>
    <script nonce="{{ $cspNonce }}">document.getElementById('font-css').media='all'</script>

    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.33.0/dist/tabler-icons.min.css">
    @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/css/landing.css'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body>
    <div class="auth-split" x-data="{ role: '@yield('auth-init', 'intern')' }">
        <aside class="auth-brand">
            <div class="auth-orb auth-orb-1"></div>
            <div class="auth-orb auth-orb-2"></div>
            <div class="auth-grid-overlay"></div>

            <div class="auth-brand-content">
                <div class="auth-logo">
                    <img src="{{ asset('images/TLK.webp') }}" alt="Logo Eternal" class="auth-logo-img">
                </div>
                <h1 class="auth-brand-name">Eternal</h1>
                <p class="auth-brand-subtitle">Internship Management System</p>

                <p class="brand-sub" x-show="role === 'intern'">Mulai Perjalanan Magang &amp; PKL Anda</p>
                <p class="brand-sub" x-show="role === 'supervisor'" x-cloak>Bimbing Generasi Baru Indonesia</p>

                <div class="auth-features">
                    <div class="auth-feature">
                        <div class="auth-feature-icon">
                            <i class="ti ti-device-desktop-analytics"></i>
                        </div>
                        <div class="auth-feature-text">
                            <strong>Dashboard Intuitif</strong>
                            <span>Pantau progres magang secara real-time</span>
                        </div>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon">
                            <i class="ti ti-book"></i>
                        </div>
                        <div class="auth-feature-text">
                            <strong>Logbook Digital</strong>
                            <span>Catat aktivitas harian dengan mudah</span>
                        </div>
                    </div>
                    <div class="auth-feature">
                        <div class="auth-feature-icon">
                            <i class="ti ti-chart-bar"></i>
                        </div>
                        <div class="auth-feature-text">
                            <strong>Laporan Otomatis</strong>
                            <span>Generate laporan tanpa ribet</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="auth-form-wrap">
            <div class="auth-form-card">
                @yield('content')
                {{ $slot ?? '' }}
            </div>
        </div>
    </div>
</body>
</html>
