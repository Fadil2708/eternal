<div class="adx-root">
    {{-- ═══ HEADER ═══ --}}
    <div class="adx-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Magang</span>
            </div>
            <h2 class="adx-title">Kelola Magang</h2>
            <p class="adx-sub">Pantau status magang seluruh peserta</p>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.export.internships') }}" class="adx-btn adx-btn-ghost">
                <i class="ti ti-download"></i> Export
            </a>
        </div>
    </div>

    {{-- ═══ TOOLBAR ═══ --}}
    <div class="adx-toolbar">
        <div class="adx-search">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari peserta, lowongan, atau pembimbing...">
        </div>

        <div class="adx-filter-tabs" role="tablist" aria-label="Filter status">
            <button wire:click="$set('filterStatus', '')" class="adx-filter-tab {{ $filterStatus === '' ? 'active' : '' }}">
                Semua <span class="adx-filter-count">{{ $statusCounts['total'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'active')" class="adx-filter-tab {{ $filterStatus === 'active' ? 'active' : '' }}">
                Aktif <span class="adx-filter-count">{{ $statusCounts['active'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'completed')" class="adx-filter-tab {{ $filterStatus === 'completed' ? 'active' : '' }}">
                Selesai <span class="adx-filter-count">{{ $statusCounts['completed'] }}</span>
            </button>
            <button wire:click="$set('filterStatus', 'terminated')" class="adx-filter-tab {{ $filterStatus === 'terminated' ? 'active' : '' }}">
                Terminasi <span class="adx-filter-count">{{ $statusCounts['terminated'] }}</span>
            </button>
        </div>
    </div>

    @php
        $internships->each(function($internship) {
            $internship->participantName = $internship->intern->internProfile->full_name ?? $internship->intern->email;
        });
    @endphp

    {{-- ═══ TABLE ═══ --}}
    <div class="adx-card adx-table-card">
        <div class="adx-table-scroll">
            <table class="adx-table">
                <thead>
                    <tr>
                        <th>Peserta</th>
                        <th>Lowongan</th>
                        <th>Pembimbing</th>
                        <th>Tgl Mulai</th>
                        <th>Tgl Selesai</th>
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
                                    <div class="skeleton-text skeleton-text-sm" style="width:180px"></div>
                                </div>
                            </div>
                        </td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:150px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:120px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:90px"></div></td>
                        <td><div class="skeleton-text skeleton-text-sm" style="width:90px"></div></td>
                        <td><div class="skeleton" style="width:70px;height:22px;border-radius:20px"></div></td>
                        <td>
                            <div class="adx-actions" style="justify-content:flex-end">
                                <div class="skeleton" style="width:32px;height:32px;border-radius:9px"></div>
                                <div class="skeleton" style="width:32px;height:32px;border-radius:9px"></div>
                            </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
                <tbody wire:loading.remove>
                    @forelse($internships as $internship)
                    <tr>
                        <td>
                            <div class="adx-table-user">
                                <x-avatar name="{{ $internship->participantName }}" size="36" type="r" />
                                <div>
                                    <div class="adx-table-name">{{ $internship->participantName }}</div>
                                    <div class="adx-table-email">{{ $internship->intern->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="adx-table-title-cell">{{ $internship->vacancy->title ?? '-' }}</span>
                        </td>
                        <td>
                            @if($internship->supervisor)
                                <div class="adx-supervisor">
                                    <div>{{ $internship->supervisor->supervisorProfile->full_name ?? $internship->supervisor->email }}</div>
                                    @if($internship->supervisor->supervisorProfile?->full_name)
                                        <div class="adx-supervisor-email">{{ $internship->supervisor->email }}</div>
                                    @endif
                                </div>
                            @else
                                <span class="adx-inline-note">-</span>
                            @endif
                        </td>
                        <td><span class="adx-date">{{ $internship->actual_start_date?->format('d M Y') ?? '-' }}</span></td>
                        <td><span class="adx-date">{{ $internship->actual_end_date?->format('d M Y') ?? '-' }}</span></td>
                        <td>
                            <span class="adx-chip adx-chip-{{ $internship->status }}">
                                {{ $internship->status === 'active' ? 'Aktif' : ($internship->status === 'completed' ? 'Selesai' : 'Terminasi') }}
                            </span>
                        </td>
                        <td class="text-right">
                            @if($internship->status === 'active')
                            <div class="adx-actions">
                                <button wire:click="editDates('{{ $internship->id }}')"
                                        wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                        class="adx-action" title="Atur Tanggal">
                                    <i class="ti ti-calendar"></i>
                                </button>
                                <button wire:click="confirmAction('{{ $internship->id }}', 'complete')"
                                        wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                        class="adx-action is-success" title="Selesaikan">
                                    <i class="ti ti-check"></i>
                                </button>
                                <button wire:click="confirmAction('{{ $internship->id }}', 'terminate')"
                                        wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                        class="adx-action is-danger" title="Terminasi">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                            @elseif($internship->status === 'completed' && $internship->evaluation && !$internship->evaluation->evaluated_at)
                            <div class="adx-actions">
                                <button wire:click="confirmLock('{{ $internship->id }}')"
                                        wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                        class="adx-action" title="Kunci Penilaian">
                                    <i class="ti ti-lock"></i>
                                </button>
                            </div>
                            @elseif($internship->status === 'completed' && $internship->evaluation && $internship->evaluation->evaluated_at)
                            <span class="adx-lock-note"><i class="ti ti-lock"></i> Penilaian terkunci</span>
                            @else
                            <span class="adx-inline-note">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <x-empty-state icon="ti-users" message="Belum ada peserta magang." />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $internships->links('components.pagination', ['paginator' => $internships]) }}

    @if($confirmingAction)
    <div class="modal-wrap" aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-data
         @keydown.escape.window="$wire.set('confirmingAction', null)">
        <div class="modal-backdrop" @click="$wire.set('confirmingAction', null)"></div>
        <div class="modal-center">
            <div class="modal-card modal-card-md">
                <div class="modal-header">
                    <h3 id="modal-title" class="modal-title">Konfirmasi</h3>
                    <button wire:click="$set('confirmingAction', null)" class="adx-action" aria-label="Tutup modal">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="adx-modal-icon {{ $actionType === 'terminate' ? 'is-danger' : 'is-success' }}">
                        <i class="ti {{ $actionType === 'terminate' ? 'ti-alert-triangle' : 'ti-circle-check' }}"></i>
                    </div>
                    <p class="adx-modal-text">
                        Yakin ingin <span class="font-semibold">{{ $actionType === 'terminate' ? 'menerminasi' : 'menyelesaikan' }}</span> magang peserta ini?
                    </p>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingAction', null)" class="btn-secondary">Batal</button>
                    <button wire:click="executeAction"
                            wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="adx-btn {{ $actionType === 'terminate' ? 'adx-btn-danger' : 'adx-btn-success' }}">
                        <span wire:loading.remove>Ya, {{ $actionType === 'terminate' ? 'Terminasi' : 'Selesaikan' }}</span>
                        <span wire:loading class="inline-flex items-center gap-1">
                            <i class="ti ti-loader animate-spin"></i>
                            Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($confirmingLockId)
    <div class="modal-wrap" aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-data
         @keydown.escape.window="$wire.set('confirmingLockId', null)">
        <div class="modal-backdrop" @click="$wire.set('confirmingLockId', null)"></div>
        <div class="modal-center">
            <div class="modal-card modal-card-md">
                <div class="modal-header">
                    <h3 id="modal-title" class="modal-title">Kunci Penilaian</h3>
                    <button wire:click="$set('confirmingLockId', null)" class="adx-action" aria-label="Tutup modal">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="adx-modal-icon"><i class="ti ti-lock"></i></div>
                    <p class="adx-modal-text">
                        Yakin ingin mengunci penilaian peserta ini? Setelah dikunci, pembimbing tidak bisa mengedit penilaian.
                    </p>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('confirmingLockId', null)" class="btn-secondary">Batal</button>
                    <button wire:click="lockEvaluation"
                            wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="adx-btn adx-btn-primary">
                        <span wire:loading.remove>Ya, Kunci</span>
                        <span wire:loading class="inline-flex items-center gap-1">
                            <i class="ti ti-loader animate-spin"></i>
                            Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($showDatesModal)
    <div class="modal-wrap" aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-data
         @keydown.escape.window="$wire.set('showDatesModal', false)">
        <div class="modal-backdrop" @click="$wire.set('showDatesModal', false)"></div>
        <div class="modal-center">
            <div class="modal-card modal-card-md">
                <div class="modal-header">
                    <h3 id="modal-title" class="modal-title">Atur Tanggal Aktual Magang</h3>
                    <button wire:click="$set('showDatesModal', false)" class="adx-action" aria-label="Tutup modal">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="field" style="margin-bottom:16px">
                        <label>Tanggal Mulai Aktual</label>
                        <div class="adx-date-wrap">
                            <i class="ti ti-calendar adx-date-icon"></i>
                            <input wire:model="actual_start_date" type="date" class="input">
                        </div>
                        @error('actual_start_date') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Selesai Aktual</label>
                        <div class="adx-date-wrap">
                            <i class="ti ti-calendar adx-date-icon"></i>
                            <input wire:model="actual_end_date" type="date" class="input">
                        </div>
                        @error('actual_end_date') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('showDatesModal', false)" class="btn-secondary">Batal</button>
                    <button wire:click="saveDates"
                            wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="adx-btn adx-btn-primary">
                        <span wire:loading.remove>Simpan</span>
                        <span wire:loading class="inline-flex items-center gap-1">
                            <i class="ti ti-loader animate-spin"></i>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        .adx-date-wrap { position: relative; }
        .adx-date-icon {
            position: absolute;
            left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--muted, #6b7280);
            font-size: 16px; pointer-events: none;
            transition: color .2s ease;
        }
        .adx-date-wrap:focus-within .adx-date-icon { color: var(--primary, #3b82f6); }
        .adx-date-wrap .input { padding-left: 42px; }
    </style>
</div>