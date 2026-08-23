@extends('layouts.app')
@section('title', 'Dashboard Pembimbing')
@php $pageTitle = 'Dashboard Pembimbing'; @endphp

@section('content')
<style>
    .sdv-root {
        --sdv-primary: #3155e7;
        --sdv-primary-dark: #2444c9;
        --sdv-primary-light: #eef2ff;
        --sdv-text: #111936;
        --sdv-muted: #64708a;
        --sdv-border: #e5e7eb;
        --sdv-amber: #d97706;
        --sdv-amber-bg: #fffbeb;
        --sdv-green: #16a34a;
        --sdv-green-bg: #ecfdf5;
        --sdv-red: #dc2626;
        --sdv-red-bg: #fef2f2;
    }

    /* ═══ HEADER ═══ */
    .sdv-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 22px;
    }
    .sdv-title {
        font-size: 22px;
        font-weight: 800;
        color: var(--sdv-text);
        margin: 2px 0 4px;
        line-height: 1.3;
    }
    .sdv-sub {
        font-size: 13px;
        color: var(--sdv-muted);
        margin: 0;
    }
    .sdv-date-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        border-radius: 11px;
        background: var(--sdv-primary-light);
        border: 1px solid #dbe3fb;
        color: var(--sdv-primary-dark);
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }
    .sdv-date-badge i { font-size: 15px; }

    /* ═══ STAT GRID (Livewire) ═══ */
    .sdv-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }
    .sdv-stat {
        background: #fff;
        border: 1px solid var(--sdv-border);
        border-radius: 14px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: box-shadow .15s ease, transform .15s ease;
    }
    .sdv-stat:hover { box-shadow: 0 6px 18px rgba(17, 25, 54, .08); transform: translateY(-2px); }
    .sdv-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }
    .sdv-stat-icon.is-blue  { background: var(--sdv-primary-light); color: var(--sdv-primary); }
    .sdv-stat-icon.is-amber { background: var(--sdv-amber-bg); color: var(--sdv-amber); }
    .sdv-stat-icon.is-green { background: var(--sdv-green-bg); color: var(--sdv-green); }
    .sdv-stat-value {
        font-size: 24px;
        font-weight: 800;
        color: var(--sdv-text);
        line-height: 1.1;
    }
    .sdv-stat-label {
        font-size: 11px;
        color: var(--sdv-muted);
        margin-top: 2px;
    }

    /* ═══ PROGRESS CARD (Livewire) ═══ */
    .sdv-card {
        background: #fff;
        border: 1px solid var(--sdv-border);
        border-radius: 14px;
        padding: 22px 24px;
        margin-bottom: 20px;
    }
    .sdv-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }
    .sdv-card-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--sdv-text);
        margin: 0;
    }
    .sdv-bar {
        display: flex;
        gap: 2px;
        height: 22px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 14px;
        background: #e2e8f0;
    }
    .sdv-bar-seg { transition: width .5s ease; }
    .sdv-legend {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    .sdv-legend-item { display: flex; align-items: center; gap: 8px; }
    .sdv-legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }
    .sdv-legend-name { font-size: 11px; color: var(--sdv-text); font-weight: 600; }
    .sdv-legend-count { display: block; font-size: 11px; color: var(--sdv-muted); margin-top: 1px; }

    /* ═══ QUICK ACTIONS ═══ */
    .sdv-quick-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }
    .sdv-quick {
        position: relative;
        display: flex;
        align-items: center;
        gap: 14px;
        background: #fff;
        border: 1px solid var(--sdv-border);
        border-radius: 14px;
        padding: 18px;
        text-decoration: none;
        transition: box-shadow .15s ease, transform .15s ease, border-color .15s ease;
    }
    .sdv-quick:hover {
        box-shadow: 0 6px 18px rgba(17, 25, 54, .08);
        transform: translateY(-2px);
        border-color: var(--sdv-primary);
    }
    .sdv-quick-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        background: var(--sdv-primary-light);
        color: var(--sdv-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }
    .sdv-quick-body { flex: 1; min-width: 0; }
    .sdv-quick-title {
        font-size: 14px;
        font-weight: 800;
        color: var(--sdv-text);
        margin: 0 0 3px;
    }
    .sdv-quick-desc {
        font-size: 12px;
        color: var(--sdv-muted);
        margin: 0;
        line-height: 1.45;
    }
    .sdv-quick-arrow { color: var(--sdv-primary); font-size: 17px; flex-shrink: 0; }

    /* ═══ ACTIVITY ═══ */
    .sdv-activity-list { display: flex; flex-direction: column; }
    .sdv-activity-link {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 13px 4px;
        text-decoration: none;
        border-bottom: 1px solid var(--sdv-border);
    }
    .sdv-activity-link:last-of-type { border-bottom: none; }
    .sdv-activity-link:hover { background: #f8fafc; }
    .sdv-activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: var(--sdv-primary-light);
        color: var(--sdv-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .sdv-activity-body { flex: 1; min-width: 0; }
    .sdv-activity-name {
        font-size: 13px;
        font-weight: 700;
        color: var(--sdv-text);
        margin: 0;
    }
    .sdv-activity-meta {
        font-size: 12px;
        color: var(--sdv-muted);
        margin: 2px 0 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .sdv-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        background: var(--sdv-primary-light);
        color: var(--sdv-primary);
        flex-shrink: 0;
    }
    .sdv-activity-empty {
        text-align: center;
        padding: 34px 20px;
    }
    .sdv-activity-empty i {
        font-size: 38px;
        color: var(--sdv-green);
        display: block;
        margin-bottom: 10px;
    }
    .sdv-activity-empty p {
        font-size: 13px;
        color: var(--sdv-muted);
        margin: 0;
    }

    /* ═══ RESPONSIVE ═══ */
    @media (max-width: 1000px) {
        .sdv-stat-grid { grid-template-columns: repeat(2, 1fr); }
        .sdv-legend { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 760px) {
        .sdv-quick-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 520px) {
        .sdv-stat-grid { grid-template-columns: 1fr; }
        .sdv-legend { grid-template-columns: 1fr; }
        .sdv-card { padding: 18px 16px; }
    }
</style>

<div class="sdv-root">

    {{-- ═══ HEADER ═══ --}}
    <div class="sdv-header">
        <div>
            <div class="breadcrumb">
                <span>Dashboard</span>
            </div>
            <h2 class="sdv-title">Dashboard Pembimbing</h2>
            <p class="sdv-sub">Selamat datang, {{ auth()->user()->displayName() ?? 'Supervisor' }}</p>
        </div>
        <div class="sdv-date-badge">
            <i class="ti ti-calendar"></i>
            {{ now()->translatedFormat('l, d M Y') }}
        </div>
    </div>

    {{-- ═══ STATS (Livewire) ═══ --}}
    <livewire:supervisor.dashboard-stats />

    {{-- ═══ QUICK ACTIONS ═══ --}}
    <div class="sdv-card-head" style="margin-bottom:12px">
        <h3 class="sdv-card-title">Aksi Cepat</h3>
    </div>
    <div class="sdv-quick-grid">
        <a href="{{ route('supervisor.logbooks') }}" class="sdv-quick">
            <div class="sdv-quick-icon"><i class="ti ti-notebook"></i></div>
            <div class="sdv-quick-body">
                <p class="sdv-quick-title">Review Logbook</p>
                <p class="sdv-quick-desc">{{ $pendingLogbooksCount > 0 ? $pendingLogbooksCount . ' logbook menunggu review' : 'Tidak ada logbook tertunda' }}</p>
            </div>
            <i class="ti ti-chevron-right sdv-quick-arrow"></i>
        </a>
        <a href="{{ route('supervisor.reports') }}" class="sdv-quick">
            <div class="sdv-quick-icon"><i class="ti ti-file-description"></i></div>
            <div class="sdv-quick-body">
                <p class="sdv-quick-title">Review Laporan</p>
                <p class="sdv-quick-desc">{{ $pendingReportsCount > 0 ? $pendingReportsCount . ' laporan akhir menunggu' : 'Tidak ada laporan menunggu' }}</p>
            </div>
            <i class="ti ti-chevron-right sdv-quick-arrow"></i>
        </a>
        <a href="{{ route('supervisor.evaluations.create') }}" class="sdv-quick">
            <div class="sdv-quick-icon"><i class="ti ti-clipboard-check"></i></div>
            <div class="sdv-quick-body">
                <p class="sdv-quick-title">Evaluasi Peserta</p>
                <p class="sdv-quick-desc">{{ $pendingEvaluationsCount > 0 ? $pendingEvaluationsCount . ' evaluasi belum diisi' : 'Semua evaluasi sudah diisi' }}</p>
            </div>
            <i class="ti ti-chevron-right sdv-quick-arrow"></i>
        </a>
    </div>

    {{-- ═══ ACTIVITY ═══ --}}
    <div class="sdv-card">
        <div class="sdv-card-head">
            <h3 class="sdv-card-title">Aktivitas Terbaru</h3>
            @if($pendingLogbooksCount > 0)
                <a href="{{ route('supervisor.logbooks') }}" style="font-size:12px;font-weight:700;color:var(--sdv-primary);text-decoration:none">Lihat Semua</a>
            @endif
        </div>
        <div class="sdv-activity-list">
            @forelse($recentLogbooks as $logbook)
            <a href="{{ route('supervisor.logbooks') }}" class="sdv-activity-link">
                <div class="sdv-activity-icon"><i class="ti ti-notebook"></i></div>
                <div class="sdv-activity-body">
                    <p class="sdv-activity-name">{{ $logbook->intern?->internProfile?->full_name ?? $logbook->intern?->email ?? '' }}</p>
                    <p class="sdv-activity-meta">{{ $logbook->activity_date?->isoFormat('D MMM') ?? '—' }} &middot; {{ Str::limit($logbook->activities, 50) }}</p>
                </div>
                <span class="sdv-badge"><i class="ti ti-send"></i> Terkirim</span>
            </a>
            @empty
            <div class="sdv-activity-empty">
                <i class="ti ti-circle-check"></i>
                <p>Semua logbook sudah direview. Tidak ada aktivitas tertunda.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection