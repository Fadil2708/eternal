<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eternal Internship — Sistem Magang PKL')</title>
    <meta name="description" content="@yield('meta_description', 'Sistem Informasi Pengelolaan Magang & PKL Eternal Internship — pendaftaran, monitoring, dan evaluasi program magang secara digital.')">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Favicon & Touch Icons --}}
    <link rel="icon" type="image/webp" sizes="32x32" href="{{ asset('images/LogoEternalFavIcon.webp') }}">
    <link rel="icon" type="image/webp" sizes="192x192" href="{{ asset('images/LogoEternalFavIcon.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/LogoEternalFavIcon.webp') }}">

    {{-- Open Graph & Twitter Card --}}
    <meta property="og:title" content="@yield('title', 'Eternal Internship — Sistem Magang PKL')">
    <meta property="og:description" content="@yield('meta_description', 'Sistem Informasi Pengelolaan Magang & PKL Eternal Internship — pendaftaran, monitoring, dan evaluasi program magang secara digital.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/LogoEternalUtama.webp') }}">
    <meta property="og:image:width" content="1254">
    <meta property="og:image:height" content="1254">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ asset('images/LogoEternalUtama.webp') }}">

    {{-- Fonts — preconnect + preload + optimized load --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" media="print" id="font-css">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap">
    </noscript>
    <script nonce="{{ $cspNonce }}">document.getElementById('font-css').media='all'</script>

    {{-- CDN resources --}}
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.33.0/dist/tabler-icons.min.css">

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/css/landing.css'])

    {{-- Structured Data --}}
    <script type="application/ld+json" nonce="{{ $cspNonce }}">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Sistem Magang & PKL Eternal Internship",
        "url": "{{ url('/') }}",
        "description": "Sistem Informasi Pengelolaan Magang & PKL Eternal Internship — pendaftaran, monitoring, dan evaluasi program magang secara digital."
    }
    </script>
</head>
<body style="background: #F8FAFC;">

    <a href="#main-content" class="skip-link">Lompat ke konten utama</a>

    <div class="scroll-progress" x-data="scrollProgress" :style="style"></div>

    @php
        $announcementEnabled = \App\Models\SiteSetting::getValue('announcement_enabled', '0');
        $announcementText = \App\Models\SiteSetting::getValue('announcement_text', '');
        $announcementDeadline = \App\Models\SiteSetting::getValue('announcement_deadline', '');
    @endphp
    @if($announcementEnabled === '1' && $announcementText)
    <div class="alert-bar" x-data="alertBar"
         x-show="show" role="alert">
        <div class="alert-bar-inner">
            <i class="ti ti-sparkles alert-bar-icon"></i>
            <span class="alert-bar-text">
                <strong>{{ $announcementText }}</strong>
                @if($announcementDeadline)
                Daftar sekarang sebelum <span class="alert-bar-deadline">{{ $announcementDeadline }}</span>.
                @endif
            </span>
            <button @click="dismiss" class="alert-bar-close" aria-label="Tutup pengumuman">
                <i class="ti ti-x"></i>
            </button>
        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════
         NAVBAR — Eternal (redesign v2)
         ═══════════════════════════════════════════════════════════ --}}
    <div x-data="publicNav"
         @keydown.escape.window="close">

    <header class="navbar" @click.away="close">
        <div class="navbar-inner">

            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/LogoEternalFavIcon.webp') }}" alt="Eternal" class="logo-img">
                <div class="logo-text">
                    <strong>Eternal</strong>
                    <span>Internship Management System</span>
                </div>
            </a>

            <nav class="nav-links">
                <a href="{{ url('/#beranda') }}" :class="{ active: active === 'beranda' }" @click="close">Beranda</a>
                <a href="{{ url('/#fitur') }}" :class="{ active: active === 'fitur' }" @click="close">Fitur</a>
                <a href="{{ url('/#alur') }}" :class="{ active: active === 'alur' }" @click="close">Alur Magang</a>
                <a href="{{ url('/#untuk-siapa') }}" :class="{ active: active === 'untuk-siapa' }" @click="close">Untuk Siapa</a>
                <a href="{{ url('/#tentang') }}" :class="{ active: active === 'tentang' }" @click="close">Tentang</a>
                <a href="{{ url('/#faq') }}" :class="{ active: active === 'faq' }" @click="close">FAQ</a>
            </nav>

            <div class="nav-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="login-btn"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="login-btn login-btn-ghost"><i class="ti ti-user-plus"></i> Daftar</a>
                    @endif
                    <a href="{{ route('login') }}" class="login-btn"><i class="ti ti-login"></i> Masuk</a>
                @endauth
            </div>

            <button @click="toggle" class="mobile-menu" :class="{ 'is-open': navOpen }" aria-label="Toggle menu" :aria-expanded="navOpen">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

        </div>
    </header>

    <div class="navbar-spacer"></div>

    {{-- Mobile slide panel --}}
    <div class="nav-overlay" :class="{ 'is-visible': navOpen }" @click="close" x-cloak></div>
    <div class="nav-panel" :class="{ 'is-open': navOpen }">
        <nav class="nav-panel-links">
            <a href="{{ url('/#beranda') }}" :class="{ active: active === 'beranda' }" @click="close">Beranda</a>
            <a href="{{ url('/#fitur') }}" :class="{ active: active === 'fitur' }" @click="close">Fitur</a>
            <a href="{{ url('/#alur') }}" :class="{ active: active === 'alur' }" @click="close">Alur Magang</a>
            <a href="{{ url('/#untuk-siapa') }}" :class="{ active: active === 'untuk-siapa' }" @click="close">Untuk Siapa</a>
            <a href="{{ url('/#tentang') }}" :class="{ active: active === 'tentang' }" @click="close">Tentang</a>
            <a href="{{ url('/#faq') }}" :class="{ active: active === 'faq' }" @click="close">FAQ</a>
        </nav>

        <div class="nav-panel-divider"></div>

        <div class="nav-panel-auth">
            @auth
                <a href="{{ url('/dashboard') }}" class="login-btn"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="login-btn login-btn-ghost"><i class="ti ti-user-plus"></i> Daftar</a>
                @endif
                <a href="{{ route('login') }}" class="login-btn"><i class="ti ti-login"></i> Masuk</a>
            @endauth
        </div>
    </div>

    </div>

    <div class="page-wrapper">
    @yield('content')
    <div id="main-content"></div>
    {{ $slot ?? '' }}

    <footer class="public-footer">
        <div class="container">
            <div class="footer-grid">

                <div class="footer-brand">
                    <a href="{{ url('/') }}" class="logo">
                        <div class="logo-mark"><img src="{{ asset('images/LogoEternalFavIcon.webp') }}" alt=""></div>
                        <div class="logo-text">
                            <strong>Eternal</strong>
                            <span>Internship Management System</span>
                        </div>
                    </a>
                    <p class="footer-description">Sistem internal perusahaan untuk mengelola program magang secara terstruktur, terintegrasi, dan aman.</p>
                    <div class="footer-social">
                        <a href="https://www.instagram.com/telkomsukabumi" target="_blank" rel="noopener noreferrer" aria-label="Instagram Eternal Internship">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/telkom-indonesia" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn Eternal Internship">
                            <i class="ti ti-brand-linkedin"></i>
                        </a>
                        <a href="https://www.youtube.com/@TelkomIndonesia" target="_blank" rel="noopener noreferrer" aria-label="YouTube Eternal Internship">
                            <i class="ti ti-brand-youtube"></i>
                        </a>
                        <a href="https://wa.me/6285881683025" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp Eternal Internship">
                            <i class="ti ti-brand-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <div class="footer-title">Navigasi</div>
                    <div class="footer-links">
                        <a href="{{ url('/#beranda') }}">Beranda</a>
                        <a href="{{ url('/#fitur') }}">Fitur</a>
                        <a href="{{ url('/#alur') }}">Alur Magang</a>
                        <a href="{{ url('/#untuk-siapa') }}">Untuk Siapa</a>
                        <a href="{{ url('/#faq') }}">FAQ</a>
                    </div>
                </div>

                <div>
                    <div class="footer-title">Fitur</div>
                    <div class="footer-links">
                        <a href="{{ route('public.vacancies') }}">Cari Lowongan</a>
                        <a href="{{ route('public.testimonials') }}">Testimoni</a>
                        <a href="{{ route('public.tentang-kami') }}">Tentang Kami</a>
                        <a href="{{ route('public.syarat') }}">Syarat &amp; Ketentuan</a>
                        <a href="{{ route('public.privacy') }}">Kebijakan Privasi</a>
                    </div>
                </div>

                <div>
                    <div class="footer-title">Kontak</div>
                    <a class="footer-map" href="https://maps.app.goo.gl/MmTVo2JSAdbPbznK9" target="_blank" rel="noopener" aria-label="Buka peta Eternal Internship di Google Maps">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox=106.9152%2C-6.9257%2C106.9353%2C-6.9157&layer=mapnik&marker=-6.9206966%2C106.9252477"
                            title="Peta Eternal Internship"
                            loading="lazy"
                            allowfullscreen
                            tabindex="-1"></iframe>
                        <span class="footer-map-overlay">
                            <span class="footer-map-badge">
                                <i class="ti ti-map-pin"></i> Buka di Google Maps
                            </span>
                        </span>
                    </a>
                    <div class="footer-contact">
                        <div><i class="ti ti-map-pin"></i><a class="footer-map-link" href="https://maps.app.goo.gl/MmTVo2JSAdbPbznK9" target="_blank" rel="noopener">Eternal Internship, Jl. Masjid No.1, Gunungparang, Kec. Cikole, Kota Sukabumi, Jawa Barat 43111</a></div>
                        <div><i class="ti ti-mail"></i><span>magang@telkomsukabumi.co.id</span></div>
                        <div><i class="ti ti-phone"></i><span>+62 858-8168-3025</span></div>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Eternal Internship Management System. All rights reserved.
            </div>
        </div>
    </footer>
    </div>

    <div class="cookie-consent" x-data="cookieConsent"
         x-show="show" x-cloak>
        <div class="cookie-consent-inner">
            <div class="cookie-consent-text">
                <i class="ti ti-cookie cookie-consent-icon"></i>
                <span>Kami menggunakan cookie untuk meningkatkan pengalaman Anda. Dengan melanjutkan, Anda menyetujui penggunaan cookie sesuai <a href="#" class="cookie-consent-link">Kebijakan Privasi</a> kami.</span>
            </div>
            <div class="cookie-consent-actions">
                <button @click="accept" class="btn-primary" style="padding:8px 18px;font-size:12px;white-space:nowrap">Terima</button>
            </div>
        </div>
    </div>

    @auth
        <div class="mobile-cta">
            <a href="{{ route('public.vacancies') }}" class="btn-primary btn-cta">
                <i class="ti ti-briefcase"></i> Lihat Lowongan
            </a>
        </div>
    @else
        <div class="mobile-cta">
            <a href="{{ route('register') }}" class="btn-primary btn-cta">
                <i class="ti ti-user-plus"></i> Daftar Sekarang
            </a>
            <a href="{{ route('login') }}" class="btn-outline-nav" style="flex:1;justify-content:center;padding:12px 18px;font-size:14px;border-radius:12px;text-align:center;">
                <i class="ti ti-login"></i> Masuk
            </a>
        </div>
    @endauth

    <a href="https://wa.me/6285881683025?text=Halo%20Eternal%20Internship%2C%20saya%20ingin%20bertanya%20tentang%20program%20magang."
       target="_blank" rel="noopener noreferrer"
       class="whatsapp-float"
       aria-label="Hubungi via WhatsApp">
        <i class="ti ti-brand-whatsapp"></i>
    </a> 
    <script nonce="{{ $cspNonce }}">
        document.addEventListener('alpine:init', () => {
            
            // 1. Komponen Navbar
            Alpine.data('publicNav', () => ({
                navOpen: false,
                active: 'beranda',
                init() {
                    this.updateActive();
                    window.addEventListener('hashchange', () => this.updateActive());
                },
                updateActive() {
                    const hash = window.location.hash.substring(1);
                    this.active = hash ? hash : 'beranda';
                },
                toggle() {
                    this.navOpen = !this.navOpen;
                },
                close() {
                    this.navOpen = false;
                }
            }));

            // 2. Komponen Scroll Progress
            Alpine.data('scrollProgress', () => ({
                style: 'width: 0%',
                init() {
                    window.addEventListener('scroll', () => {
                        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                        let scrolled = (winScroll / height) * 100;
                        this.style = `width: ${scrolled}%`;
                    });
                }
            }));

            // 3. Komponen Alert Bar (Pengumuman)
            Alpine.data('alertBar', () => ({
                show: true,
                dismiss() {
                    this.show = false;
                }
            }));

            // 4. Komponen Cookie Consent
            Alpine.data('cookieConsent', () => ({
                show: false,
                init() {
                    if (!localStorage.getItem('cookie_accepted')) {
                        this.show = true;
                    }
                },
                accept() {
                    localStorage.setItem('cookie_accepted', 'true');
                    this.show = false;
                }
            }));

            // 5. Komponen Offer Slider
            Alpine.data('offerSlider', (initialSlides = []) => ({
                slides: initialSlides,
                current: 0,
                
                init() {
                    setInterval(() => {
                        this.next();
                    }, 5000);
                },
                next() {
                    this.current = (this.current === this.slides.length - 1) ? 0 : this.current + 1;
                },
                prev() {
                    this.current = (this.current === 0) ? this.slides.length - 1 : this.current - 1;
                },
                setSlide(index) {
                    this.current = index;
                }
            }));
            
            // 6. Komponen Partner Marquee (Animasi Logo Berjalan)
            Alpine.data('partnerMarquee', (speed = 25) => ({
                init() {
                    // Gandakan isi HTML di dalamnya agar bisa looping mulus (seamless)
                    this.$el.innerHTML += this.$el.innerHTML;
                    
                    // Paksa gaya CSS agar memanjang ke samping dan teranimasi
                    this.$el.style.display = 'flex';
                    this.$el.style.width = 'max-content';
                    this.$el.style.animation = `marqueeInfinite ${speed}s linear infinite`;
                    
                    // Buat dan sisipkan keyframes CSS secara otomatis jika belum ada
                    if (!document.getElementById('marquee-style')) {
                        const style = document.createElement('style');
                        style.id = 'marquee-style';
                        style.innerHTML = `
                            @keyframes marqueeInfinite {
                                0% { transform: translateX(0); }
                                100% { transform: translateX(-50%); }
                            }
                            /* Opsional: Berhenti bergerak saat mouse diarahkan (hover) */
                            .partners-track:hover {
                                animation-play-state: paused !important;
                            }
                        `;
                        document.head.appendChild(style);
                    }
                }
            }));
            
            // 7. Komponen Back To Top
            Alpine.data('backToTop', () => ({
                visible: false,
                init() {
                    window.addEventListener('scroll', () => {
                        this.visible = window.scrollY > 300;
                    });
                },
                scrollToTop() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }));
        });
    </script>

    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>