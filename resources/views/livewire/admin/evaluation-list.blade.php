<div class="adx-root">
    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Evaluasi</span>
            </div>
            <h2 class="adx-title">Kelola Evaluasi</h2>
            <p class="adx-sub">Lihat hasil evaluasi dan nilai peserta magang</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.export.evaluations') }}" class="adx-btn adx-btn-ghost">
                <i class="ti ti-download"></i> Export
            </a>
        </div>
    </div>

    {{-- ═══ TOOLBAR ═══ --}}
    <div class="adx-toolbar">
        <div class="adx-search">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama peserta...">
        </div>

        <div class="adx-filter-tabs" role="tablist" aria-label="Filter grade">
            <button wire:click="$set('filterGrade', '')" class="adx-filter-tab {{ $filterGrade === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $gradeCounts['total'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterGrade', 'A')" class="adx-filter-tab {{ $filterGrade === 'A' ? 'active' : '' }}">
                A <span class="adx-filter-count">{{ $gradeCounts['A'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterGrade', 'B')" class="adx-filter-tab {{ $filterGrade === 'B' ? 'active' : '' }}">
                B <span class="adx-filter-count">{{ $gradeCounts['B'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterGrade', 'C')" class="adx-filter-tab {{ $filterGrade === 'C' ? 'active' : '' }}">
                C <span class="adx-filter-count">{{ $gradeCounts['C'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterGrade', 'D')" class="adx-filter-tab {{ $filterGrade === 'D' ? 'active' : '' }}">
                D <span class="adx-filter-count">{{ $gradeCounts['D'] ?? 0 }}</span>
            </button>
        </div>
    </div>

    {{-- ═══ TABLE ═══ --}}
    <div class="adx-card adx-table-card">
        <div class="adx-table-scroll">
            <table class="adx-table">
                <thead>
                    <tr>
                        <th>Peserta</th>
                        <th>Lowongan</th>
                        <th>Pembimbing</th>
                        <th>Nilai</th>
                        <th>Grade</th>
                        <th>Tgl Nilai</th>
                    </tr>
                </thead>
                <tbody wire:loading>
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                <div class="skeleton" style="width:36px;height:36px;border-radius:50%;flex-shrink:0"></div>
                                <div>
                                    <div class="skeleton-text skeleton-text-lg" style="width:140px"></div>
                                    <div class="skeleton-text skeleton-text-sm" style="width:180px;margin-bottom:0"></div>
                                </div>
                            </div>
                        </td>
                        <td><div class="skeleton-text skeleton-text-lg" style="width:150px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:120px;margin-bottom:0"></div></td>
                        <td><div class="skeleton-text" style="width:50px"></div></td>
                        <td><div class="skeleton" style="width:40px;height:24px;border-radius:20px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:100px;margin-bottom:0"></div></td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($evaluations as $eva)
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                @php $evaName = $eva->internship->intern->internProfile->full_name ?? $eva->internship->intern->email; @endphp
                                <x-avatar name="{{ $evaName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $evaName }}</div>
                                    <div class="adx-table-email">{{ $eva->internship->intern->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="adx-table-title-cell">{{ $eva->internship->vacancy->title ?? '-' }}</span>
                        </td>
                        <td>
                            @if($eva->supervisor)
                                <div class="adx-table-user" style="gap:8px">
                                    <div>
                                        <div class="adx-table-name" style="font-weight:600">{{ $eva->supervisor->supervisorProfile?->full_name ?? $eva->supervisor->email }}</div>
                                        @if($eva->supervisor->supervisorProfile?->full_name)
                                            <div class="adx-table-email">{{ $eva->supervisor->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="adx-inline-note">-</span>
                            @endif
                        </td>
                        <td><span style="font-weight:700;color:var(--adx-text)">{{ number_format($eva->final_score, 0) }}</span></td>
                        <td>
                            <span class="adx-chip adx-chip-grade-{{ $eva->grade }}">{{ $eva->grade }}</span>
                        </td>
                        <td><span class="adx-date">{{ $eva->evaluated_at?->format('d M Y') ?? '-' }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state icon="ti-star" message="Belum ada penilaian." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $evaluations->links('components.pagination', ['paginator' => $evaluations]) }}
</div>
