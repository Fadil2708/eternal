@extends('layouts.app')
@section('title', 'Dashboard Admin')
@php $pageTitle = 'Dashboard Admin'; @endphp

@section('content')

<div class="adx-root">

    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <span>Dashboard</span>
            </div>
            <h2 class="adx-title">Dashboard Admin</h2>
            <p class="adx-sub">Selamat datang, {{ auth()->user()->displayName() ?? 'Admin' }}</p>
        </div>

        <div class="adx-header-right">
            <div class="adx-date-badge">
                <i class="ti ti-calendar"></i>
                {{ now()->translatedFormat('l, d M Y') }}
            </div>
            <div class="adx-header-btns">
                <a href="{{ route('admin.vacancies.create') }}" class="adx-btn adx-btn-primary">
                    <i class="ti ti-plus"></i> Lowongan Baru
                </a>
                <a href="{{ route('admin.applications.index') }}" class="adx-btn adx-btn-ghost">
                    <i class="ti ti-eye"></i> Review Lamaran
                </a>
            </div>
        </div>
    </div>

    {{-- ═══ STATS (Livewire) ═══ --}}
    <livewire:admin.dashboard-stats />

    {{-- ═══ QUICK ACTIONS ═══ --}}
    <div class="adx-section-head">
        <h3 class="adx-card-title">Aksi Cepat</h3>
    </div>
    <div class="adx-quick-grid">

        <a href="{{ route('admin.vacancies.create') }}" class="adx-quick">
            <div class="adx-quick-icon is-blue"><i class="ti ti-plus"></i></div>
            <div class="adx-quick-body">
                <div class="adx-quick-title">Buat Lowongan Baru</div>
                <div class="adx-quick-desc">Tambahkan posisi magang baru</div>
            </div>
            <i class="ti ti-chevron-right adx-quick-arrow"></i>
        </a>

        <a href="{{ route('admin.applications.index') }}" class="adx-quick">
            <div class="adx-quick-icon is-amber"><i class="ti ti-file-search"></i></div>
            <div class="adx-quick-body">
                <div class="adx-quick-title">Review Lamaran Masuk</div>
                <div class="adx-quick-desc">Lihat dan proses lamaran peserta</div>
            </div>
            <i class="ti ti-chevron-right adx-quick-arrow"></i>
        </a>

        <a href="{{ route('admin.supervisors.index') }}" class="adx-quick">
            <div class="adx-quick-icon is-blue"><i class="ti ti-user-plus"></i></div>
            <div class="adx-quick-body">
                <div class="adx-quick-title">Mapping Pembimbing</div>
                <div class="adx-quick-desc">Assign supervisor ke peserta magang</div>
            </div>
            <i class="ti ti-chevron-right adx-quick-arrow"></i>
        </a>

        <a href="{{ route('admin.certificates') }}" class="adx-quick">
            <div class="adx-quick-icon is-green"><i class="ti ti-certificate"></i></div>
            <div class="adx-quick-body">
                <div class="adx-quick-title">Terbitkan Sertifikat</div>
                <div class="adx-quick-desc">Generate sertifikat untuk magang selesai</div>
            </div>
            <i class="ti ti-chevron-right adx-quick-arrow"></i>
        </a>

        <a href="{{ route('admin.export.internships') }}" class="adx-quick">
            <div class="adx-quick-icon is-red"><i class="ti ti-download"></i></div>
            <div class="adx-quick-body">
                <div class="adx-quick-title">Export Data Magang</div>
                <div class="adx-quick-desc">Download rekap data dalam Excel</div>
            </div>
            <i class="ti ti-chevron-right adx-quick-arrow"></i>
        </a>

        <a href="{{ route('admin.users') }}" class="adx-quick">
            <div class="adx-quick-icon is-blue"><i class="ti ti-users"></i></div>
            <div class="adx-quick-body">
                <div class="adx-quick-title">Manajemen Pengguna</div>
                <div class="adx-quick-desc">Kelola akun admin, pembimbing & peserta</div>
            </div>
            <i class="ti ti-chevron-right adx-quick-arrow"></i>
        </a>

        <a href="{{ route('admin.logbooks') }}" class="adx-quick">
            <div class="adx-quick-icon is-amber"><i class="ti ti-notebook"></i></div>
            <div class="adx-quick-body">
                <div class="adx-quick-title">Monitor Logbook</div>
                <div class="adx-quick-desc">Pantau aktivitas harian peserta</div>
            </div>
            <i class="ti ti-chevron-right adx-quick-arrow"></i>
        </a>

        <a href="{{ route('admin.reports') }}" class="adx-quick">
            <div class="adx-quick-icon is-green"><i class="ti ti-file-report"></i></div>
            <div class="adx-quick-body">
                <div class="adx-quick-title">Laporan Akhir</div>
                <div class="adx-quick-desc">Review laporan akhir peserta</div>
            </div>
            <i class="ti ti-chevron-right adx-quick-arrow"></i>
        </a>

    </div>

    {{-- ═══ INFO GRID ═══ --}}
    <div class="adx-info-grid">

        <div class="adx-card">
            <h3 class="adx-card-title">Informasi Sistem</h3>
            <div class="adx-info-list">
                <div class="adx-info-row">
                    <span class="adx-info-label">Versi</span>
                    <span class="adx-info-value">1.0.0</span>
                </div>
                <div class="adx-info-row">
                    <span class="adx-info-label">Framework</span>
                    <span class="adx-info-value">Laravel 11 + Livewire</span>
                </div>
                <div class="adx-info-row">
                    <span class="adx-info-label">Database</span>
                    <span class="adx-info-value">MySQL 8+</span>
                </div>
                <div class="adx-info-row">
                    <span class="adx-info-label">Waktu Server</span>
                    <span class="adx-info-value">{{ now()->format('H:i') }} WIB</span>
                </div>
            </div>
        </div>

        <div class="adx-card">
            <h3 class="adx-card-title">Menu Admin</h3>
            <div class="adx-menu-list">
                <a href="{{ route('admin.users') }}" class="adx-menu-link">
                    <i class="ti ti-users"></i>
                    <span>Manajemen Pengguna</span>
                    <i class="ti ti-chevron-right"></i>
                </a>
                <a href="{{ route('admin.logbooks') }}" class="adx-menu-link">
                    <i class="ti ti-notebook"></i>
                    <span>Monitor Logbook</span>
                    <i class="ti ti-chevron-right"></i>
                </a>
                <a href="{{ route('admin.evaluations') }}" class="adx-menu-link">
                    <i class="ti ti-star"></i>
                    <span>Penilaian</span>
                    <i class="ti ti-chevron-right"></i>
                </a>
                <a href="{{ route('admin.testimonials') }}" class="adx-menu-link">
                    <i class="ti ti-message-star"></i>
                    <span>Atur Testimoni</span>
                    <i class="ti ti-chevron-right"></i>
                </a>
            </div>
        </div>

    </div>

</div>

@endsection