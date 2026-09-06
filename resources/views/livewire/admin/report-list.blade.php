<div class="adx-root">
    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Laporan</span>
            </div>
            <h2 class="adx-title">Kelola Laporan</h2>
            <p class="adx-sub">Tinjau laporan akhir peserta magang</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.export.reports') }}" class="adx-btn adx-btn-ghost">
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

        <div class="adx-filter-tabs" role="tablist" aria-label="Filter status">
            <button wire:click="$set('filterStatus', '')" class="adx-filter-tab {{ $filterStatus === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $statusCounts['total'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'pending')" class="adx-filter-tab {{ $filterStatus === 'pending' ? 'active' : '' }}">
                Pending <span class="adx-filter-count">{{ $statusCounts['pending'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'approved')" class="adx-filter-tab {{ $filterStatus === 'approved' ? 'active' : '' }}">
                Disetujui <span class="adx-filter-count">{{ $statusCounts['approved'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'rejected')" class="adx-filter-tab {{ $filterStatus === 'rejected' ? 'active' : '' }}">
                Ditolak <span class="adx-filter-count">{{ $statusCounts['rejected'] ?? 0 }}</span>
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
                        <th>Judul</th>
                        <th>Pembimbing</th>
                        <th>Tgl Upload</th>
                        <th>Status</th>
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
                        <td><div class="skeleton-text" style="width:200px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:120px;margin-bottom:0"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:100px;margin-bottom:0"></div></td>
                        <td><div class="skeleton" style="width:76px;height:22px;border-radius:20px"></div></td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($reports as $report)
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                @php $reportName = $report->intern->internProfile?->full_name ?? $report->intern->email; @endphp
                                <x-avatar name="{{ $reportName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $reportName }}</div>
                                    <div class="adx-table-email">{{ $report->intern->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="adx-table-title-cell">{{ $report->title }}</span>
                        </td>
                        <td>
                            @if($report->internship->supervisor)
                                <div class="adx-table-user" style="gap:8px">
                                    <div>
                                        <div class="adx-table-name" style="font-weight:600">{{ $report->internship->supervisor->supervisorProfile?->full_name ?? $report->internship->supervisor->email }}</div>
                                        @if($report->internship->supervisor->supervisorProfile?->full_name)
                                            <div class="adx-table-email">{{ $report->internship->supervisor->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="adx-inline-note">-</span>
                            @endif
                        </td>
                        <td><span class="adx-date">{{ $report->submitted_at?->format('d M Y') ?? '-' }}</span></td>
                        <td>
                            <span class="adx-chip adx-chip-{{ $report->supervisor_approval }}">
                                {{ $report->supervisor_approval === 'pending' ? 'Pending' : ($report->supervisor_approval === 'approved' ? 'Disetujui' : 'Ditolak') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <x-empty-state icon="ti-file-description" message="Belum ada laporan akhir." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $reports->links('components.pagination', ['paginator' => $reports]) }}
</div>
