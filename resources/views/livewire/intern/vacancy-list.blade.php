<div>
    {{-- ===== BREADCRUMB ===== --}}
    <div class="vc-hero-breadcrumb">
        <div class="breadcrumb">
            <a href="{{ route('intern.dashboard') }}">Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <span>Lowongan</span>
        </div>
    </div>

    {{-- ===== HERO (sama seperti public) ===== --}}
    <div class="vac-hero">
        <div class="vac-hero-inner">
            <span class="vac-hero-badge"><i class="ti ti-briefcase"></i> Magang & PKL</span>
            <h1 class="vac-hero-title">Temukan Magang<br>Impianmu</h1>
            <p class="vac-hero-sub">Jelajahi lowongan magang & PKL dari berbagai divisi di Eternal Internship</p>
            <div class="vac-hero-stats">
                <div class="vac-hero-stat">
                    <span class="vac-hero-stat-num">{{ $totalCount }}</span>
                    <span class="vac-hero-stat-lbl">Lowongan Aktif</span>
                </div>
                <div class="vac-hero-stat-divider"></div>
                <div class="vac-hero-stat">
                    <span class="vac-hero-stat-num">{{ $divisionCount }}</span>
                    <span class="vac-hero-stat-lbl">Divisi</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== SEARCH & FILTER (sama seperti public) ===== --}}
    <div class="vac-filter-section">
        <div class="vac-search-bar">
            <i class="ti ti-search vac-search-icon"></i>
            <input wire:model.live.debounce.300ms="search" type="text" class="vac-search-input"
                   placeholder="Cari lowongan berdasarkan judul atau divisi...">
        </div>

        @if(count($divisions) > 0)
        <div class="vac-filter-pills">
            <button type="button" wire:click="$set('filterDivision', '')" class="vac-pill {{ !$filterDivision ? 'vac-pill-active' : '' }}">
                Semua
            </button>
            @foreach($divisions as $div)
                <button type="button" wire:click="$set('filterDivision', '{{ $div }}')" class="vac-pill {{ $filterDivision === $div ? 'vac-pill-active' : '' }}">
                    {{ $div }}
                </button>
            @endforeach
        </div>
        @endif

        @if($search || $filterDivision)
        <div class="vac-active-filters">
            <span class="vac-active-label">Filter aktif:</span>
            @if($search)
                <span class="vac-chip">
                    "{{ $search }}"
                    <button type="button" wire:click="$set('search', '')" class="vac-chip-remove">
                        <i class="ti ti-x"></i>
                    </button>
                </span>
            @endif
            @if($filterDivision)
                <span class="vac-chip">
                    {{ $filterDivision }}
                    <button type="button" wire:click="$set('filterDivision', '')" class="vac-chip-remove">
                        <i class="ti ti-x"></i>
                    </button>
                </span>
            @endif
            <button type="button" wire:click="resetFilters" class="vac-clear-all">Hapus semua</button>
        </div>
        @endif
    </div>

    {{-- ===== SKELETON ===== --}}
    <div wire:loading class="vac-grid">
        @for($i = 0; $i < 6; $i++)
        <div class="vac-card">
            <div class="vac-card-top">
                <div class="skeleton" style="width:80px;height:22px;border-radius:6px"></div>
                <div class="skeleton" style="width:50px;height:22px;border-radius:6px"></div>
            </div>
            <div class="skeleton-text skeleton-text-lg" style="width:80%;margin-bottom:8px"></div>
            <div class="skeleton-text" style="width:100%;margin-bottom:4px"></div>
            <div class="skeleton-text" style="width:100%;margin-bottom:4px"></div>
            <div class="skeleton-text" style="width:60%"></div>
            <div class="skeleton" style="width:100%;height:6px;border-radius:6px;margin:16px 0 8px"></div>
            <div class="skeleton-text skeleton-text-sm" style="width:50%"></div>
        </div>
        @endfor
    </div>

    {{-- ===== GRID LOWONGAN (sama seperti public) ===== --}}
    <div wire:loading.remove>
        @if(count($vacancies) > 0)
            <div class="vac-grid">
                @foreach($vacancies as $vacancy)
                @php
                    $daysLeft = (int) now()->startOfDay()->diffInDays($vacancy->application_deadline);
                    $filled = min($vacancy->accepted_applications_count, $vacancy->quota);
                    $quotaPct = $vacancy->quota > 0 ? round($filled / $vacancy->quota * 100) : 0;
                    $isFull = $vacancy->accepted_applications_count >= $vacancy->quota;
                @endphp
                <a href="{{ route('intern.vacancies.show', $vacancy->id) }}" class="vac-card" wire:navigate x-data>
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

                    <div class="vac-quota">
                        <div class="vac-quota-header">
                            <span class="vac-quota-label">Kuota</span>
                            <span class="vac-quota-count">{{ $filled }} / {{ $vacancy->quota }}</span>
                        </div>
                        <div class="vac-quota-bar">
                            <div class="vac-quota-fill {{ $isFull ? 'vac-quota-full' : ($quotaPct > 70 ? 'vac-quota-high' : '') }}"
                                 style="width: {{ min($quotaPct, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="vac-card-footer">
                        <div class="vac-deadline">
                            <i class="ti ti-calendar-event"></i>
                            @if($daysLeft >= 0 && $daysLeft <= 7)
                                <span class="vac-deadline-urgent">{{ $daysLeft == 0 ? 'Hari ini hari terakhir!' : $daysLeft . ' hari lagi' }}</span>
                            @else
                                <span>Deadline: {{ $vacancy->application_deadline?->format('d M Y') }}</span>
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
                {{ $vacancies->links('components.pagination', ['paginator' => $vacancies]) }}
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
                    <button wire:click="resetFilters" class="vac-btn vac-btn-primary">
                        <i class="ti ti-refresh"></i> Tampilkan Semua
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
