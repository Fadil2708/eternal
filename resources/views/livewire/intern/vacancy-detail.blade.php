<div class="vd-wrap">
    <style>
        .vd-wrap{--vd-primary:#3155e7;--vd-primary-dark:#2444c9;--vd-primary-light:#eef2ff;--vd-text:#111936;--vd-muted:#64708a;--vd-border:#e5e7eb;--vd-danger:#dc2626}
        .vd-breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:13px;color:var(--vd-muted);margin:0 0 18px}
        .vd-breadcrumb a{color:var(--vd-muted);text-decoration:none;transition:color .2s}
        .vd-breadcrumb a:hover{color:var(--vd-primary)}
        .vd-breadcrumb i{font-size:14px;opacity:.6}
        .vd-breadcrumb span{color:var(--vd-text);font-weight:600}
        .vd-back{display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:var(--vd-primary);text-decoration:none;margin-bottom:16px;transition:opacity .2s}
        .vd-back:hover{opacity:.75}
        .vd-hero{position:relative;overflow:hidden;border-radius:16px;padding:30px 30px 26px;background:linear-gradient(135deg,#1e2a78 0%,#2444c9 55%,#3155e7 100%);color:#fff;margin-bottom:24px}
        .vd-hero::after{content:'';position:absolute;right:-60px;top:-60px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,.07)}
        .vd-hero::before{content:'';position:absolute;right:60px;bottom:-90px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,.05)}
        .vd-hero-top{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;position:relative;z-index:1}
        .vd-hero-title{font-size:22px;font-weight:800;line-height:1.3;margin:0 0 6px;color:#fff}
        .vd-hero-sub{display:flex;align-items:center;gap:6px;font-size:14px;color:rgba(255,255,255,.85);margin:0}
        .vd-hero-badge{flex-shrink:0;font-size:12px;font-weight:700;padding:6px 12px;border-radius:999px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);text-transform:uppercase;letter-spacing:.3px}
        .vd-badge-open{background:#22c55e;border-color:rgba(34,197,94,.5)}
        .vd-badge-closed{background:#6b7280;border-color:rgba(107,114,128,.5)}
        .vd-hero-meta{display:flex;flex-wrap:wrap;gap:10px 18px;margin-top:18px;position:relative;z-index:1}
        .vd-hero-meta-item{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:rgba(255,255,255,.92)}
        .vd-hero-meta-item i{font-size:15px}
        .vd-applied{display:flex;align-items:center;gap:14px;border-radius:14px;padding:14px 18px;margin-bottom:22px;background:#ecfdf3;border:1px solid #a7f3d0}
        .vd-applied>i{font-size:26px;color:#16a34a}
        .vd-applied div{flex:1;min-width:0}
        .vd-applied strong{display:block;font-size:14px;color:#14532d}
        .vd-applied span{font-size:12px;color:#15803d}
        .vd-grid{display:grid;grid-template-columns:1fr 330px;gap:24px;align-items:start}
        .vd-card{background:#fff;border:1px solid var(--vd-border);border-radius:14px;overflow:hidden}
        .vd-card+.vd-card{margin-top:20px}
        .vd-card-head{display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid var(--vd-border);background:#fafbfe}
        .vd-card-head i{font-size:18px;color:var(--vd-primary)}
        .vd-card-head h3{margin:0;font-size:15px;font-weight:700;color:var(--vd-text)}
        .vd-card-body{padding:18px 20px}
        .vd-rich{font-size:14px;line-height:1.75;color:#374151}
        .vd-rich p{margin:0 0 12px}
        .vd-rich p:last-child{margin-bottom:0}
        .vd-rich ul,.vd-rich ol{margin:0 0 12px;padding-left:20px}
        .vd-rich li{margin-bottom:6px}
        .vd-rich h1,.vd-rich h2,.vd-rich h3,.vd-rich h4{color:var(--vd-text);margin:0 0 8px}
        .vd-summary-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px dashed var(--vd-border);font-size:13px}
        .vd-summary-row:first-child{padding-top:0}
        .vd-summary-row:last-of-type{border-bottom:none}
        .vd-summary-row span{color:var(--vd-muted)}
        .vd-summary-row strong{color:var(--vd-text);text-align:right}
        .vd-quota{margin:14px 0 18px}
        .vd-quota-label{display:flex;align-items:center;justify-content:space-between;font-size:12px;color:var(--vd-muted);margin-bottom:7px}
        .vd-quota-bar{height:8px;border-radius:99px;background:#eef2ff;overflow:hidden}
        .vd-quota-fill{height:100%;border-radius:99px;background:linear-gradient(90deg,#3155e7,#6d8bff);transition:width .4s}
        .vd-quota-fill-full{background:#dc2626}
        .vd-btn-primary{display:inline-flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:12px 20px;border:none;border-radius:12px;font-size:14px;font-weight:700;color:#fff;background:linear-gradient(90deg,#2444c9,#3155e7);box-shadow:0 6px 18px rgba(49,85,231,.3);text-decoration:none;transition:transform .15s,box-shadow .15s,opacity .15s}
        .vd-btn-primary:hover{transform:translateY(-1px);box-shadow:0 10px 24px rgba(49,85,231,.4)}
        .vd-btn-primary:disabled{opacity:.6;cursor:not-allowed;transform:none}
        @media(max-width:900px){.vd-grid{grid-template-columns:1fr}.vd-hero{padding:24px 20px}}
        @media(max-width:520px){.vd-hero-top{flex-direction:column}.vd-hero-title{font-size:19px}}
    </style>

    <nav class="vd-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('intern.dashboard') }}">Dashboard</a>
        <i class="ti ti-chevron-right"></i>
        <a href="{{ route('intern.vacancies') }}">Lowongan</a>
        <i class="ti ti-chevron-right"></i>
        <span>{{ $vacancy->title }}</span>
    </nav>

    <a href="{{ route('intern.vacancies') }}" class="vd-back">
        <i class="ti ti-arrow-left"></i> Kembali ke daftar
    </a>

    @php
        $daysLeft = (int) now()->startOfDay()->diffInDays($vacancy->application_deadline);
        $filled = min($vacancy->accepted_applications_count, $vacancy->quota);
        $quotaPct = $vacancy->quota > 0 ? round($filled / $vacancy->quota * 100) : 0;
        $isFull = $vacancy->isFull();
        $isOpen = $vacancy->isOpen();
    @endphp

    <div class="vd-hero">
        <div class="vd-hero-top">
            <div>
                <h1 class="vd-hero-title">{{ $vacancy->title }}</h1>
                <p class="vd-hero-sub"><i class="ti ti-building"></i> {{ $vacancy->division }}</p>
            </div>
            <span class="vd-hero-badge {{ $isOpen ? 'vd-badge-open' : 'vd-badge-closed' }}">
                {{ $isOpen ? 'Terbuka' : 'Tutup' }}
            </span>
        </div>
        <div class="vd-hero-meta">
            <span class="vd-hero-meta-item">
                <i class="ti ti-calendar-time"></i>
                {{ $vacancy->start_date?->isoFormat('D MMM Y') }} – {{ $vacancy->end_date?->isoFormat('D MMM Y') }}
            </span>
            <span class="vd-hero-meta-item">
                <i class="ti ti-calendar-exclamation"></i>
                Deadline: {{ $vacancy->application_deadline?->isoFormat('D MMM Y') }}
            </span>
            @if($isFull)
                <span class="vd-hero-meta-item"><i class="ti ti-users"></i> Kuota terpenuhi</span>
            @endif
        </div>
    </div>

    @if($hasApplied)
        <div class="vd-applied">
            <i class="ti ti-circle-check"></i>
            <div>
                <strong>Kamu sudah melamar lowongan ini</strong>
                <span>Status lamaran:
                    <x-badge :status="$applicationStatus" />
                </span>
            </div>
            <a href="{{ route('intern.applications') }}" class="vd-btn-primary" style="width:auto;padding:10px 16px;font-size:13px">
                <i class="ti ti-list-check"></i> Lihat Lamaran
            </a>
        </div>
    @endif

    <div class="vd-grid">
        <div class="vd-main">
            <div class="vd-card">
                <div class="vd-card-head">
                    <i class="ti ti-file-text"></i>
                    <h3>Deskripsi</h3>
                </div>
                <div class="vd-card-body">
                    <div class="vd-rich">{!! clean($vacancy->description) !!}</div>
                </div>
            </div>

            @if($vacancy->qualifications)
                <div class="vd-card">
                    <div class="vd-card-head">
                        <i class="ti ti-badge-check"></i>
                        <h3>Kualifikasi</h3>
                    </div>
                    <div class="vd-card-body">
                        <div class="vd-rich">{!! clean($vacancy->qualifications) !!}</div>
                    </div>
                </div>
            @endif
        </div>

        <aside class="vd-side">
            <div class="vd-card">
                <div class="vd-card-head">
                    <i class="ti ti-briefcase"></i>
                    <h3>Ringkasan</h3>
                </div>
                <div class="vd-card-body">
                    <div class="vd-summary-row">
                        <span>Divisi</span>
                        <strong>{{ $vacancy->division ?? '—' }}</strong>
                    </div>
                    <div class="vd-summary-row">
                        <span>Periode</span>
                        <strong>{{ $vacancy->start_date?->isoFormat('D MMM') }} – {{ $vacancy->end_date?->isoFormat('D MMM Y') }}</strong>
                    </div>
                    <div class="vd-summary-row">
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

                    <div class="vd-quota">
                        <div class="vd-quota-label">
                            <span>Kuota terisi</span>
                            <span class="{{ $isFull ? '' : '' }}">{{ $filled }}/{{ $vacancy->quota }}</span>
                        </div>
                        <div class="vd-quota-bar">
                            <div class="vd-quota-fill {{ $isFull ? 'vd-quota-fill-full' : '' }}" style="width:{{ $quotaPct }}%"></div>
                        </div>
                    </div>

                    @if($hasApplied)
                        <a href="{{ route('intern.applications') }}" class="vd-btn-primary">
                            <i class="ti ti-check"></i> Lihat Lamaran Saya
                        </a>
                    @elseif(!$isOpen || $isFull)
                        <button class="vd-btn-primary" disabled style="cursor:not-allowed">
                            <i class="ti ti-x-circle"></i> Kuota Penuh
                        </button>
                    @else
                        <a href="{{ route('intern.applications.create', $vacancy->id) }}" class="vd-btn-primary" wire:navigate>
                            <i class="ti ti-send"></i> Lamar Sekarang
                        </a>
                    @endif
                </div>
            </div>
        </aside>
    </div>
</div>