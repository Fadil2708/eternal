@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $title) — Eternal Internship</title>

    <link rel="icon" type="image/webp" sizes="32x32" href="{{ asset('images/LogoEternalFavIcon.webp') }}">
    <link rel="icon" type="image/webp" sizes="192x192" href="{{ asset('images/LogoEternalFavIcon.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/LogoEternalFavIcon.webp') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.33.0/dist/tabler-icons.min.css"
    >

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css'])
    @stack('styles')
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        :root {
            --sidebar-width: 240px;
            --topbar-height: 72px;
        }

        /* =====================================================
           MAIN WRAPPER
        ====================================================== */

        .dash-wrap {
            width: 100%;
            min-height: 100vh;
            background: #f8f9fb;
        }

        /* =====================================================
           SIDEBAR - GLASSMORPHISM
        ====================================================== */

        .dash-wrap .sidebar {
            position: fixed;
            top: 0;
            left: 0;

            display: flex;
            flex-direction: column;

            width: var(--sidebar-width);
            height: 100vh;

            background: rgba(15, 15, 35, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);

            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.3);

            box-sizing: border-box;

            z-index: 1100;

            overflow-y: auto;
            overflow-x: hidden;

            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* =====================================================
           MAIN AREA
        ====================================================== */

        .dash-wrap .main-content {
            margin-left: var(--sidebar-width);

            width: calc(100% - var(--sidebar-width));
            height: 100vh;

            display: flex;
            flex-direction: column;

            position: relative;

            box-sizing: border-box;

            overflow-x: hidden;
            overflow-y: hidden;
        }

        /* =====================================================
           TOPBAR
        ====================================================== */

        .dash-wrap .topbar {
            position: sticky;
            top: 0;

            width: 100%;
            min-height: var(--topbar-height);

            z-index: 900;

            box-sizing: border-box;
        }

        /* =====================================================
           BODY
        ====================================================== */

        .dash-wrap .dash-body {
            width: 100%;
            max-width: 100%;

            flex: 1;
            min-height: 0;

            box-sizing: border-box;

            padding: 24px;

            overflow-y: auto;
        }

        /* =====================================================
           PROFILE STRIP
           
           Kalau profile strip memang diperlukan,
           tampil setelah topbar.
        ====================================================== */

        .dash-wrap .profile-strip {
            width: 100%;
            box-sizing: border-box;
        }

        /* =====================================================
           SIDEBAR BACKDROP
        ====================================================== */

        .sidebar-backdrop {
            display: none;
        }

        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 768px) {

            .dash-wrap .sidebar {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }

            .dash-wrap .sidebar.open {
                transform: translateX(0);
            }

            .dash-wrap .main-content {
                margin-left: 0;
                width: 100%;
            }

            .dash-wrap .dash-body {
                padding: 16px;
            }

            .sidebar-backdrop {
                display: block;

                position: fixed;
                inset: 0;

                background: rgba(15, 23, 42, .45);

                z-index: 1050;

                opacity: 0;
                visibility: hidden;
                pointer-events: none;

                transition:
                    opacity .25s ease,
                    visibility .25s ease;
            }

            .sidebar-backdrop.show {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }
        }

        @media (min-width: 769px) {

            .dash-wrap .sidebar {
                transform: translateX(0) !important;
            }

            .sidebar-backdrop {
                display: none !important;
            }
        }

        /* =====================================================
           DEFENSIVE ORDER
           Memaksa urutan: topbar -> profile-strip -> dash-body,
           agar tidak ada CSS lain yang membalik urutannya.
        ====================================================== */

        .dash-wrap .main-content {
            display: flex !important;
            flex-direction: column !important;
        }

        .dash-wrap .main-content > .topbar {
            order: 0 !important;
            flex: 0 0 auto;
        }

        .dash-wrap .main-content > .profile-strip {
            order: 1 !important;
        }

        .dash-wrap .main-content > .dash-body {
            order: 2 !important;
        }
    </style>
</head>

<body>

<script nonce="{{ $cspNonce }}">
    document.documentElement.classList.remove('dark');
    localStorage.removeItem('dark');
</script>

<div
    class="dash-wrap"
    x-data="{ sidebarOpen: false }"
>

    {{-- ==========================================
         SIDEBAR BACKDROP
    =========================================== --}}
    <div
        class="sidebar-backdrop"
        :class="sidebarOpen ? 'show' : ''"
        @click="sidebarOpen = false"
    ></div>


    {{-- ==========================================
         SIDEBAR
    =========================================== --}}
    @include('components.sidebar')


    {{-- ==========================================
         MAIN AREA
    =========================================== --}}
    <main class="main-content">

        {{-- ======================================
             TOPBAR
        ======================================= --}}
        @include('components.topbar', [
            'title' => $pageTitle ?? ($title ?? 'Dashboard')
        ])


        {{-- ======================================
             PROFILE STRIP
             
             Jika memang ingin ditampilkan,
             sekarang posisinya SETELAH topbar.
        ======================================= --}}
        @if($showProfileStrip)
            @include('components.profile-strip')
        @endif


        {{-- ======================================
             PAGE CONTENT
        ======================================= --}}
        <div class="dash-body">

            @yield('content')

            {{ $slot ?? '' }}

        </div>

    </main>

</div>


@include('components.toast')
@include('components.confirm-modal')

@vite(['resources/js/auth.js'])

@stack('scripts')
@livewireScripts

</body>
</html>