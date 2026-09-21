<div class="adx-root">
    <style>
        .avd-hero{position:relative;overflow:hidden;border-radius:16px;padding:30px 30px 26px;background:linear-gradient(135deg,#1e2a78 0%,#2444c9 55%,#3155e7 100%);color:#fff;margin-bottom:24px}
        .avd-hero::after{content:'';position:absolute;right:-60px;top:-60px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,.07)}
        .avd-hero::before{content:'';position:absolute;right:60px;bottom:-90px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.05)}
        .avd-hero-top{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;position:relative;z-index:1}
        .avd-hero-title{font-size:22px;font-weight:800;line-height:1.3;margin:0 0 6px;color:#fff}
        .avd-hero-sub{display:flex;align-items:center;gap:6px;font-size:14px;color:rgba(255,255,255,.85);margin:0}
        .avd-hero-badge{flex-shrink:0;font-size:12px;font-weight:700;padding:6px 12px;border-radius:999px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);text-transform:uppercase;letter-spacing:.3px}
        .avd-badge-open{background:#22c55e;border-color:rgba(34,197,94,.5)}
        .avd-badge-closed{background:#6b7280;border-color:rgba(107,114,128,.5)}
        .avd-badge-draft{background:#f59e0b;border-color:rgba(245,158,11,.5)}
        .avd-hero-meta{display:flex;flex-wrap:wrap;gap:10px 18px;margin-top:18px;position:relative;z-index:1}
        .avd-hero-meta-item{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:rgba(255,255,255,.92)}
        .avd-hero-meta-item i{font-size:15px}
        .avd-grid{display:grid;grid-template-columns:1fr 330px;gap:24px;align-items:start}
        .avd-card{background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden}
        .avd-card+.avd-card{margin-top:20px}
        .avd-card-head{display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #e5e7eb;background:#fafbfe}
        .avd-card-head i{font-size:18px;color:#3155e7}
        .avd-card-head h3{margin:0;font-size:15px;font-weight:700;color:#111936}
        .avd-card-body{padding:18px 20px}
        .avd-rich{font-size:14px;line-height:1.75;color:#374151}
        .avd-rich p{margin:0 0 12px}
        .avd-rich p:last-child{margin-bottom:0}
        .avd-rich ul{list-style-type:disc;margin:0 0 12px;padding-left:20px}
        .avd-rich ol{list-style-type:decimal;margin:0 0 12px;padding-left:20px}
        .avd-rich li{margin-bottom:6px}
        .avd-summary-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px dashed #e5e7eb;font-size:13px}
        .avd-summary-row:first-child{padding-top:0}
        .avd-summary-row:last-child{border-bottom:none}
        .avd-summary-row span{color:#64708a}
        .avd-summary-row strong{color:#111936;text-align:right}
        .avd-quota{margin:14px 0 18px}
        .avd-quota-label{display:flex;align-items:center;justify-content:space-between;font-size:12px;color:#64708a;margin-bottom:7px}
        .avd-quota-bar{height:8px;border-radius:99px;background:#eef2ff;overflow:hidden}
        .avd-quota-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#3155e7,#6d8bff);transition:width .4s}
        .avd-quota-fill-full{background:#dc2626}
        .avd-filter-tabs{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:16px}
        .avd-filter-tab{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border:1px solid #e5e7eb;border-radius:10px;background:#fff;font-size:13px;font-weight:600;color:#64708a;cursor:pointer;transition:all .15s}
        .avd-filter-tab:hover{border-color:#3155e7;color:#3155e7}
        .avd-filter-tab.active{background:#eef2ff;border-color:#3155e7;color:#3155e7}
        .avd-filter-count{background:#f1f5f9;padding:1px 7px;border-radius:99px;font-size:11px;font-weight:700}
        .avd-filter-tab.active .avd-filter-count{background:#3155e7;color:#fff}
        .avd-app-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;border:1px solid}
        .avd-app-submitted{background:#f1f5f9;color:#475569;border-color:#e2e8f0}
        .avd-app-under_review{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe}
        .avd-app-interview_scheduled{background:#fefce8;color:#a16207;border-color:#fde68a}
        .avd-app-accepted{background:#ecfdf5;color:#16a34a;border-color:#a7f3d0}
        .avd-app-rejected{background:#fef2f2;color:#dc2626;border-color:#fecaca}
        .avd-app-cancelled{background:#f9fafb;color:#6b7280;border-color:#e5e7eb}
        @media(max-width:900px){.avd-grid{grid-template-columns:1fr}.avd-hero{padding:24px 20px}}
        @media(max-width:520px){.avd-hero-top{flex-direction:column}.avd-hero-title{font-size:19px}}
    </style>

    {{-- ═══ BREADCRUMB ═══ --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}" wire:navigate>Dashboard</a>
        <i class="ti ti-chevron-right"></i>
        <a href="{{ route('admin.vacancies.index') }}" wire:navigate>Lowongan</a>
        <i class="ti ti-chevron-right"></i>
        <span>{{ $vacancy->title }}</span>
    </div>

    <a href="{{ route('admin.vacancies.index') }}" wire:navigate style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#3155e7;text-decoration:none;margin-bottom:16px">
        <i class="ti ti-arrow-left"></i> Kembali ke daftar
    </a>

    @php
        $daysLeft = (int) now()->startOfDay()->diffInDays($vacancy->application_deadline);
        $filled = min($vacancy->accepted_applications_count, $vacancy->quota);
        $quotaPct = $vacancy->quota > 0 ? round($filled / $vacancy->quota * 100) : 0;
        $isFull = $vacancy->isFull();
        $isOpen = $vacancy->isOpen();
    @endphp

    {{-- ═══ HERO ═══ --}}
    <div class="avd-hero">
        <div class="avd-hero-top">
            <div>
                <h1 class="avd-hero-title">{{ $vacancy->title }}</h1>
                <p class="avd-hero-sub"><i class="ti ti-building"></i> {{ $vacancy->division }}</p>
            </div>
            <span class="avd-hero-badge {{ $isOpen ? 'avd-badge-open' : ($vacancy->status === 'draft' ? 'avd-badge-draft' : 'avd-badge-closed') }}">
                {{ $isOpen ? 'Terbuka' : ($vacancy->status === 'draft' ? 'Draft' : 'Tutup') }}
            </span>
        </div>
        <div class="avd-hero-meta">
            <span class="avd-hero-meta-item">
                <i class="ti ti-calendar-time"></i>
                {{ $vacancy->start_date?->isoFormat('D MMM Y') }} – {{ $vacancy->end_date?->isoFormat('D MMM Y') }}
            </span>
            <span class="avd-hero-meta-item">
                <i class="ti ti-calendar-exclamation"></i>
                Deadline: {{ $vacancy->application_deadline?->isoFormat('D MMM Y') }}
            </span>
            <span class="avd-hero-meta-item">
                <i class="ti ti-users"></i>
                {{ $vacancy->applications()->count() }} pelamar
            </span>
            @if($isFull)
                <span class="avd-hero-meta-item"><i class="ti ti-circle-check"></i> Kuota terpenuhi</span>
            @endif
        </div>
    </div>

    {{-- ═══ MAIN GRID ═══ --}}
    <div class="avd-grid">
        <div class="avd-main">
            {{-- Deskripsi --}}
            <div class="avd-card">
                <div class="avd-card-head">
                    <i class="ti ti-file-text"></i>
                    <h3>Deskripsi</h3>
                </div>
                <div class="avd-card-body">
                    <div class="avd-rich">{!! clean($vacancy->description) !!}</div>
                </div>
            </div>

            {{-- Kualifikasi --}}
            @if($vacancy->qualifications)
                <div class="avd-card">
                    <div class="avd-card-head">
                        <i class="ti ti-badge-check"></i>
                        <h3>Kualifikasi</h3>
                    </div>
                    <div class="avd-card-body">
                        <div class="avd-rich">{!! clean($vacancy->qualifications) !!}</div>
                    </div>
                </div>
            @endif

            {{-- ═══ DAFTAR PELAMAR ═══ --}}
            <div class="avd-card" style="margin-top:20px">
                <div class="avd-card-head">
                    <i class="ti ti-users-group"></i>
                    <h3>Daftar Pelamar</h3>
                </div>
                <div class="avd-card-body" style="padding:14px 20px 18px">
                    {{-- Filter Tabs --}}
                    <div class="avd-filter-tabs">
                        <button wire:click="$set('filterStatus', '')" class="avd-filter-tab {{ $filterStatus === '' ? 'active' : '' }}">
                            Semua <span class="avd-filter-count">{{ $statusCounts['all'] }}</span>
                        </button>
                        <button wire:click="$set('filterStatus', 'active')" class="avd-filter-tab {{ $filterStatus === 'active' ? 'active' : '' }}">
                            Menunggu <span class="avd-filter-count">{{ $statusCounts['submitted'] + $statusCounts['under_review'] + $statusCounts['interview'] }}</span>
                        </button>
                        <button wire:click="$set('filterStatus', 'accepted')" class="avd-filter-tab {{ $filterStatus === 'accepted' ? 'active' : '' }}">
                            Diterima <span class="avd-filter-count">{{ $statusCounts['accepted'] }}</span>
                        </button>
                    </div>

                    {{-- Table --}}
                    <div class="adx-table-scroll">
                        <table class="adx-table">
                            <thead>
                                <tr>
                                    <th>Pelamar</th>
                                    <th>Institusi</th>
                                    <th>Tgl Daftar</th>
                                    <th>Status</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $applicants = $this->applications;
                                    $appStatusLabels = [
                                        'submitted' => 'Terkirim',
                                        'under_review' => 'Direview',
                                        'interview_scheduled' => 'Interview',
                                        'accepted' => 'Diterima',
                                        'rejected' => 'Ditolak',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                @forelse($applicants as $app)
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
                                                    <div class="adx-table-email">{{ $app->intern?->email ?? '—' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="adx-table-title-cell">{{ $institution }}</span></td>
                                        <td><span class="adx-date">{{ $app->applied_at?->format('d M Y') ?? '—' }}</span></td>
                                        <td>
                                            <span class="avd-app-chip avd-app-{{ $app->status }}">
                                                {{ $appStatusLabels[$app->status] ?? ucfirst(str_replace('_', ' ', $app->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <div class="adx-actions">
                                                <a href="{{ route('admin.applications.show', $app->id) }}" wire:navigate class="adx-action" title="Lihat Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            @if($filterStatus !== '')
                                                <x-empty-state icon="ti-filter-off" message="Tidak ada pelamar dengan filter ini." />
                                            @else
                                                <x-empty-state icon="ti-users" message="Belum ada yang melamar lowongan ini." />
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ SIDEBAR ═══ --}}
        <aside>
            <div class="avd-card">
                <div class="avd-card-head">
                    <i class="ti ti-briefcase"></i>
                    <h3>Ringkasan</h3>
                </div>
                <div class="avd-card-body">
                    <div class="avd-summary-row">
                        <span>Divisi</span>
                        <strong>{{ $vacancy->division ?? '—' }}</strong>
                    </div>
                    <div class="avd-summary-row">
                        <span>Periode</span>
                        <strong>{{ $vacancy->start_date?->isoFormat('D MMM') }} – {{ $vacancy->end_date?->isoFormat('D MMM Y') }}</strong>
                    </div>
                    <div class="avd-summary-row">
                        <span>Deadline</span>
                        <strong>
                            @if($daysLeft < 0)
                                Melewati tenggat
                            @elseif($daysLeft === 0)
                                Hari ini
                            @elseif($daysLeft === 1)
                                Besok
                            @else
                                {{ $daysLeft }} hari lagi
                            @endif
                        </strong>
                    </div>
                    <div class="avd-summary-row">
                        <span>Pembuat</span>
                        <strong>{{ $vacancy->creator?->name ?? '—' }}</strong>
                    </div>

                    <div class="avd-quota">
                        <div class="avd-quota-label">
                            <span>Kuota terisi</span>
                            <span>{{ $filled }}/{{ $vacancy->quota }}</span>
                        </div>
                        <div class="avd-quota-bar">
                            <div class="avd-quota-fill {{ $isFull ? 'avd-quota-fill-full' : '' }}" style="width:{{ $quotaPct }}%"></div>
                        </div>
                    </div>

                    <div class="avd-summary-row">
                        <span>Total Pelamar</span>
                        <strong>{{ $vacancy->applications()->count() }}</strong>
                    </div>
                    <div class="avd-summary-row">
                        <span>Menunggu Review</span>
                        <strong>{{ $statusCounts['submitted'] + $statusCounts['under_review'] }}</strong>
                    </div>
                    <div class="avd-summary-row">
                        <span>Diterima</span>
                        <strong style="color:#16a34a">{{ $statusCounts['accepted'] }}</strong>
                    </div>

                    <a href="{{ route('admin.applications.index') }}?filterVacancy={{ $vacancy->id }}" wire:navigate
                       class="avd-btn-primary" style="display:flex;margin-top:18px;padding:11px 18px;border:none;border-radius:12px;font-size:14px;font-weight:700;color:#fff;background:linear-gradient(90deg,#2444c9,#3155e7);box-shadow:0 6px 18px rgba(49,85,231,.3);text-decoration:none;justify-content:center;align-items:center;gap:8px;transition:transform .15s,box-shadow .15s">
                        <i class="ti ti-list-check"></i> Lihat Semua Lamaran
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>
