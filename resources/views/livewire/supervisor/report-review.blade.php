<div class="rpr-root">

    <style>
        .rpr-root {
            --rpr-primary: #3155e7;
            --rpr-primary-dark: #2444c9;
            --rpr-primary-light: #eef2ff;
            --rpr-text: #111936;
            --rpr-muted: #64708a;
            --rpr-border: #e5e7eb;
            --rpr-amber: #b45309;
            --rpr-amber-bg: #fffbeb;
            --rpr-green: #16a34a;
            --rpr-green-bg: #ecfdf5;
            --rpr-red: #dc2626;
            --rpr-red-bg: #fef2f2;
            --pagination-active-bg: #3155e7;
        }

        /* ═══ HEADER ═══ */
        .rpr-header {
            margin-bottom: 20px;
        }
        .rpr-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--rpr-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .rpr-sub {
            font-size: 13px;
            color: var(--rpr-muted);
            margin: 0;
        }

        /* ═══ FILTER BAR ═══ */
        .rpr-filter {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            background: #fff;
            border: 1px solid var(--rpr-border);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 14px;
        }
        .rpr-chips {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .rpr-chip {
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 700;
            font-family: inherit;
            color: var(--rpr-muted);
            background: #fff;
            border: 1px solid var(--rpr-border);
            border-radius: 99px;
            cursor: pointer;
            transition: background .15s ease, color .15s ease, border-color .15s ease;
        }
        .rpr-chip:hover {
            border-color: var(--rpr-primary);
            color: var(--rpr-primary);
        }
        .rpr-chip.is-active {
            background: var(--rpr-primary);
            border-color: var(--rpr-primary);
            color: #fff;
        }

        /* ═══ CARDS ═══ */
        .rpr-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .rpr-card {
            background: #fff;
            border: 1px solid var(--rpr-border);
            border-radius: 14px;
            padding: 18px 20px;
            transition: box-shadow .15s ease;
        }
        .rpr-card:hover { box-shadow: 0 6px 18px rgba(17, 25, 54, .06); }
        .rpr-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }
        .rpr-card-body { flex: 1; min-width: 0; }
        .rpr-who {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .rpr-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--rpr-text);
            line-height: 1.3;
        }
        .rpr-role {
            font-size: 11px;
            color: var(--rpr-muted);
            margin-top: 2px;
        }
        .rpr-title-text {
            font-size: 15px;
            font-weight: 800;
            color: var(--rpr-text);
            margin: 0 0 8px;
            line-height: 1.4;
        }
        .rpr-meta {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .rpr-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: var(--rpr-muted);
        }
        .rpr-meta-item i { font-size: 14px; }
        .rpr-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 700;
            color: var(--rpr-primary);
            text-decoration: none;
        }
        .rpr-link:hover { text-decoration: underline; }
        .rpr-approved-note {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            color: var(--rpr-green);
            margin: 10px 0 0;
        }
        .rpr-approved-note i { font-size: 14px; }
        .rpr-badge {
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
        .rpr-badge.is-pending  { background: var(--rpr-amber-bg); color: var(--rpr-amber); }
        .rpr-badge.is-approved { background: var(--rpr-green-bg); color: var(--rpr-green); }
        .rpr-badge.is-rejected { background: var(--rpr-red-bg); color: var(--rpr-red); }

        .rpr-card-foot {
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--rpr-border);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .rpr-btn {
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
        .rpr-btn i { font-size: 15px; }
        .rpr-btn-approve {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #fff;
            border: none;
            box-shadow: 0 4px 12px rgba(22, 163, 74, .25);
        }
        .rpr-btn-approve:hover {
            box-shadow: 0 6px 16px rgba(22, 163, 74, .35);
            transform: translateY(-1px);
        }
        .rpr-btn-reject {
            background: #fff;
            color: var(--rpr-red);
            border: 1px solid #fca5a5;
        }
        .rpr-btn-reject:hover {
            background: var(--rpr-red-bg);
        }

        /* ═══ EMPTY ═══ */
        .rpr-empty {
            text-align: center;
            padding: 44px 20px;
            background: #fff;
            border: 1px solid var(--rpr-border);
            border-radius: 14px;
        }
        .rpr-empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 12px;
            border-radius: 16px;
            background: var(--rpr-primary-light);
            color: var(--rpr-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }
        .rpr-empty p {
            font-size: 13px;
            color: var(--rpr-muted);
            margin: 0;
        }

        /* ═══ PAGINATION ═══ */
        .rpr-pagination {
            margin-top: 16px;
        }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 560px) {
            .rpr-filter { flex-direction: column; align-items: stretch; }
            .rpr-card { padding: 16px 14px; }
            .rpr-card-top { flex-direction: column; }
            .rpr-badge { align-self: flex-start; }
        }
    </style>

    {{-- ═══ HEADER ═══ --}}
    <div class="rpr-header">
        <div class="breadcrumb">
            <a href="{{ route('supervisor.dashboard') }}" wire:navigate>Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <span>Review Laporan</span>
        </div>
        <h2 class="rpr-title">Review Laporan</h2>
        <p class="rpr-sub">Periksa dan validasi laporan akhir peserta bimbingan</p>
    </div>

    {{-- ═══ FILTER BAR ═══ --}}
    <div class="rpr-filter">
        <div class="rpr-chips">
            <button wire:click="$set('filterStatus', 'pending')" class="rpr-chip" :class="{ 'is-active': filterStatus === 'pending' }">Perlu Review</button>
            <button wire:click="$set('filterStatus', 'approved')" class="rpr-chip" :class="{ 'is-active': filterStatus === 'approved' }">Disetujui</button>
            <button wire:click="$set('filterStatus', 'rejected')" class="rpr-chip" :class="{ 'is-active': filterStatus === 'rejected' }">Ditolak</button>
            <button wire:click="$set('filterStatus', '')" class="rpr-chip" :class="{ 'is-active': !filterStatus }">Semua</button>
        </div>
    </div>

    {{-- ═══ LIST ═══ --}}
    <div class="rpr-list" wire:loading.class="opacity-40 pointer-events-none">
        @forelse($reports as $report)
        <div wire:key="{{ $report->id }}" class="rpr-card">
            <div class="rpr-card-top">
                <div class="rpr-card-body">
                    <div class="rpr-who">
                        <x-avatar :name="$report->intern?->internProfile?->full_name ?? $report->intern?->email ?? ''" :size="34" />
                        <div>
                            <div class="rpr-name">{{ $report->intern?->internProfile?->full_name ?? $report->intern?->email }}</div>
                            <div class="rpr-role">{{ $report->internship?->vacancy?->title }}</div>
                        </div>
                    </div>

                    <h4 class="rpr-title-text">{{ $report->title }}</h4>

                    <div class="rpr-meta">
                        <span class="rpr-meta-item">
                            <i class="ti ti-calendar"></i>
                            {{ $report->submitted_at?->isoFormat('D MMMM Y HH:mm') ?? '—' }}
                        </span>
                        @if($report->file_size_kb)
                        <span class="rpr-meta-item">
                            <i class="ti ti-file"></i>
                            {{ number_format($report->file_size_kb / 1024, 1) }} MB
                        </span>
                        @endif
                        <a href="{{ route('private.serve', ['path' => $report->file_url]) }}" target="_blank" class="rpr-link">
                            <i class="ti ti-eye"></i> Lihat File
                        </a>
                    </div>

                    @if($report->approved_at)
                        <p class="rpr-approved-note">
                            <i class="ti ti-circle-check"></i> Disetujui: {{ $report->approved_at?->isoFormat('D MMMM Y HH:mm') ?? '—' }}
                        </p>
                    @endif
                </div>

                <span class="rpr-badge is-{{ $report->supervisor_approval }}">
                    {{ $report->supervisor_approval === 'approved' ? 'Disetujui' : ($report->supervisor_approval === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                </span>
            </div>

            @if($report->supervisor_approval === 'pending')
            <div class="rpr-card-foot">
                <button wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                        @click="window.dispatchEvent(new CustomEvent('confirm', { detail: { message: 'Setujui laporan ini?', callback: () => $wire.approve('{{ $report->id }}') } }))"
                        class="rpr-btn rpr-btn-approve">
                    <i class="ti ti-check"></i> Setujui
                </button>
                <button wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                        @click="window.dispatchEvent(new CustomEvent('confirm', { detail: { message: 'Tolak laporan ini?', callback: () => $wire.reject('{{ $report->id }}') } }))"
                        class="rpr-btn rpr-btn-reject">
                    <i class="ti ti-x"></i> Tolak
                </button>
            </div>
            @endif
        </div>
        @empty
        <div class="rpr-empty">
            <div class="rpr-empty-icon"><i class="ti ti-file-description"></i></div>
            <p>Tidak ada laporan akhir {{ $filterStatus ? 'dengan status ini' : '' }}.</p>
        </div>
        @endforelse
    </div>

    @if($reports->hasPages())
    <div class="rpr-pagination">
        {{ $reports->links('components.pagination', ['paginator' => $reports]) }}
    </div>
    @endif

</div>