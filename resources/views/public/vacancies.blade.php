@extends('layouts.public')
@section('title', 'Lowongan Magang / PKL')

@section('content')
<main class="public-page">
    {{-- Hero Section --}}
    <div class="vac-hero">
        <div class="vac-hero-inner">
            <span class="vac-hero-badge"><i class="ti ti-briefcase"></i> Magang & PKL</span>
            <h1 class="vac-hero-title">Temukan Magang<br>Impianmu</h1>
            <p class="vac-hero-sub">Jelajahi lowongan magang & PKL dari berbagai divisi di Eternal Internship</p>
            <div class="vac-hero-stats">
                <div class="vac-hero-stat">
                    <span class="vac-hero-stat-num">{{ $vacancies->total() }}</span>
                    <span class="vac-hero-stat-lbl">Lowongan Aktif</span>
                </div>
                <div class="vac-hero-stat-divider"></div>
                <div class="vac-hero-stat">
                    <span class="vac-hero-stat-num">{{ $divisions->count() }}</span>
                    <span class="vac-hero-stat-lbl">Divisi</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="vac-filter-section">
        <form class="vac-search-form" method="GET" action="{{ route('public.vacancies') }}"
              x-data="{ loading: false }" @submit="loading = true">
            <div class="vac-search-bar">
                <i class="ti ti-search vac-search-icon"></i>
                <input type="text" name="search" class="vac-search-input"
                       placeholder="Cari lowongan berdasarkan judul atau divisi..."
                       value="{{ request('search') }}">
                <button type="submit" class="vac-search-btn"
                        :disabled="loading" :class="loading && 'opacity-60 cursor-wait'">
                    <template x-if="!loading"><span>Cari</span></template>
                    <template x-if="loading"><span>Mencari...</span></template>
                </button>
            </div>

            {{-- Division Filter Pills --}}
            @if($divisions->count() > 0)
            <div class="vac-filter-pills">
                <a href="{{ route('public.vacancies') }}" class="vac-pill {{ !request('division') ? 'vac-pill-active' : '' }}">
                    Semua
                </a>
                @foreach($divisions as $div)
                    <a href="{{ route('public.vacancies', array_merge(request()->except('division','page'), ['division' => $div])) }}"
                       class="vac-pill {{ request('division') === $div ? 'vac-pill-active' : '' }}">
                        {{ $div }}
                    </a>
                @endforeach
            </div>
            @endif
        </form>

        {{-- Active Filters --}}
        @if(request('search') || request('division'))
        <div class="vac-active-filters">
            <span class="vac-active-label">Filter aktif:</span>
            @if(request('search'))
                <span class="vac-chip">
                    "{{ request('search') }}"
                    <a href="{{ route('public.vacancies', request()->except('search','page')) }}" class="vac-chip-remove">
                        <i class="ti ti-x"></i>
                    </a>
                </span>
            @endif
            @if(request('division'))
                <span class="vac-chip">
                    {{ request('division') }}
                    <a href="{{ route('public.vacancies', request()->except('division','page')) }}" class="vac-chip-remove">
                        <i class="ti ti-x"></i>
                    </a>
                </span>
            @endif
            <a href="{{ route('public.vacancies') }}" class="vac-clear-all">Hapus semua</a>
        </div>
        @endif
    </div>

    {{-- Vacancy Grid --}}
    @if($vacancies->count() > 0)
        <div class="vac-grid">
            @foreach($vacancies as $vacancy)
            @php
                $daysLeft = now()->diffInDays($vacancy->application_deadline, false);
                $isFull = $vacancy->accepted_applications_count >= $vacancy->quota;
                $quotaPercent = $vacancy->quota > 0 ? round(($vacancy->accepted_applications_count / $vacancy->quota) * 100) : 0;
            @endphp
            <a href="{{ route('public.vacancies.show', $vacancy) }}" class="vac-card" x-data>
                <div class="vac-card-top">
                    <span class="vac-div-badge">{{ $vacancy->division }}</span>
                    @if($isFull)
                        <span class="vac-status-badge vac-status-full">Penuh</span>
                    @elseif($daysLeft >= 0 && $daysLeft <= 3)
                        <span class="vac-status-badge vac-status-urgent">Urgent</span>
                    @else
                        <span class="vac-status-badge vac-status-open">Open</span>
                    @endif
                </div>

                <h2 class="vac-card-title">{{ $vacancy->title }}</h2>
                <p class="vac-card-desc">{!! clean(Str::limit(strip_tags($vacancy->description), 100)) !!}</p>

                {{-- Quota Progress --}}
                <div class="vac-quota">
                    <div class="vac-quota-header">
                        <span class="vac-quota-label">Kuota</span>
                        <span class="vac-quota-count">{{ $vacancy->accepted_applications_count }} / {{ $vacancy->quota }}</span>
                    </div>
                    <div class="vac-quota-bar">
                        <div class="vac-quota-fill {{ $isFull ? 'vac-quota-full' : ($quotaPercent > 70 ? 'vac-quota-high' : '') }}"
                             style="width: {{ min($quotaPercent, 100) }}%"></div>
                    </div>
                </div>

                <div class="vac-card-footer">
                    <div class="vac-deadline">
                        <i class="ti ti-calendar-event"></i>
                        @if($daysLeft >= 0 && $daysLeft <= 7)
                            <span class="vac-deadline-urgent">{{ $daysLeft == 0 ? 'Hari ini hari terakhir!' : $daysLeft . ' hari lagi' }}</span>
                        @else
                            <span>Deadline: {{ $vacancy->application_deadline->format('d M Y') }}</span>
                        @endif
                    </div>
                    <span class="vac-card-link">
                        Lihat Detail <i class="ti ti-arrow-right"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        @if(method_exists($vacancies, 'links'))
        <div class="pagination-wrap pagination-wrap-center">
            {{ $vacancies->withQueryString()->links('components.pagination', ['paginator' => $vacancies]) }}
        </div>
        @endif
    @else
    <div class="vac-empty">
        <div class="vac-empty-icon">
            <i class="ti ti-search-off"></i>
        </div>
        <h3 class="vac-empty-title">Tidak ada lowongan ditemukan</h3>
        <p class="vac-empty-desc">Coba kata kunci lain atau lihat semua lowongan yang tersedia.</p>
        <div class="vac-empty-actions">
            <a href="{{ route('public.vacancies') }}" class="vac-btn vac-btn-primary">
                <i class="ti ti-refresh"></i> Tampilkan Semua
            </a>
        </div>
    </div>
    @endif
</main>
@endsection
