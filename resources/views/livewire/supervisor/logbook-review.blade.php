<div class="lgr-root" x-data="{ selected: $wire.$entangle('selectedLogbooks') }">

    <style>
        .lgr-root {
            --lgr-primary: #3155e7;
            --lgr-primary-dark: #2444c9;
            --lgr-primary-light: #eef2ff;
            --lgr-text: #111936;
            --lgr-muted: #64708a;
            --lgr-border: #e5e7eb;
            --lgr-amber: #b45309;
            --lgr-amber-bg: #fffbeb;
            --lgr-green: #16a34a;
            --lgr-green-bg: #ecfdf5;
            --lgr-red: #dc2626;
            --lgr-red-bg: #fef2f2;
            --lgr-gray-bg: #f1f5f9;
            --pagination-active-bg: #3155e7;
        }

        /* ═══ HEADER ═══ */
        .lgr-header {
            margin-bottom: 20px;
        }
        .lgr-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--lgr-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .lgr-sub {
            font-size: 13px;
            color: var(--lgr-muted);
            margin: 0;
        }

        /* ═══ FILTER BAR ═══ */
        .lgr-filter {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            background: #fff;
            border: 1px solid var(--lgr-border);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }
        .lgr-search {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 300px;
        }
        .lgr-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--lgr-muted);
            pointer-events: none;
        }
        .lgr-search input {
            width: 100%;
            padding: 10px 12px 10px 36px;
            font-size: 13px;
            font-family: inherit;
            color: var(--lgr-text);
            background: #fff;
            border: 1px solid var(--lgr-border);
            border-radius: 10px;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .lgr-search input::placeholder { color: #9aa3b5; }
        .lgr-search input:focus {
            border-color: var(--lgr-primary);
            box-shadow: 0 0 0 3px var(--lgr-primary-light);
        }
        .lgr-chips {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .lgr-chip {
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 700;
            font-family: inherit;
            color: var(--lgr-muted);
            background: #fff;
            border: 1px solid var(--lgr-border);
            border-radius: 99px;
            cursor: pointer;
            transition: background .15s ease, color .15s ease, border-color .15s ease;
        }
        .lgr-chip:hover {
            border-color: var(--lgr-primary);
            color: var(--lgr-primary);
        }
        .lgr-chip.is-active {
            background: var(--lgr-primary);
            border-color: var(--lgr-primary);
            color: #fff;
        }

        /* ═══ INTERN FILTER CHIP ═══ */
        .lgr-intern-filter {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            margin-bottom: 12px;
            border-radius: 99px;
            background: var(--lgr-primary-light);
            border: 1px solid #dbe3fb;
            color: var(--lgr-primary);
            font-size: 12px;
            font-weight: 700;
        }
        .lgr-intern-filter button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border: none;
            border-radius: 50%;
            background: rgba(49, 85, 231, .15);
            color: var(--lgr-primary);
            font-size: 12px;
            cursor: pointer;
            transition: background .15s ease;
        }
        .lgr-intern-filter button:hover { background: rgba(49, 85, 231, .28); }

        /* ═══ BULK BAR ═══ */
        .lgr-bulk {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            background: #fff;
            border: 1px solid var(--lgr-border);
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 12px;
        }
        .lgr-bulk label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: var(--lgr-text);
            cursor: pointer;
        }
        .lgr-checkbox {
            width: 16px;
            height: 16px;
            accent-color: var(--lgr-primary);
            cursor: pointer;
        }
        .lgr-btn-bulk {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            font-size: 12px;
            font-weight: 700;
            font-family: inherit;
            color: #fff;
            background: linear-gradient(135deg, #16a34a, #15803d);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: box-shadow .15s ease, transform .15s ease;
        }
        .lgr-btn-bulk:hover {
            box-shadow: 0 5px 14px rgba(22, 163, 74, .3);
            transform: translateY(-1px);
        }

        /* ═══ CARDS ═══ */
        .lgr-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .lgr-card {
            background: #fff;
            border: 1px solid var(--lgr-border);
            border-radius: 14px;
            padding: 18px 20px;
            transition: box-shadow .15s ease;
        }
        .lgr-card:hover { box-shadow: 0 6px 18px rgba(17, 25, 54, .06); }
        .lgr-card-top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .lgr-checkbox-wrap {
            padding-top: 6px;
            flex-shrink: 0;
        }
        .lgr-card-body { flex: 1; min-width: 0; }
        .lgr-card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
        }
        .lgr-who {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }
        .lgr-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--lgr-text);
            line-height: 1.3;
        }
        .lgr-role {
            font-size: 11px;
            color: var(--lgr-muted);
            margin-top: 2px;
        }
        .lgr-date {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 700;
            color: var(--lgr-muted);
            flex-shrink: 0;
        }
        .lgr-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 11px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .lgr-badge.is-submitted         { background: var(--lgr-amber-bg); color: var(--lgr-amber); }
        .lgr-badge.is-approved          { background: var(--lgr-green-bg); color: var(--lgr-green); }
        .lgr-badge.is-revision_requested{ background: var(--lgr-red-bg); color: var(--lgr-red); }
        .lgr-badge.is-draft             { background: var(--lgr-gray-bg); color: var(--lgr-muted); }

        .lgr-block {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-bottom: 8px;
        }
        .lgr-block:last-child { margin-bottom: 0; }
        .lgr-block-icon {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: var(--lgr-primary-light);
            color: var(--lgr-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .lgr-block strong {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .03em;
            color: var(--lgr-muted);
            margin-bottom: 2px;
        }
        .lgr-block p {
            font-size: 13px;
            color: var(--lgr-text);
            margin: 0;
            line-height: 1.55;
        }

        .lgr-notes {
            margin-top: 12px;
            padding: 11px 13px;
            border-radius: 10px;
            background: var(--lgr-amber-bg);
            border: 1px solid #fde68a;
        }
        .lgr-notes strong {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .03em;
            color: var(--lgr-amber);
            margin-bottom: 3px;
        }
        .lgr-notes p {
            font-size: 13px;
            color: var(--lgr-text);
            margin: 0;
            line-height: 1.5;
        }

        .lgr-card-foot {
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--lgr-border);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .lgr-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 16px;
            font-size: 12px;
            font-weight: 700;
            font-family: inherit;
            border-radius: 10px;
            cursor: pointer;
            transition: background .15s ease, box-shadow .15s ease, transform .15s ease;
        }
        .lgr-btn i { font-size: 15px; }
        .lgr-btn-approve {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #fff;
            border: none;
            box-shadow: 0 4px 12px rgba(22, 163, 74, .25);
        }
        .lgr-btn-approve:hover {
            box-shadow: 0 6px 16px rgba(22, 163, 74, .35);
            transform: translateY(-1px);
        }
        .lgr-btn-revision {
            background: #fff;
            color: var(--lgr-red);
            border: 1px solid #fca5a5;
        }
        .lgr-btn-revision:hover {
            background: var(--lgr-red-bg);
        }

        /* ═══ EMPTY ═══ */
        .lgr-empty {
            text-align: center;
            padding: 44px 20px;
            background: #fff;
            border: 1px solid var(--lgr-border);
            border-radius: 14px;
        }
        .lgr-empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 12px;
            border-radius: 16px;
            background: var(--lgr-primary-light);
            color: var(--lgr-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }
        .lgr-empty p {
            font-size: 13px;
            color: var(--lgr-muted);
            margin: 0;
        }

        /* ═══ PAGINATION ═══ */
        .lgr-pagination {
            margin-top: 16px;
        }

        /* ═══ MODAL ═══ */
        .lgr-root .modal-card {
            border-radius: 14px;
        }
        .lgr-root .modal-header {
            border-bottom: 1px solid var(--lgr-border);
            padding: 18px 22px;
        }
        .lgr-root .modal-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--lgr-text);
        }
        .lgr-root .modal-body { padding: 18px 22px; }
        .lgr-root .modal-footer {
            border-top: 1px solid var(--lgr-border);
            padding: 14px 22px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .lgr-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--lgr-text);
            margin-bottom: 6px;
        }
        .lgr-required { color: var(--lgr-red); }
        .lgr-input {
            width: 100%;
            padding: 11px 13px;
            font-size: 13px;
            font-family: inherit;
            color: var(--lgr-text);
            background: #fff;
            border: 1px solid var(--lgr-border);
            border-radius: 10px;
            outline: none;
            resize: vertical;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .lgr-input:focus {
            border-color: var(--lgr-primary);
            box-shadow: 0 0 0 3px var(--lgr-primary-light);
        }
        .lgr-error {
            font-size: 12px;
            color: var(--lgr-red);
            margin-top: 6px;
        }
        .lgr-btn-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            font-family: inherit;
            background: #fff;
            color: var(--lgr-muted);
            border: 1px solid var(--lgr-border);
            border-radius: 10px;
            cursor: pointer;
            transition: background .15s ease, color .15s ease;
        }
        .lgr-btn-ghost:hover { background: #f8fafc; color: var(--lgr-text); }
        .lgr-btn-send {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            font-family: inherit;
            color: #fff;
            background: linear-gradient(135deg, #3155e7, #2444c9);
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(49, 85, 231, .28);
            cursor: pointer;
            transition: box-shadow .15s ease, transform .15s ease;
        }
        .lgr-btn-send:hover:not(:disabled) {
            box-shadow: 0 6px 18px rgba(49, 85, 231, .38);
            transform: translateY(-1px);
        }
        .lgr-btn-send:disabled { opacity: .6; cursor: wait; }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 620px) {
            .lgr-filter { flex-direction: column; align-items: stretch; }
            .lgr-search { max-width: none; }
            .lgr-card { padding: 16px 14px; }
        }
    </style>

    {{-- ═══ HEADER ═══ --}}
    <div class="lgr-header">
        <div class="breadcrumb">
            <a href="{{ route('supervisor.dashboard') }}" wire:navigate>Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <span>Review Logbook</span>
        </div>
        <h2 class="lgr-title">Review Logbook</h2>
        <p class="lgr-sub">Periksa dan validasi logbook harian peserta bimbingan</p>
    </div>

    {{-- ═══ FILTER BAR ═══ --}}
    <div class="lgr-filter">
        <div class="lgr-search">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari peserta...">
        </div>
        <div class="lgr-chips">
            <button wire:click="$set('filterStatus', 'submitted')" class="lgr-chip" :class="{ 'is-active': $wire.filterStatus === 'submitted' }">Perlu Review</button>
            <button wire:click="$set('filterStatus', 'approved')" class="lgr-chip" :class="{ 'is-active': $wire.filterStatus === 'approved' }">Disetujui</button>
            <button wire:click="$set('filterStatus', 'revision_requested')" class="lgr-chip" :class="{ 'is-active': $wire.filterStatus === 'revision_requested' }">Perlu Revisi</button>
            <button wire:click="$set('filterStatus', '')" class="lgr-chip" :class="{ 'is-active': !$wire.filterStatus }">Semua</button>
        </div>
    </div>

    {{-- ═══ INTERN FILTER ═══ --}}
    @if($filteredInternName)
    <div class="lgr-intern-filter">
        <i class="ti ti-user"></i>
        Filter peserta: {{ $filteredInternName }}
        <button wire:click="clearInternFilter" aria-label="Hapus filter peserta">
            <i class="ti ti-x"></i>
        </button>
    </div>
    @endif

    {{-- ═══ BULK BAR ═══ --}}
    @if($filterStatus === 'submitted')
    <div class="lgr-bulk">
        <label>
            <input type="checkbox" class="lgr-checkbox" wire:click="toggleSelectAll"
                   {{ count($selectedLogbooks) > 0 && count($selectedLogbooks) === $totalSubmitted ? 'checked' : '' }}>
            Pilih Semua
        </label>
        @if(count($selectedLogbooks) > 0)
        <button @click="window.dispatchEvent(new CustomEvent('confirm', { detail: { message: 'Setujui {{ count($selectedLogbooks) }} logbook terpilih?', callback: () => $wire.bulkApprove() } }))"
                wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                class="lgr-btn-bulk">
            <i class="ti ti-check"></i> Setujui Terpilih ({{ count($selectedLogbooks) }})
        </button>
        @endif
    </div>
    @endif

    {{-- ═══ LIST ═══ --}}
    <div class="lgr-list" wire:loading.class="opacity-40 pointer-events-none">
        @forelse($logbooks as $logbook)
        <div wire:key="{{ $logbook->id }}" class="lgr-card">
            <div class="lgr-card-top">
                @if($logbook->validation_status === 'submitted')
                <div class="lgr-checkbox-wrap">
                    <input type="checkbox" class="lgr-checkbox" x-model="selected" value="{{ $logbook->id }}">
                </div>
                @endif

                <div class="lgr-card-body">
                    <div class="lgr-card-head">
                        <div class="lgr-who">
                            <x-avatar
                                :name="$logbook->intern?->internProfile?->full_name ?? $logbook->intern?->email ?? ''"
                                :photo="$logbook->intern?->internProfile?->photo_url"
                                :size="34"
                            />
                            <div>
                                <div class="lgr-name">{{ $logbook->intern?->internProfile?->full_name ?? $logbook->intern?->email }}</div>
                                <div class="lgr-role">{{ $logbook->internship?->vacancy?->title }}</div>
                            </div>
                        </div>
                        <span class="lgr-date"><i class="ti ti-calendar"></i>{{ $logbook->activity_date?->isoFormat('dddd, D MMMM Y') ?? '—' }}</span>
                        <span class="lgr-badge is-{{ $logbook->validation_status }}">
                            {{ $logbook->validation_status === 'submitted' ? 'Terkirim' : ($logbook->validation_status === 'approved' ? 'Disetujui' : ($logbook->validation_status === 'revision_requested' ? 'Perlu Revisi' : 'Draft')) }}
                        </span>
                    </div>

                    <div class="lgr-block">
                        <span class="lgr-block-icon"><i class="ti ti-list-check"></i></span>
                        <div>
                            <strong>Kegiatan</strong>
                            <p>{{ $logbook->activities }}</p>
                        </div>
                    </div>
                    <div class="lgr-block">
                        <span class="lgr-block-icon"><i class="ti ti-tool"></i></span>
                        <div>
                            <strong>Output</strong>
                            <p>{{ $logbook->output }}</p>
                        </div>
                    </div>

                    @if($logbook->supervisor_notes)
                    <div class="lgr-notes">
                        <strong>Catatan Review</strong>
                        <p>{{ $logbook->supervisor_notes }}</p>
                    </div>
                    @endif

                    @if($logbook->validation_status === 'submitted')
                    <div class="lgr-card-foot">
                        <button wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                @click="window.dispatchEvent(new CustomEvent('confirm', { detail: { message: 'Setujui logbook ini?', callback: () => $wire.approve('{{ $logbook->id }}') } }))"
                                class="lgr-btn lgr-btn-approve">
                            <i class="ti ti-check"></i> Setujui
                        </button>
                        <button wire:click="openRevision('{{ $logbook->id }}')"
                                wire:loading.attr="disabled"
                                class="lgr-btn lgr-btn-revision">
                            <i class="ti ti-arrow-back"></i> Minta Revisi
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="lgr-empty">
            <div class="lgr-empty-icon"><i class="ti ti-notebook"></i></div>
            <p>Tidak ada logbook {{ $filterStatus ? 'dengan status ini' : '' }}.</p>
        </div>
        @endforelse
    </div>

    @if($logbooks->hasPages())
    <div class="lgr-pagination">
        {{ $logbooks->links('components.pagination', ['paginator' => $logbooks]) }}
    </div>
    @endif

    {{-- ═══ REVISION MODAL ═══ --}}
    @if($showRevisionModal)
    <div class="modal-wrap" aria-labelledby="revision-modal-title" role="dialog" aria-modal="true"
         x-data
         @keydown.escape.window="$wire.set('showRevisionModal', false)">
        <div class="modal-backdrop" @click="$wire.set('showRevisionModal', false)"></div>
        <div class="modal-center">
            <div class="modal-card modal-card-lg">
                <div class="modal-header">
                    <h3 id="revision-modal-title" class="modal-title">Minta Revisi Logbook</h3>
                    <button wire:click="$set('showRevisionModal', false)" class="action-btn" aria-label="Tutup modal">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="lgr-field">
                        <label class="lgr-label" for="lgr-revision-notes">Catatan Revisi <span class="lgr-required">*</span></label>
                        <textarea id="lgr-revision-notes" wire:model="revisionNotes" rows="4" class="lgr-input" placeholder="Jelaskan apa yang perlu diperbaiki..."></textarea>
                        @error('revisionNotes') <div class="lgr-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="$set('showRevisionModal', false)" class="lgr-btn-ghost">Batal</button>
                    <button wire:click="requestRevision" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="lgr-btn-send">
                        <span wire:loading.remove>Kirim Revisi</span>
                        <span wire:loading class="inline-flex items-center gap-1">
                            <i class="ti ti-loader animate-spin"></i>
                            Mengirim...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>