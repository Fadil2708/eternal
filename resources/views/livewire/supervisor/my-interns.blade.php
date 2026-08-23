<div class="mni-root">

    <style>
        .mni-root {
            --mni-primary: #3155e7;
            --mni-primary-dark: #2444c9;
            --mni-primary-light: #eef2ff;
            --mni-text: #111936;
            --mni-muted: #64708a;
            --mni-border: #e5e7eb;
            --mni-green: #16a34a;
            --mni-green-bg: #ecfdf5;
            --mni-red: #dc2626;
            --mni-red-bg: #fef2f2;
            --pagination-active-bg: #3155e7;
        }

        /* ═══ HEADER ═══ */
        .mni-header {
            margin-bottom: 20px;
        }
        .mni-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--mni-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .mni-sub {
            font-size: 13px;
            color: var(--mni-muted);
            margin: 0;
        }

        /* ═══ FILTER BAR ═══ */
        .mni-filter {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            background: #fff;
            border: 1px solid var(--mni-border);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 16px;
        }
        .mni-search {
            position: relative;
            flex: 1;
            min-width: 220px;
            max-width: 320px;
        }
        .mni-search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: var(--mni-muted);
            pointer-events: none;
        }
        .mni-search input {
            width: 100%;
            padding: 10px 12px 10px 36px;
            font-size: 13px;
            font-family: inherit;
            color: var(--mni-text);
            background: #fff;
            border: 1px solid var(--mni-border);
            border-radius: 10px;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .mni-search input::placeholder { color: #9aa3b5; }
        .mni-search input:focus {
            border-color: var(--mni-primary);
            box-shadow: 0 0 0 3px var(--mni-primary-light);
        }
        .mni-chips {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .mni-chip {
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 700;
            font-family: inherit;
            color: var(--mni-muted);
            background: #fff;
            border: 1px solid var(--mni-border);
            border-radius: 99px;
            cursor: pointer;
            transition: background .15s ease, color .15s ease, border-color .15s ease;
        }
        .mni-chip:hover {
            border-color: var(--mni-primary);
            color: var(--mni-primary);
        }
        .mni-chip.is-active {
            background: var(--mni-primary);
            border-color: var(--mni-primary);
            color: #fff;
        }

        /* ═══ TABLE ═══ */
        .mni-card {
            background: #fff;
            border: 1px solid var(--mni-border);
            border-radius: 14px;
            overflow: hidden;
        }
        .mni-table {
            width: 100%;
            border-collapse: collapse;
        }
        .mni-table thead th {
            text-align: left;
            padding: 13px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--mni-muted);
            background: #f8fafc;
            border-bottom: 1px solid var(--mni-border);
            white-space: nowrap;
        }
        .mni-table tbody td {
            padding: 13px 16px;
            font-size: 13px;
            color: var(--mni-text);
            border-bottom: 1px solid var(--mni-border);
            vertical-align: middle;
        }
        .mni-table tbody tr:last-child td { border-bottom: none; }
        .mni-table tbody tr {
            transition: background .12s ease;
        }
        .mni-table tbody tr:hover { background: #f8fafc; }

        .mni-user {
            display: flex;
            align-items: center;
            gap: 11px;
        }
        .mni-user-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--mni-text);
            line-height: 1.3;
        }
        .mni-user-mail {
            font-size: 11px;
            color: var(--mni-muted);
            margin-top: 2px;
        }
        .mni-muted { color: var(--mni-muted); }

        .mni-progress {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .mni-track {
            flex: 1;
            min-width: 80px;
            max-width: 120px;
            height: 8px;
            border-radius: 99px;
            background: #eef2f7;
            overflow: hidden;
        }
        .mni-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, #3155e7, #4f6ef5);
            transition: width .4s ease;
        }
        .mni-count {
            font-size: 12px;
            font-weight: 700;
            color: var(--mni-muted);
            white-space: nowrap;
        }

        .mni-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 11px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }
        .mni-badge.is-active    { background: var(--mni-primary-light); color: var(--mni-primary); }
        .mni-badge.is-completed { background: var(--mni-green-bg); color: var(--mni-green); }
        .mni-badge.is-terminated{ background: var(--mni-red-bg); color: var(--mni-red); }

        .mni-actions {
            display: flex;
            justify-content: flex-end;
            gap: 6px;
        }
        .mni-action {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            color: var(--mni-muted);
            border: 1px solid var(--mni-border);
            background: #fff;
            text-decoration: none;
            transition: background .15s ease, color .15s ease, border-color .15s ease;
        }
        .mni-action:hover {
            background: var(--mni-primary-light);
            border-color: var(--mni-primary);
            color: var(--mni-primary);
        }

        /* ═══ EMPTY ═══ */
        .mni-empty {
            text-align: center;
            padding: 40px 20px;
        }
        .mni-empty-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 12px;
            border-radius: 16px;
            background: var(--mni-primary-light);
            color: var(--mni-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }
        .mni-empty p {
            font-size: 13px;
            color: var(--mni-muted);
            margin: 0;
        }

        /* ═══ PAGINATION ═══ */
        .mni-pagination {
            padding: 14px 16px;
            border-top: 1px solid var(--mni-border);
        }
        .mni-pagination .pagination-wrap {
            display: flex;
            justify-content: center;
            padding: 0;
        }
        .mni-pagination .action-btn {
            border-color: var(--mni-border);
        }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 820px) {
            .mni-table thead { display: none; }
            .mni-table,
            .mni-table tbody,
            .mni-table tr,
            .mni-table td { display: block; width: 100%; }
            .mni-table tbody tr {
                padding: 14px 16px;
                border-bottom: 1px solid var(--mni-border);
            }
            .mni-table tbody tr:last-child { border-bottom: none; }
            .mni-table tbody td {
                border: none;
                padding: 7px 0;
            }
            .mni-table tbody td:first-child { padding-top: 0; }
            .mni-table tbody td:last-child { padding-bottom: 0; }
            .mni-table tbody td[data-label] {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
            }
            .mni-table tbody td[data-label]::before {
                content: attr(data-label);
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .04em;
                color: var(--mni-muted);
            }
            .mni-actions { justify-content: flex-end; }
        }
        @media (max-width: 620px) {
            .mni-filter { flex-direction: column; align-items: stretch; }
            .mni-search { max-width: none; }
        }
    </style>

    {{-- ═══ HEADER ═══ --}}
    <div class="mni-header">
        <div class="breadcrumb">
            <a href="{{ route('supervisor.dashboard') }}" wire:navigate>Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <span>Peserta Bimbingan</span>
        </div>
        <h2 class="mni-title">Peserta Bimbingan</h2>
        <p class="mni-sub">Pantau dan kelola peserta magang bimbingan Anda</p>
    </div>

    {{-- ═══ FILTER ═══ --}}
    <div class="mni-filter">
        <div class="mni-search">
            <i class="ti ti-search"></i>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari peserta...">
        </div>
        <div class="mni-chips">
            <button wire:click="$set('filterStatus', '')" class="mni-chip" :class="{ 'is-active': !filterStatus }">Semua Status</button>
            <button wire:click="$set('filterStatus', 'active')" class="mni-chip" :class="{ 'is-active': filterStatus === 'active' }">Aktif</button>
            <button wire:click="$set('filterStatus', 'completed')" class="mni-chip" :class="{ 'is-active': filterStatus === 'completed' }">Selesai</button>
            <button wire:click="$set('filterStatus', 'terminated')" class="mni-chip" :class="{ 'is-active': filterStatus === 'terminated' }">Terminasi</button>
        </div>
    </div>

    {{-- ═══ TABLE ═══ --}}
    <div class="mni-card">
        <table class="mni-table">
            <thead>
                <tr>
                    <th>Peserta</th>
                    <th>Lowongan</th>
                    <th>Periode</th>
                    <th>Logbook</th>
                    <th>Status</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($internships as $internship)
                @php $pct = $internship->logbooks_count > 0 ? round(($internship->approved_logbooks_count / $internship->logbooks_count) * 100) : 0; @endphp
                <tr>
                    <td data-label="Peserta">
                        <div class="mni-user">
                            <x-avatar :name="$internship->intern->internProfile->full_name ?? $internship->intern->email ?? ''" :size="34" />
                            <div>
                                <div class="mni-user-name">{{ $internship->intern->internProfile->full_name ?? $internship->intern->email }}</div>
                                <div class="mni-user-mail">{{ $internship->intern->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td data-label="Lowongan" class="mni-muted">{{ $internship->vacancy->title }}</td>
                    <td data-label="Periode" class="mni-muted">{{ ($internship->actual_start_date ?? $internship->vacancy?->start_date)?->format('d M Y') ?? '—' }} - {{ ($internship->actual_end_date ?? $internship->vacancy?->end_date)?->format('d M Y') ?? '—' }}</td>
                    <td data-label="Logbook">
                        <div class="mni-progress">
                            <div class="mni-track"><div class="mni-fill" style="width:{{ $pct }}%"></div></div>
                            <span class="mni-count">{{ $internship->approved_logbooks_count }}/{{ $internship->logbooks_count }}</span>
                        </div>
                    </td>
                    <td data-label="Status">
                        <span class="mni-badge is-{{ $internship->status }}">
                            {{ $internship->status === 'active' ? 'Aktif' : ($internship->status === 'completed' ? 'Selesai' : 'Terminasi') }}
                        </span>
                    </td>
                    <td data-label="Aksi">
                        <div class="mni-actions">
                            <a href="{{ route('supervisor.logbooks', ['intern_id' => $internship->intern_id]) }}" class="mni-action" title="Lihat Logbook">
                                <i class="ti ti-notebook"></i>
                            </a>
                            <a href="{{ route('supervisor.evaluations.show', $internship->id) }}" class="mni-action" title="Beri Nilai">
                                <i class="ti ti-star"></i>
                            </a>
                            <a href="{{ route('supervisor.interns.show', $internship) }}" class="mni-action" title="Detail">
                                <i class="ti ti-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="mni-empty">
                            <div class="mni-empty-icon"><i class="ti ti-users"></i></div>
                            <p>Belum ada peserta yang cocok.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($internships->hasPages())
        <div class="mni-pagination">
            {{ $internships->links('components.pagination', ['paginator' => $internships]) }}
        </div>
        @endif
    </div>

</div>