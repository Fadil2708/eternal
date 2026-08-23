<section class="hero" id="beranda">
    <div class="container">
        <div class="hero-grid">

            <div class="hero-content" data-reveal>
                <div class="hero-badge">
                    <i class="ti ti-shield-check"></i>
                    Sistem Pengelolaan Magang Internal Perusahaan
                </div>
                <h1>Kelola Perjalanan Magang dengan <span>Lebih Terarah.</span></h1>
                <p class="hero-description">
                    Eternal membantu perusahaan mengelola peserta magang secara terstruktur, mulai
                    dari absensi, logbook, bimbingan, monitoring, evaluasi hingga penerbitan sertifikat.
                </p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="hero-btn">
                            <i class="ti ti-layout-dashboard"></i> Dashboard
                        </a>
                        <a href="#fitur" class="hero-btn-ghost">
                            <i class="ti ti-player-play"></i> Lihat Cara Kerja
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="hero-btn">
                            <i class="ti ti-user-plus"></i> Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="hero-btn-ghost">
                            <i class="ti ti-login"></i> Login
                        </a>
                    @endauth
                </div>

                <div class="hero-features">
                    <div class="hero-feature">
                        <i class="ti ti-link"></i>
                        Terintegrasi
                    </div>
                    <div class="hero-feature">
                        <i class="ti ti-shield-check"></i>
                        Aman
                    </div>
                    <div class="hero-feature">
                        <i class="ti ti-mood-smile"></i>
                        Mudah Digunakan
                    </div>
                </div>
            </div>

            <div class="hero-visual" data-reveal>
                <div class="hero-dashboard">
                    <div class="dashboard-window">
                        <div class="dashboard-bar">
                            <div class="dashboard-dots">
                                <span style="background:#ff5f57"></span>
                                <span style="background:#ffbd2e"></span>
                                <span style="background:#28ca41"></span>
                            </div>
                        </div>
                        <div class="dashboard-main">
                            <div class="mock-sidebar">
                                <div class="mock-logo">E</div>
                                <div class="mock-nav active">
                                    <i class="ti ti-dashboard"></i>
                                    Dashboard
                                </div>
                                <div class="mock-nav">
                                    <i class="ti ti-notebook"></i>
                                    Logbook
                                </div>
                                <div class="mock-nav">
                                    <i class="ti ti-message"></i>
                                    Bimbingan
                                </div>
                                <div class="mock-nav">
                                    <i class="ti ti-chart-line"></i>
                                    Monitoring
                                </div>
                                <div class="mock-nav">
                                    <i class="ti ti-star"></i>
                                    Evaluasi
                                </div>
                                <div class="mock-nav">
                                    <i class="ti ti-certificate"></i>
                                    Sertifikat
                                </div>
                                <div class="mock-nav">
                                    <i class="ti ti-file-report"></i>
                                    Laporan
                                </div>
                            </div>
                            <div class="mock-main">
                                <div class="mock-heading">Dashboard</div>
                                <div class="mock-welcome">
                                    <div class="mock-welcome-text">
                                        <strong>Selamat Datang!</strong>
                                        <span>Semangat menjalani hari ini!</span>
                                    </div>
                                </div>
                                <div class="mock-columns">
                                    <div class="mock-card">
                                        <div class="mock-card-title">Logbook</div>
                                        <div class="mock-card-value">12</div>
                                        <div class="mock-card-sub">Bulan ini</div>
                                    </div>
                                    <div class="mock-card">
                                        <div class="mock-card-title">Absensi</div>
                                        <div class="mock-card-value">95%</div>
                                        <div class="mock-card-sub">Kehadiran</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
