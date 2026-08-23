@extends('layouts.app')
@section('title', 'Dashboard Peserta')
@php $pageTitle = 'Dashboard'; @endphp

@push('styles')
<style>
    /* ===== DASHBOARD CUSTOM STYLES ===== */
    :root {
        --primary: #3155e7;
        --primary-dark: #2444c9;
        --primary-light: #eef2ff;
        --text: #111936;
        --text-secondary: #64708a;
        --border: #e5e7eb;
        --radius: 12px;
        --radius-sm: 8px;
        --shadow-sm: 0 1px 3px rgba(15,23,42,.06);
        --shadow-md: 0 4px 12px rgba(15,23,42,.08);
    }

    .dash-welcome {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
    }

    .dash-welcome h1 {
        font-size: 20px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 4px;
    }

    .dash-welcome p {
        font-size: 13px;
        color: var(--text-secondary);
        margin: 0;
    }

    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: var(--radius-sm);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* ===== STAT CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        min-height: 140px;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(15,23,42,.05);
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .stat-title {
        font-size: 12px;
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: var(--text);
        line-height: 1.1;
    }

    .stat-value small {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .icon-blue { background: #edf2ff; color: var(--primary); }
    .icon-green { background: #ecfdf5; color: #059669; }
    .icon-orange { background: #fff7ed; color: #ea580c; }
    .icon-purple { background: #f4f0ff; color: #7c3aed; }

    .stat-bottom {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        color: var(--text-secondary);
    }

    .stat-bottom .success { color: #059669; font-weight: 600; }
    .stat-bottom .warning { color: #d97706; font-weight: 600; }
    .stat-bottom .info { color: var(--primary); font-weight: 600; }

    /* ===== PROGRESS & MENU ROW ===== */
    .content-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
    }

    /* ===== QUICK MENU ===== */
    .quick-menu-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .quick-menu-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 18px 12px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        text-decoration: none;
        color: var(--text);
        font-size: 12px;
        font-weight: 500;
        transition: all .2s ease;
        background: #fff;
    }

    .quick-menu-item:hover {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .quick-menu-item i {
        font-size: 22px;
        color: var(--primary);
    }

    /* ===== PROGRESS BAR ===== */
    .progress-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .progress-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .progress-caption {
        font-size: 11px;
        color: #98a2b3;
    }

    .progress-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
    }

    .progress-name {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text);
        font-weight: 500;
    }

    .mini-icon {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        flex-shrink: 0;
    }

    .progress-pct {
        font-weight: 600;
        color: var(--text-secondary);
    }

    .progress-bar {
        height: 6px;
        background: #f1f5f9;
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 99px;
        transition: width .6s ease;
    }

    /* ===== ANNOUNCEMENT ===== */
    .announcement-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 20px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 16px;
        transition: box-shadow .2s ease;
    }

    .announcement-card:hover {
        box-shadow: var(--shadow-sm);
    }

    .announcement-icon {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: var(--primary-light);
        color: var(--primary);
        font-size: 16px;
    }

    .announcement-content {
        flex: 1;
    }

    .announcement-content strong {
        display: block;
        font-size: 11px;
        margin-bottom: 2px;
        color: var(--text);
    }

    .announcement-content span {
        font-size: 12px;
        color: var(--text-secondary);
    }

    /* ===== HERO CARD (Status) ===== */
    .hero-card {
        border-radius: var(--radius);
        padding: 28px 24px;
        margin-bottom: 24px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
    }

    .hero-card-content {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .hero-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
        background: rgba(255,255,255,.15);
        color: #fff;
    }

    .hero-text .hero-title {
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .hero-text .hero-desc {
        font-size: 13px;
        opacity: .8;
        margin: 0;
    }

    .hero-actions {
        margin-left: auto;
        flex-shrink: 0;
    }

    .hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        background: #fff;
        color: var(--primary);
        border: none;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all .2s ease;
    }

    .hero-btn:hover {
        background: #f0f0ff;
        transform: translateY(-1px);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .content-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr; }
        .dash-welcome { flex-direction: column; }
        .quick-menu-grid { grid-template-columns: repeat(2, 1fr); }
        .hero-card-content { flex-direction: column; text-align: center; }
        .hero-actions { margin-left: 0; }
    }
</style>
@endpush

@section('content')

{{-- WELCOME --}}
<div class="dash-welcome">
    <div>
        <h1>Selamat datang, {{ auth()->user()->internProfile?->full_name ?? 'Peserta' }} 👋</h1>
        <p>Semangat menjalani hari ini! Terus catat, belajar, dan berkembang.</p>
    </div>
    <div class="date-badge">
        <i class="ti ti-calendar"></i>
        {{ now()->translatedFormat('l, d M Y') }}
    </div>
</div>

{{-- LIVEWIRE STATS --}}
<livewire:intern.dashboard-stats />

{{-- QUICK MENU + PROGRESS --}}
<div class="content-row">

    {{-- QUICK MENU --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Menu Cepat</span>
        </div>
        <div class="quick-menu-grid">
            <a href="{{ route('intern.internship') }}" class="quick-menu-item">
                <i class="ti ti-briefcase"></i>
                <span>Magang Saya</span>
            </a>
            <a href="{{ route('intern.logbooks') }}" class="quick-menu-item">
                <i class="ti ti-notebook"></i>
                <span>Logbook</span>
            </a>
            <a href="{{ route('intern.reports') }}" class="quick-menu-item">
                <i class="ti ti-file-report"></i>
                <span>Laporan</span>
            </a>
            <a href="{{ route('intern.applications') }}" class="quick-menu-item">
                <i class="ti ti-file-description"></i>
                <span>Lamaran</span>
            </a>
            <a href="{{ route('intern.evaluation') }}" class="quick-menu-item">
                <i class="ti ti-star"></i>
                <span>Nilai</span>
            </a>
            <a href="{{ route('intern.certificate') }}" class="quick-menu-item">
                <i class="ti ti-certificate"></i>
                <span>Sertifikat</span>
            </a>
            <a href="{{ route('intern.testimonials.create') }}" class="quick-menu-item">
                <i class="ti ti-message-star"></i>
                <span>Testimoni</span>
            </a>
            <a href="{{ route('intern.profile') }}" class="quick-menu-item">
                <i class="ti ti-user"></i>
                <span>Profil</span>
            </a>
        </div>
    </div>

    {{-- PROGRESS PROGRAM --}}
    <livewire:intern.program-progress />

</div>

@endsection
