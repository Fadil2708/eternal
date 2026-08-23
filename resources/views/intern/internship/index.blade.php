@extends('layouts.app')
@section('title', 'Detail Magang')
@php $pageTitle = 'Detail Magang'; @endphp

@push('styles')
<style>
    /* ===== DETAIL MAGANG ===== */
    :root {
        --primary: #3155e7;
        --primary-dark: #2444c9;
        --primary-light: #eef2ff;
        --text: #111936;
        --text-secondary: #64708a;
        --border: #e5e7eb;
        --radius: 14px;
        --radius-sm: 10px;
        --shadow-sm: 0 1px 3px rgba(15, 23, 42, .06);
        --shadow-md: 0 4px 12px rgba(15, 23, 42, .08);
        --shadow-lg: 0 10px 30px rgba(15, 23, 42, .10);
    }

    .int-wrap {
        max-width: 860px;
        margin: 0 auto;
    }

    /* ===== HERO CARD ===== */
    .int-hero {
        position: relative;
        border-radius: var(--radius);
        overflow: hidden;
        background: linear-gradient(135deg, #0a1628 0%, #12294f 55%, #2444c9 130%);
        color: #fff;
        box-shadow: var(--shadow-lg);
    }

    .int-hero::after {
        content: '';
        position: absolute;
        right: -80px;
        top: -80px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99, 118, 247, .35) 0%, transparent 70%);
        pointer-events: none;
    }

    .int-hero-body {
        position: relative;
        padding: 26px 28px;
        z-index: 1;
    }

    .int-hero-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 18px;
    }

    .int-hero-title {
        font-size: 21px;
        font-weight: 700;
        margin: 0 0 4px;
        line-height: 1.3;
    }

    .int-hero-sub {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: rgba(255, 255, 255, .65);
        margin: 0;
    }

    .int-hero-sub i {
        font-size: 15px;
    }

    .int-hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .int-hero-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 13px;
        border-radius: 99px;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .14);
        backdrop-filter: blur(4px);
        font-size: 12px;
        font-weight: 500;
    }

    .int-hero-meta-item i {
        font-size: 15px;
        color: #93a5ff;
    }

    /* ===== CARD SHELL ===== */
    .int-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        margin-top: 20px;
    }

    .int-card-head {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
    }

    .int-card-head i {
        font-size: 20px;
        color: var(--primary);
    }

    .int-card-head h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .int-card-body {
        padding: 22px 24px;
    }

    /* ===== PROGRESS TIMELINE ===== */
    .int-steps {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        position: relative;
    }

    .int-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 8px;
        position: relative;
        padding: 0 6px;
    }

    .int-step::before {
        content: '';
        position: absolute;
        top: 21px;
        left: -50%;
        width: 100%;
        height: 3px;
        background: var(--border);
    }

    .int-step:first-child::before {
        display: none;
    }

    .int-step-dot {
        position: relative;
        z-index: 1;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b6c0d4;
        font-size: 18px;
        transition: all .25s ease;
    }

    .int-step.done .int-step-dot {
        border-color: #34c17b;
        background: #e9faf2;
        color: #0f8a52;
    }

    .int-step.done::before {
        background: #34c17b;
    }

    .int-step-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .int-step.done .int-step-label {
        color: #0f8a52;
    }

    /* ===== INFO GRID ===== */
    .int-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px 28px;
    }

    .int-info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .int-info-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #98a2b3;
    }

    .int-info-label i {
        font-size: 14px;
    }

    .int-info-value {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }

    /* ===== MENU GRID ===== */
    .int-menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .int-menu-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 18px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        text-decoration: none;
        transition: all .2s ease;
    }

    .int-menu-item:hover {
        border-color: #c7d2fe;
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .int-menu-icon {
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .int-menu-info {
        flex: 1;
        min-width: 0;
    }

    .int-menu-info h4 {
        font-size: 14px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 3px;
    }

    .int-menu-info p {
        font-size: 12px;
        color: var(--text-secondary);
        margin: 0;
    }

    .int-menu-arrow {
        color: #b6c0d4;
        font-size: 18px;
        align-self: center;
        transition: transform .2s ease, color .2s ease;
    }

    .int-menu-item:hover .int-menu-arrow {
        color: var(--primary);
        transform: translateX(3px);
    }

    .int-menu-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
        padding: 3px 9px;
        border-radius: 99px;
        font-size: 10px;
        font-weight: 700;
    }

    .int-menu-chip.ok {
        background: #e9faf2;
        color: #0f8a52;
    }

    .int-menu-chip.wait {
        background: #f1f3f9;
        color: #64708a;
    }

    .int-menu-chip.now {
        background: var(--primary-light);
        color: var(--primary);
    }

    /* ===== EMPTY STATE ===== */
    .int-empty {
        padding: 56px 24px;
        text-align: center;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
    }

    .int-empty-sub {
        font-size: 13px;
        color: var(--text-secondary);
        margin: 12px 0 20px;
    }

    .int-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: var(--radius-sm);
        background: var(--primary);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s ease;
    }

    .int-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 720px) {
        .int-steps { grid-template-columns: repeat(2, 1fr); gap: 20px 12px; }
        .int-step::before { display: none; }
        .int-info-grid { grid-template-columns: 1fr; }
        .int-menu-grid { grid-template-columns: 1fr; }
        .int-hero-top { flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="int-wrap">

    @if(!isset($internship) || !$internship)

        <div class="int-empty">
            <x-empty-state icon="ti-clipboard-list" message="Kamu belum memiliki magang aktif." />
            <p class="int-empty-sub">
                Status lamaran kamu bisa dicek di halaman Lamaran Saya.
            </p>
            <a href="{{ route('intern.applications') }}" class="int-btn">
                <i class="ti ti-arrow-right"></i> Lihat Lamaran Saya
            </a>
        </div>

    @else

        @php
            $startDate = ($internship->actual_start_date ?? $internship->vacancy?->start_date)?->format('d M Y') ?? '—';
            $endDate   = ($internship->actual_end_date ?? $internship->vacancy?->end_date)?->format('d M Y') ?? '—';
            $position  = $internship->vacancy?->title ?? '—';
            $division  = $internship->vacancy?->division ?? '—';
            $supervisor = $internship->supervisor;

            $steps = [
                ['label' => 'Logbook',    'done' => ($internship->approved_logbooks_count ?? 0) > 0],
                ['label' => 'Laporan',    'done' => (bool) $internship->finalReport],
                ['label' => 'Evaluasi',   'done' => (bool) $internship->evaluation],
                ['label' => 'Sertifikat', 'done' => (bool) $internship->certificate],
            ];
        @endphp

        {{-- HERO --}}
        <div class="int-hero">
            <div class="int-hero-body">
                <div class="int-hero-top">
                    <div>
                        <h2 class="int-hero-title">{{ $position }}</h2>
                        @if($division !== '—')
                            <p class="int-hero-sub">
                                <i class="ti ti-building"></i> {{ $division }}
                            </p>
                        @endif
                    </div>
                    <x-badge :status="$internship->status" />
                </div>

                <div class="int-hero-meta">
                    <span class="int-hero-meta-item">
                        <i class="ti ti-calendar-event"></i> Mulai: {{ $startDate }}
                    </span>
                    <span class="int-hero-meta-item">
                        <i class="ti ti-calendar-x"></i> Selesai: {{ $endDate }}
                    </span>
                </div>
            </div>
        </div>

        {{-- PROGRESS --}}
        <div class="int-card">
            <div class="int-card-head">
                <i class="ti ti-chart-dots"></i>
                <h3>Progres Magang</h3>
            </div>
            <div class="int-card-body">
                <div class="int-steps">
                    @foreach($steps as $step)
                        <div class="int-step {{ $step['done'] ? 'done' : '' }}">
                            <div class="int-step-dot">
                                <i class="ti {{ $step['done'] ? 'ti-check' : 'ti-circle-dashed' }}"></i>
                            </div>
                            <div class="int-step-label">{{ $step['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- INFO --}}
        <div class="int-card">
            <div class="int-card-head">
                <i class="ti ti-info-circle"></i>
                <h3>Informasi Magang</h3>
            </div>
            <div class="int-card-body">
                <div class="int-info-grid">
                    <div class="int-info-item">
                        <span class="int-info-label"><i class="ti ti-calendar-event"></i> Tanggal Mulai</span>
                        <span class="int-info-value">{{ $startDate }}</span>
                    </div>
                    <div class="int-info-item">
                        <span class="int-info-label"><i class="ti ti-calendar-x"></i> Tanggal Selesai</span>
                        <span class="int-info-value">{{ $endDate }}</span>
                    </div>
                    <div class="int-info-item">
                        <span class="int-info-label"><i class="ti ti-flag"></i> Status</span>
                        <span class="int-info-value"><x-badge :status="$internship->status" /></span>
                    </div>
                    <div class="int-info-item">
                        <span class="int-info-label"><i class="ti ti-briefcase"></i> Posisi</span>
                        <span class="int-info-value">{{ $position }}@if($division !== '—') ({{ $division }})@endif</span>
                    </div>
                    @if($supervisor)
                    <div class="int-info-item">
                        <span class="int-info-label"><i class="ti ti-user-check"></i> Pembimbing</span>
                        <span class="int-info-value">
                            <x-avatar :name="$supervisor->displayName()" :size="30" :font-size="12" />
                            {{ $supervisor->displayName() }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- MENU MAGANG --}}
        <div class="int-card">
            <div class="int-card-head">
                <i class="ti ti-layout-grid"></i>
                <h3>Menu Magang</h3>
            </div>
            <div class="int-card-body">
                <div class="int-menu-grid">
                    <a href="{{ route('intern.logbooks') }}" class="int-menu-item">
                        <div class="int-menu-icon"><i class="ti ti-notebook"></i></div>
                        <div class="int-menu-info">
                            <h4>Logbook</h4>
                            <p>Catatan kegiatan harian</p>
                            @php
                                $lb = $internship->logbooks_count ?? 0;
                                $lbOk = $internship->approved_logbooks_count ?? 0;
                            @endphp
                            @if($lbOk > 0)
                                <span class="int-menu-chip ok"><i class="ti ti-check"></i> {{ $lbOk }} disetujui</span>
                            @elseif($lb > 0)
                                <span class="int-menu-chip wait">{{ $lb }} menunggu review</span>
                            @else
                                <span class="int-menu-chip now">Belum diisi</span>
                            @endif
                        </div>
                        <i class="ti ti-chevron-right int-menu-arrow"></i>
                    </a>

                    <a href="{{ route('intern.reports') }}" class="int-menu-item">
                        <div class="int-menu-icon"><i class="ti ti-file-report"></i></div>
                        <div class="int-menu-info">
                            <h4>Laporan Akhir</h4>
                            <p>Laporan hasil magang</p>
                            @if($internship->finalReport)
                                <span class="int-menu-chip ok"><i class="ti ti-check"></i> Terkirim</span>
                            @else
                                <span class="int-menu-chip now">Belum diunggah</span>
                            @endif
                        </div>
                        <i class="ti ti-chevron-right int-menu-arrow"></i>
                    </a>

                    <a href="{{ route('intern.evaluation') }}" class="int-menu-item">
                        <div class="int-menu-icon"><i class="ti ti-star"></i></div>
                        <div class="int-menu-info">
                            <h4>Nilai</h4>
                            <p>Hasil evaluasi pembimbing</p>
                            @if($internship->evaluation)
                                <span class="int-menu-chip ok"><i class="ti ti-check"></i> Selesai</span>
                            @else
                                <span class="int-menu-chip wait">Belum dinilai</span>
                            @endif
                        </div>
                        <i class="ti ti-chevron-right int-menu-arrow"></i>
                    </a>

                    <a href="{{ route('intern.certificate') }}" class="int-menu-item">
                        <div class="int-menu-icon"><i class="ti ti-certificate"></i></div>
                        <div class="int-menu-info">
                            <h4>Sertifikat</h4>
                            <p>Bukti kelulusan magang</p>
                            @if($internship->certificate)
                                <span class="int-menu-chip ok"><i class="ti ti-check"></i> Siap diunduh</span>
                            @else
                                <span class="int-menu-chip wait">Belum tersedia</span>
                            @endif
                        </div>
                        <i class="ti ti-chevron-right int-menu-arrow"></i>
                    </a>
                </div>
            </div>
        </div>

    @endif

</div>
@endsection