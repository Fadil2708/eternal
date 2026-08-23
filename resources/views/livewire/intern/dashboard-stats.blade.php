<div>
    @php
        $hasNoApp = $applicationStatus === '-';
        $hasPendingApp = in_array($applicationStatus, ['submitted', 'under_review']);
        $hasInterview = $applicationStatus === 'interview_scheduled';
        $isAccepted = $applicationStatus === 'accepted';
        $isRejected = $applicationStatus === 'rejected';
        $isActive = $internshipStatus === 'active';
        $isCompleted = $internshipStatus === 'completed';
    @endphp

    {{-- HERO STATUS CARD --}}
    @if($hasNoApp)
    <div class="hero-card">
        <div class="hero-card-content">
            <div class="hero-icon-box">
                <i class="ti ti-rocket"></i>
            </div>
            <div class="hero-text">
                <h3 class="hero-title">Mulai Perjalanan Magangmu!</h3>
                <p class="hero-desc">Lengkapi profil dan temukan lowongan yang sesuai dengan minatmu.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('intern.vacancies') }}" class="hero-btn">
                    <i class="ti ti-search"></i> Cari Lowongan
                </a>
            </div>
        </div>
    </div>

    @elseif($hasPendingApp || $hasInterview)
    <div class="hero-card" style="background:linear-gradient(135deg,#92400e,#b45309)">
        <div class="hero-card-content">
            <div class="hero-icon-box" style="background:rgba(255,255,255,0.15);color:#fff">
                <i class="ti ti-clock"></i>
            </div>
            <div class="hero-text">
                <h3 class="hero-title">Lamaran Sedang Diproses</h3>
                <p class="hero-desc" style="color:rgba(255,255,255,0.8)">
                    @if($hasInterview)
                        Kamu sudah dijadwalkan untuk wawancara. Semoga berhasil!
                    @else
                        Tim kami sedang meninjau lamaranmu. Sabar ya!
                    @endif
                </p>
            </div>
        </div>
    </div>

    @elseif($isAccepted && !$isActive)
    <div class="hero-card" style="background:linear-gradient(135deg,#065F46,#047857)">
        <div class="hero-card-content">
            <div class="hero-icon-box" style="background:rgba(255,255,255,0.1);color:#fff">
                <i class="ti ti-circle-check"></i>
            </div>
            <div class="hero-text">
                <h3 class="hero-title">Selamat! Kamu Diterima!</h3>
                <p class="hero-desc" style="color:rgba(255,255,255,0.7)">
                    Admin akan segera mengatur jadwal dan pembimbing untuk magangmu.
                </p>
            </div>
        </div>
    </div>

    @elseif($isActive)
    <div class="hero-card">
        <div class="hero-card-content">
            <div class="hero-icon-box" style="background:rgba(255,255,255,0.15);color:#fff">
                <i class="ti ti-notebook"></i>
            </div>
            <div class="hero-text">
                <h3 class="hero-title">
                    {{ $logbookToday ? 'Logbook Hari Ini Sudah Diisi' : 'Jangan Lupa Isi Logbook Hari Ini!' }}
                </h3>
                <p class="hero-desc" style="color:rgba(255,255,255,0.8)">
                    @if($logbookToday)
                        Kamu sudah mengisi {{ $logbookThisMonth }} logbook bulan ini. Pertahankan!
                    @else
                        Catat kegiatan magangmu hari ini agar pembimbing bisa memantau.
                    @endif
                </p>
            </div>
            <div class="hero-actions">
                <a href="{{ $logbookToday ? route('intern.logbooks') : route('intern.logbooks.create') }}" class="hero-btn">
                    <i class="ti ti-{{ $logbookToday ? 'notebook' : 'plus' }}"></i>
                    {{ $logbookToday ? 'Lihat Logbook' : 'Isi Logbook' }}
                </a>
            </div>
        </div>
    </div>

    @elseif($isCompleted)
    <div class="hero-card" style="background:linear-gradient(135deg,#1e3a5f,#2563eb)">
        <div class="hero-card-content">
            <div class="hero-icon-box" style="background:rgba(255,255,255,0.1);color:#fff">
                <i class="ti ti-certificate"></i>
            </div>
            <div class="hero-text">
                <h3 class="hero-title">Magang Selesai!</h3>
                <p class="hero-desc" style="color:rgba(255,255,255,0.8)">
                    @if($hasCertificate)
                        Sertifikat sudah tersedia. Kamu juga bisa mengisi testimoni.
                    @else
                        Admin akan segera menerbitkan sertifikat. Pantau terus halaman sertifikat.
                    @endif
                </p>
            </div>
            <div class="hero-actions">
                @if($hasCertificate)
                    <a href="{{ route('intern.certificate') }}" class="hero-btn">
                        <i class="ti ti-download"></i> Lihat Sertifikat
                    </a>
                @endif
            </div>
        </div>
    </div>

    @elseif($isRejected)
    <div class="hero-card" style="background:linear-gradient(135deg,#991B1B,#7F1D1D)">
        <div class="hero-card-content">
            <div class="hero-icon-box" style="background:rgba(255,255,255,0.1);color:#FCA5A5">
                <i class="ti ti-x-circle"></i>
            </div>
            <div class="hero-text">
                <h3 class="hero-title">Lamaran Belum Berhasil</h3>
                <p class="hero-desc" style="color:rgba(255,255,255,0.7)">
                    Jangan menyerah! Cek lowongan lain yang mungkin cocok untukmu.
                </p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('intern.vacancies') }}" class="hero-btn" style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.2)">
                    <i class="ti ti-briefcase"></i> Cari Lowongan Lain
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="stats-grid">

        {{-- Lamaran --}}
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-title">Lamaran</div>
                    <div class="stat-value" style="text-transform:capitalize">
                        {{ $applicationStatus === '-' ? '—' : str_replace('_', ' ', $applicationStatus) }}
                    </div>
                </div>
                <div class="stat-icon icon-blue">
                    <i class="ti ti-file-description"></i>
                </div>
            </div>
            <div class="stat-bottom">
                @if($hasPendingApp || $hasInterview)
                    <span class="warning">Menunggu review</span>
                @elseif($isAccepted || $isActive)
                    <span class="success">Diterima</span>
                @elseif($isRejected)
                    <span style="color:#dc2626;font-weight:600">Ditolak</span>
                @else
                    <span>Belum ada lamaran</span>
                @endif
            </div>
        </div>

        {{-- Magang --}}
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-title">Status Magang</div>
                    <div class="stat-value" style="text-transform:capitalize">
                        {{ $internshipStatus === '-' ? '—' : str_replace('_', ' ', $internshipStatus) }}
                    </div>
                </div>
                <div class="stat-icon icon-green">
                    <i class="ti ti-clipboard-list"></i>
                </div>
            </div>
            <div class="stat-bottom">
                @if($isActive)
                    <span class="success">Sedang berlangsung</span>
                @elseif($isCompleted)
                    <span class="success">Selesai</span>
                @else
                    <span>Belum dimulai</span>
                @endif
            </div>
        </div>

        {{-- Logbook --}}
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-title">Logbook</div>
                    <div class="stat-value">
                        {{ $logbookThisMonth }}
                        <small>/ bulan</small>
                    </div>
                </div>
                <div class="stat-icon icon-orange">
                    <i class="ti ti-notebook"></i>
                </div>
            </div>
            <div class="stat-bottom">
                @if($logbookToday)
                    <span class="success">Hari ini sudah diisi</span>
                @elseif($isActive)
                    <span class="warning">Belum isi hari ini</span>
                @else
                    <span>—</span>
                @endif
            </div>
        </div>

        {{-- Laporan --}}
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-title">Laporan</div>
                    <div class="stat-value" style="text-transform:capitalize">
                        {{ $reportStatus === '-' ? '—' : ($reportStatus === 'pending' ? 'Menunggu' : ($reportStatus === 'approved' ? 'Disetujui' : ($reportStatus === 'rejected' ? 'Ditolak' : $reportStatus))) }}
                    </div>
                </div>
                <div class="stat-icon icon-purple">
                    <i class="ti ti-file-report"></i>
                </div>
            </div>
            <div class="stat-bottom">
                @if($reportStatus === 'approved')
                    <span class="success">Disetujui</span>
                @elseif($reportStatus === 'pending')
                    <span class="warning">Menunggu review</span>
                @elseif($reportStatus === 'rejected')
                    <span style="color:#dc2626;font-weight:600">Ditolak</span>
                @else
                    <span>Belum ada laporan</span>
                @endif
            </div>
        </div>

    </div>
</div>
