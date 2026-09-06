<div class="adx-root">
    @php
        $appStatusLabels = [
            'submitted' => 'Terkirim',
            'under_review' => 'Direview',
            'interview_scheduled' => 'Interview',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
        ];
    @endphp

    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Lamaran</span>
            </div>
            <h2 class="adx-title">Review Lamaran</h2>
            <p class="adx-sub">Tinjau dan proses lamaran masuk dari peserta</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.export.applications') }}" wire:navigate class="adx-btn adx-btn-ghost">
                <i class="ti ti-download"></i> Export
            </a>
        </div>
    </div>

    {{-- ═══ TOOLBAR ═══ --}}
    <div class="adx-toolbar">
        <div class="adx-filter-tabs" role="tablist" aria-label="Filter status">
            <button wire:click="$set('filterStatus', '')" class="adx-filter-tab {{ $filterStatus === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $statusCounts['total'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'submitted')" class="adx-filter-tab {{ $filterStatus === 'submitted' ? 'active' : '' }}">
                Terkirim <span class="adx-filter-count">{{ $statusCounts['submitted'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'under_review')" class="adx-filter-tab {{ $filterStatus === 'under_review' ? 'active' : '' }}">
                Direview <span class="adx-filter-count">{{ $statusCounts['under_review'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'interview_scheduled')" class="adx-filter-tab {{ $filterStatus === 'interview_scheduled' ? 'active' : '' }}">
                Interview <span class="adx-filter-count">{{ $statusCounts['interview_scheduled'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'accepted')" class="adx-filter-tab {{ $filterStatus === 'accepted' ? 'active' : '' }}">
                Diterima <span class="adx-filter-count">{{ $statusCounts['accepted'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'rejected')" class="adx-filter-tab {{ $filterStatus === 'rejected' ? 'active' : '' }}">
                Ditolak <span class="adx-filter-count">{{ $statusCounts['rejected'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'cancelled')" class="adx-filter-tab {{ $filterStatus === 'cancelled' ? 'active' : '' }}">
                Dibatalkan <span class="adx-filter-count">{{ $statusCounts['cancelled'] }}</span>
            </button>
        </div>

        <div class="adx-select-wrap">
            <i class="ti ti-building-skyscraper"></i>
            <select wire:model.live="filterVacancy" class="adx-select">
                <option value="">Semua Lowongan</option>
                @foreach($vacancies as $vac)
                    <option value="{{ $vac->id }}">{{ $vac->title }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ═══ TABLE ═══ --}}
    <div class="adx-card adx-table-card">
        <div class="adx-table-scroll">
            <table class="adx-table">
                <thead>
                    <tr>
                        <th>Pelamar</th>
                        <th>Lowongan</th>
                        <th>Tgl Daftar</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
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
                                    <div class="skeleton-text skeleton-text-sm" style="width:120px;margin-bottom:0"></div>
                                </div>
                            </div>
                        </td>
                        <td><div class="skeleton-text skeleton-text-lg" style="width:180px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:90px;margin-bottom:0"></div></td>
                        <td><div class="skeleton" style="width:70px;height:22px;border-radius:20px"></div></td>
                        <td>
                            <div class="adx-actions">
                                <div class="skeleton" style="width:32px;height:32px;border-radius:9px"></div>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($applications as $app)
                    @php
                        $applicantName = $app->intern?->internProfile?->full_name ?? $app->intern?->email ?? '—';
                        $institution = $app->intern?->internProfile?->institution_name ?? '—';
                    @endphp
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                <x-avatar name="{{ $applicantName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $applicantName }}</div>
                                    <div class="adx-table-email">{{ $institution }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="adx-table-title-cell">{{ $app->vacancy?->title ?? '—' }}</span></td>
                        <td><span class="adx-date">{{ $app->applied_at?->format('d M Y') ?? '—' }}</span></td>
                        <td>
                            <span class="adx-app-chip adx-app-{{ $app->status }}">
                                {{ $appStatusLabels[$app->status] ?? ucfirst(str_replace('_', ' ', $app->status)) }}
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="adx-actions">
                                <a href="{{ route('admin.applications.show', $app->id) }}" wire:navigate class="adx-action" title="Review">
                                    <i class="ti ti-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            @if($filterStatus || $filterVacancy)
                                <x-empty-state icon="ti-filter-off" message="Tidak ada lamaran dengan filter ini." />
                            @else
                                <x-empty-state icon="ti-inbox" message="Belum ada lamaran masuk." />
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $applications->links('components.pagination', ['paginator' => $applications]) }}
</div>