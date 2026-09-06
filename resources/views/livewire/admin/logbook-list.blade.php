<div class="adx-root">
    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Logbook</span>
            </div>
            <h2 class="adx-title">Kelola Logbook</h2>
            <p class="adx-sub">Pantau dan review logbook kegiatan peserta</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.export.logbooks') }}" class="adx-btn adx-btn-ghost">
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
            <button wire:click="$set('filterStatus', 'draft')" class="adx-filter-tab {{ $filterStatus === 'draft' ? 'active' : '' }}">
                Draft <span class="adx-filter-count">{{ $statusCounts['draft'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'submitted')" class="adx-filter-tab {{ $filterStatus === 'submitted' ? 'active' : '' }}">
                Submitted <span class="adx-filter-count">{{ $statusCounts['submitted'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'approved')" class="adx-filter-tab {{ $filterStatus === 'approved' ? 'active' : '' }}">
                Disetujui <span class="adx-filter-count">{{ $statusCounts['approved'] ?? 0 }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'revision_requested')" class="adx-filter-tab {{ $filterStatus === 'revision_requested' ? 'active' : '' }}">
                Revisi <span class="adx-filter-count">{{ $statusCounts['revision_requested'] ?? 0 }}</span>
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
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Kegiatan</th>
                        <th>Status</th>
                        <th>Catatan</th>
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
                        <td><div class="skeleton-text skeleton-text-sm" style="width:90px;margin-bottom:0"></div></td>
                        <td><div class="skeleton-text" style="width:200px"></div></td>
                        <td><div class="skeleton" style="width:76px;height:22px;border-radius:20px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:120px;margin-bottom:0"></div></td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($logbooks as $log)
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                @php $logName = $log->intern->internProfile->full_name ?? $log->intern->email; @endphp
                                <x-avatar name="{{ $logName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $logName }}</div>
                                    <div class="adx-table-email">{{ $log->intern->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="adx-table-title-cell">{{ $log->internship->vacancy->title ?? '-' }}</span>
                        </td>
                        <td><span class="adx-date">{{ $log->activity_date->format('d M Y') }}</span></td>
                        <td>
                            @if($log->attendance_type === 'sakit')
                                <span class="adx-chip" style="background:#fef3c7;color:#92400e;">Sakit</span>
                            @elseif($log->attendance_type === 'izin')
                                <span class="adx-chip" style="background:#e0e7ff;color:#3730a3;">Izin</span>
                            @else
                                <span class="adx-chip" style="background:#ecfdf5;color:#065f46;">Hadir</span>
                            @endif
                        </td>
                        <td><span style="font-size:13px;color:var(--adx-text)">{{ Str::limit($log->activities, 80) }}</span></td>
                        <td>
                            <span class="adx-chip adx-chip-{{ $log->validation_status }}">
                                {{ $log->validation_status === 'draft' ? 'Draft' : ($log->validation_status === 'submitted' ? 'Submitted' : ($log->validation_status === 'approved' ? 'Disetujui' : 'Revisi')) }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size:12px;color:var(--adx-muted)">{{ $log->supervisor_notes ? Str::limit($log->supervisor_notes, 60) : '-' }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state icon="ti-notebook" message="Belum ada logbook." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $logbooks->links('components.pagination', ['paginator' => $logbooks]) }}
</div>
