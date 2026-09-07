<div>
    {{-- ===== HERO RINGAN ===== --}}
    <div class="vc-hero">
        <div class="vc-hero-main">
            <div class="breadcrumb">
                <a href="{{ route('intern.dashboard') }}">Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Lowongan</span>
            </div>
            <h1 class="vc-hero-title">Daftar Lowongan</h1>
            <p class="vc-hero-sub">Cari dan daftar lowongan magang yang tersedia untukmu</p>
        </div>
        <div class="vc-hero-stats">
            <span class="stat-chip">
                <i class="ti ti-briefcase"></i>
                <strong>{{ $totalCount }}</strong> lowongan terbuka
            </span>
            <span class="stat-chip">
                <i class="ti ti-building"></i>
                <strong>{{ $divisionCount }}</strong> divisi
            </span>
            @if($nearestDeadline)
                <span class="stat-chip stat-chip-accent">
                    <i class="ti ti-calendar-due"></i>
                    Tenggat terdekat: {{ \Illuminate\Support\Carbon::parse($nearestDeadline)->format('d M Y') }}
                </span>
            @endif
        </div>
    </div>

    {{-- ===== FILTER BAR ===== --}}
    <div class="filter-bar vc-toolbar">
        <div class="vc-toolbar-filters">
            <div class="search-box vc-search">
                <i class="ti ti-search"></i>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari lowongan atau divisi...">
                @if($search)
                    <button type="button" class="search-clear" wire:click="$set('search', '')" aria-label="Hapus pencarian">
                        <i class="ti ti-x"></i>
                    </button>
                @endif
            </div>
            <div class="vc-select-wrap">
                <i class="ti ti-filter vc-select-icon"></i>
                <select wire:model.live="filterDivision" class="vc-select" aria-label="Filter divisi">
                    <option value="">Semua Divisi</option>
                    @foreach($divisions as $div)
                        <option value="{{ $div }}">{{ $div }}</option>
                    @endforeach
                </select>
                <i class="ti ti-chevron-down vc-select-caret"></i>
            </div>
        </div>
        <span class="result-count">Menampilkan {{ $totalCount }} lowongan</span>
    </div>

    {{-- ===== SKELETON ===== --}}
    <div wire:loading class="vc-grid">
        @for($i = 0; $i < 6; $i++)
        <div class="panel vc-card vc-skeleton">
            <div class="vc-card-top">
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

    {{-- ===== GRID LOWONGAN ===== --}}
    <div wire:loading.remove class="vc-grid">
        @forelse($vacancies as $v)
            @php
                $daysLeft = (int) now()->startOfDay()->diffInDays($v->application_deadline);
                $filled = min($v->accepted_applications_count, $v->quota);
                $quotaPct = $v->quota > 0 ? round($filled / $v->quota * 100) : 0;
                $isFull = $v->accepted_applications_count >= $v->quota;
            @endphp
            <a href="{{ route('intern.vacancies.show', $v->id) }}" class="panel vc-card" wire:navigate aria-label="Lowongan {{ $v->title }}">
                <div class="vc-card-top">
                    <span class="vc-div-badge">{{ $v->division }}</span>
                    @if($isFull)
                        <span class="vc-status-badge vc-status-full">Penuh</span>
                    @elseif($daysLeft >= 0 && $daysLeft <= 3)
                        <span class="vc-status-badge vc-status-urgent">Urgent</span>
                    @else
                        <span class="vc-status-badge vc-status-open">Open</span>
                    @endif
                </div>

                <h2 class="vc-card-title">{{ $v->title }}</h2>
                <p class="vc-card-desc vacancy-card-desc">{!! clean(Str::limit(strip_tags($v->description), 100)) !!}</p>

                <div class="vc-quota">
                    <div class="vc-quota-label">
                        <span>Kuota terisi</span>
                        <span class="{{ $isFull ? 'vc-quota-full' : '' }}">{{ $filled }}/{{ $v->quota }}</span>
                    </div>
                    <div class="vc-quota-bar">
                        <div class="vc-quota-fill {{ $isFull ? 'vc-quota-fill-full' : '' }}" style="width:{{ $quotaPct }}%"></div>
                    </div>
                </div>

                <div class="vc-card-foot">
                    <div class="vc-deadline">
                        <i class="ti ti-calendar-event"></i>
                        @if($daysLeft === 0)
                            <span class="vc-deadline-urgent">Hari ini hari terakhir!</span>
                        @elseif($daysLeft <= 3)
                            <span class="vc-deadline-urgent">{{ $daysLeft }} hari lagi</span>
                        @else
                            <span>Deadline: {{ $v->application_deadline?->format('d M Y') }}</span>
                        @endif
                    </div>
                    <span class="vc-card-link-text">
                        Lihat Detail <i class="ti ti-arrow-right"></i>
                    </span>
                </div>
            </a>
        @empty
            <div class="vc-empty">
                <div class="vc-empty-icon">
                    <i class="ti ti-building-off"></i>
                </div>
                <h3 class="vc-empty-title">Belum ada lowongan tersedia</h3>
                <p class="vc-empty-sub">
                    @if($search || $filterDivision)
                        Tidak ada lowongan yang cocok dengan pencarianmu. Coba ubah kata kunci atau divisi.
                    @else
                        Cek kembali nanti, lowongan baru akan segera hadir.
                    @endif
                </p>
                @if($search || $filterDivision)
                    <button wire:click="resetFilters" class="btn-primary vc-empty-btn">
                        <i class="ti ti-refresh"></i> Reset Filter
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <div class="pagination-wrap">
        {{ $vacancies->links('components.pagination', ['paginator' => $vacancies]) }}
    </div>
</div>