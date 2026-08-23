@extends('layouts.app')
@section('title', 'Detail Lamaran')
@php $pageTitle = 'Detail Lamaran'; @endphp

@section('content')
{{-- ===== HERO RINGAN ===== --}}
<div class="vc-hero">
    <div class="vc-hero-main">
        <div class="breadcrumb">
            <a href="{{ route('intern.applications') }}">Lamaran</a>
            <i class="ti ti-chevron-right"></i>
            <span>Detail</span>
        </div>
        <h1 class="vc-hero-title">Detail Lamaran</h1>
        <p class="vc-hero-sub">Rincian lamaran magang kamu</p>
    </div>
    <div class="vc-hero-stats">
        <span class="stat-chip">
            <i class="ti ti-clock"></i>
            Dikirim {{ $application->applied_at?->diffForHumans() ?? '—' }}
        </span>
    </div>
</div>

@php
    $status = $application->status;
    $canCancel = in_array($status, ['submitted', 'under_review', 'interview_scheduled'], true);
    $stepStatuses = ['submitted', 'under_review', 'interview_scheduled'];
    $currentStep = $canCancel ? array_search($status, $stepStatuses, true) : -1;
@endphp

<div class="ap-detail">
    {{-- ===== KARTU STATUS ===== --}}
    <div class="panel ap-card">
        <div class="ap-card-head">
            <div class="ap-avatar ap-st-{{ $status }}">
                <i class="ti ti-briefcase"></i>
            </div>
            <div class="ap-card-main">
                <h2 class="ap-card-title">{{ $application->vacancy->title ?? '—' }}</h2>
                <p class="ap-card-meta">{{ $application->vacancy->division ?? '—' }}</p>
            </div>
            <x-badge :status="$status" />
        </div>

        @if($canCancel)
            <ol class="ap-stepper" aria-label="Progres lamaran">
                @foreach($stepStatuses as $i => $step)
                    @php
                        $state = $i < $currentStep ? 'done' : ($i === $currentStep ? 'active' : '');
                    @endphp
                    <li class="ap-step {{ $state ? 'ap-step-' . $state : '' }}">
                        <span class="ap-step-dot">
                            @if($i < $currentStep)
                                <i class="ti ti-check"></i>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </span>
                        <span class="ap-step-label">{{ ['submitted' => 'Terkirim', 'under_review' => 'Direview', 'interview_scheduled' => 'Interview'][$step] }}</span>
                    </li>
                @endforeach
            </ol>
        @endif

        @if($status === 'accepted')
            <div class="ap-note ap-note-success">
                <i class="ti ti-circle-check"></i>
                <span>Selamat, lamaran kamu diterima!</span>
            </div>
        @elseif($status === 'rejected' && $application->rejection_reason)
            <div class="ap-note ap-note-danger">
                <i class="ti ti-alert-triangle"></i>
                <span>Alasan: {{ $application->rejection_reason }}</span>
            </div>
        @elseif($status === 'cancelled')
            <div class="ap-note ap-note-muted">
                <i class="ti ti-x"></i>
                <span>Lamaran dibatalkan.</span>
            </div>
        @endif

        @if($status === 'interview_scheduled' && $application->interview_date)
            <div class="ap-note ap-note-violet">
                <i class="ti ti-calendar-time"></i>
                <span>Interview dijadwalkan: {{ $application->interview_date->format('d M Y H:i') }}</span>
            </div>
        @endif

        @if($status === 'accepted' && $application->internship)
            <div class="ap-note ap-note-success">
                <i class="ti ti-rocket"></i>
                <span>
                    Kamu sudah tercatat sebagai peserta magang.
                    <a href="{{ route('intern.internship') }}" class="ap-note-link">Lihat detail magang →</a>
                </span>
            </div>
        @endif
    </div>

    {{-- ===== KARTU INFO ===== --}}
    <div class="panel ap-info">
        <h3 class="ap-info-title">
            <i class="ti ti-info-circle"></i> Informasi Lamaran
        </h3>
        <dl class="ap-info-list">
            <div class="ap-info-row">
                <dt><i class="ti ti-calendar"></i> Tanggal Daftar</dt>
                <dd>{{ $application->applied_at?->format('d M Y, H:i') ?? '—' }}</dd>
            </div>
            <div class="ap-info-row">
                <dt><i class="ti ti-list-details"></i> Status</dt>
                <dd><x-badge :status="$status" /></dd>
            </div>
            @if($application->interview_date)
            <div class="ap-info-row">
                <dt><i class="ti ti-calendar-time"></i> Jadwal Interview</dt>
                <dd class="ap-info-violet">{{ $application->interview_date->format('d M Y, H:i') }}</dd>
            </div>
            @endif
            @if($application->rejection_reason)
            <div class="ap-info-row">
                <dt><i class="ti ti-alert-triangle"></i> Alasan Ditolak</dt>
                <dd class="ap-info-danger">{{ $application->rejection_reason }}</dd>
            </div>
            @endif
            @if($application->admin_notes)
            <div class="ap-info-row">
                <dt><i class="ti ti-message-circle"></i> Catatan Admin</dt>
                <dd>{{ $application->admin_notes }}</dd>
            </div>
            @endif
        </dl>
    </div>

    <div class="ap-detail-actions">
        <a href="{{ route('intern.applications') }}" class="btn-secondary">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection