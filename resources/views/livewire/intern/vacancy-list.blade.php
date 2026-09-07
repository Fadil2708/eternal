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
            <div class="vc-card-head">
                <div class="skeleton vc-sk-avatar"></div>
                <div style="flex:1">
                    <div class="skeleton-text skeleton-text-lg" style="width:70%;margin-bottom:8px"></div>
                    <div class="skeleton-text skeleton-text-sm" style="width:40%"></div>
                </div>
            </div>
            <div class="skeleton-text" style="width:100%;margin-bottom:4px"></div>
            <div class="skeleton-text" style="width:100%;margin-bottom:4px"></div>
            <div class="skeleton-text" style="width:60%"></div>
            <div class="skeleton" style="width:100%;height:6px;border-radius:6px;margin:16px 0 8px"></div>
            <div class="skeleton-text skeleton-text-sm" style="width:45%;margin-bottom:16px"></div>
            <div class="skeleton" style="width:100%;height:36px;border-radius:10px"></div>
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
                $tint = 'vc-tint-' . (($loop->iteration % 4) + 1);
            @endphp
            <article class="panel vc-card" aria-label="Lowongan {{ $v->title }}">
                <div class="vc-card-head">
                    <div class="vc-avatar {{ $tint }}">
                        <i class="ti ti-building"></i>
                    </div>
                    <div class="vc-card-main">
                        <h3 class="vc-card-title">
                            <a href="{{ route('intern.vacancies.show', $v->id) }}" class="vc-card-link" wire:navigate>{{ $v->title }}</a>
                        </h3>
                        <p class="vc-card-company">{{ $v->division }}</p>
                    </div>
                    @if($isFull)
                        <span class="badge badge-rejected">Penuh</span>
                    @else
                        <span class="badge badge-active">Terbuka</span>
                    @endif
                </div>

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

                <div class="vc-card-meta">
                    <span class="vc-meta-item" title="Periode magang">
                        <i class="ti ti-calendar-time"></i>
                        {{ $v->start_date?->format('d M') }} – {{ $v->end_date?->format('d M Y') }}
                    </span>
                    <span class="vc-meta-item" title="Tenggat pendaftaran">
                        <i class="ti ti-calendar-exclamation"></i>
                        <span class="vc-deadline {{ $daysLeft <= 2 ? 'vc-deadline-urgent' : ($daysLeft <= 4 ? 'vc-deadline-soon' : '') }}">
                            @if($daysLeft === 0)
                                Hari ini
                            @elseif($daysLeft === 1)
                                Besok
                            @else
                                {{ $daysLeft }} hari lagi
                            @endif
                        </span>
                    </span>
                </div>

                <div class="vc-card-foot">
                    <a href="{{ route('intern.vacancies.show', $v->id) }}" class="btn-primary vc-card-btn" wire:navigate>
                        Lihat Detail <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
            </article>
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