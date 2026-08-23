<div class="evl-root">
    <style>
        .evl-root {
            --evl-primary: #3155e7;
            --evl-primary-dark: #2444c9;
            --evl-primary-light: #eef2ff;
            --evl-text: #111936;
            --evl-muted: #64708a;
            --evl-border: #e5e7eb;
        }

        /* ═══ HEADER ═══ */
        .evl-header { margin-bottom: 22px; }
        .evl-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--evl-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .evl-sub { font-size: 13px; color: var(--evl-muted); margin: 0; }

        /* ═══ WRAP ═══ */
        .evl-wrap { max-width: 720px; margin: 0 auto; }
        .evl-card {
            background: #fff;
            border: 1px solid var(--evl-border);
            border-radius: 14px;
            padding: 24px 26px;
            margin-bottom: 20px;
        }
        .evl-section-head {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 11px;
            font-weight: 800;
            color: var(--evl-primary);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 18px;
        }
        .evl-section-head i { font-size: 15px; }

        /* ═══ EMPTY STATE ═══ */
        .evl-empty {
            text-align: center;
            padding: 48px 24px;
            background: #fff;
            border: 1px solid var(--evl-border);
            border-radius: 14px;
        }
        .evl-empty-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            border-radius: 18px;
            background: var(--evl-primary-light);
            color: var(--evl-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        .evl-empty-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--evl-text);
            margin: 0 0 6px;
        }
        .evl-empty-sub {
            font-size: 13px;
            color: var(--evl-muted);
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ═══ HERO SCORE ═══ */
        .evl-hero {
            position: relative;
            overflow: hidden;
            text-align: center;
            background: linear-gradient(135deg, #1e2a78 0%, #2444c9 55%, #3155e7 100%);
            border: none;
            color: #fff;
            padding: 34px 26px;
            margin-bottom: 20px;
        }
        .evl-hero::after {
            content: '';
            position: absolute;
            right: -50px;
            top: -50px;
            width: 190px;
            height: 190px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .evl-hero::before {
            content: '';
            position: absolute;
            left: -40px;
            bottom: -70px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .evl-hero > * { position: relative; z-index: 1; }
        .evl-grade {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 76px;
            height: 76px;
            border-radius: 24px;
            font-size: 34px;
            font-weight: 800;
            background: rgba(255,255,255,.16);
            border: 2px solid rgba(255,255,255,.35);
            margin-bottom: 14px;
        }
        .evl-grade-a { background: #22c55e; border-color: rgba(34,197,94,.6); }
        .evl-grade-b { background: #3b82f6; border-color: rgba(59,130,246,.6); }
        .evl-grade-c { background: #f59e0b; border-color: rgba(245,158,11,.6); }
        .evl-grade-d { background: #ef4444; border-color: rgba(239,68,68,.6); }
        .evl-final-score {
            font-size: 40px;
            font-weight: 800;
            line-height: 1.1;
            margin: 0;
            color: #fff;
        }
        .evl-final-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255,255,255,.82);
            margin: 6px 0 0;
        }

        /* ═══ SCORE GRID ═══ */
        .evl-score-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .evl-score {
            background: #f8fafc;
            border: 1px solid var(--evl-border);
            border-radius: 12px;
            padding: 16px;
        }
        .evl-score-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .evl-score-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--evl-primary-light);
            color: var(--evl-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }
        .evl-score-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--evl-text);
        }
        .evl-score-val {
            font-size: 26px;
            font-weight: 800;
            color: var(--evl-primary);
            line-height: 1;
            margin-bottom: 10px;
        }
        .evl-score-val span { font-size: 12px; font-weight: 600; color: var(--evl-muted); }
        .evl-prog {
            height: 8px;
            background: var(--evl-primary-light);
            border-radius: 99px;
            overflow: hidden;
        }
        .evl-prog-bar {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--evl-primary-dark), var(--evl-primary));
        }

        /* ═══ META ROWS ═══ */
        .evl-meta-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding-top: 16px;
            margin-top: 16px;
            border-top: 1px solid var(--evl-border);
            font-size: 13px;
        }
        .evl-meta-row > i {
            font-size: 16px;
            color: var(--evl-primary);
            margin-top: 1px;
        }
        .evl-meta-label {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--evl-muted);
            margin-bottom: 2px;
        }
        .evl-meta-value {
            color: var(--evl-text);
            font-weight: 600;
            line-height: 1.55;
            margin: 0;
        }

        /* ═══ INFO FOOTER ═══ */
        .evl-info {
            background: var(--evl-primary-light);
            border: 1px solid #dbe3fb;
            border-radius: 14px;
            padding: 18px 22px;
            text-align: center;
        }
        .evl-info p {
            margin: 0;
            font-size: 12px;
            color: var(--evl-muted);
            line-height: 1.6;
        }
        .evl-info p + p { margin-top: 6px; }
        .evl-info strong { color: var(--evl-primary); }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 560px) {
            .evl-card { padding: 20px 18px; }
            .evl-score-grid { grid-template-columns: 1fr; }
        }
    </style>

    {{-- ═══ HEADER ═══ --}}
    <div class="evl-header">
        <div class="breadcrumb">
            <a href="{{ route('intern.dashboard') }}">Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <span>Evaluasi</span>
        </div>
        <h2 class="evl-title">Hasil Evaluasi</h2>
        <p class="evl-sub">Hasil penilaian magang yang diisi oleh pembimbing Anda</p>
    </div>

    <div class="evl-wrap">
        @if(!$internship)
            <div class="evl-empty">
                <div class="evl-empty-icon"><i class="ti ti-star-off"></i></div>
                <h3 class="evl-empty-title">Belum Ada Penilaian</h3>
                <p class="evl-empty-sub">Penilaian akan muncul setelah magang selesai dan pembimbing mengisi evaluasi.</p>
            </div>
        @elseif(!$internship->evaluation)
            <div class="evl-empty">
                <div class="evl-empty-icon"><i class="ti ti-alert-circle"></i></div>
                <h3 class="evl-empty-title">Penilaian Belum Diisi</h3>
                <p class="evl-empty-sub">Pembimbing belum mengisi evaluasi untuk magang Anda. Silakan cek kembali nanti.</p>
            </div>
        @else
            @php $eva = $internship->evaluation; @endphp

            <div class="evl-card evl-hero">
                <div class="evl-grade evl-grade-{{ strtolower($eva->grade) }}">
                    {{ $eva->grade }}
                </div>
                <h3 class="evl-final-score">{{ number_format($eva->final_score, 0) }}</h3>
                <p class="evl-final-label">Nilai Akhir</p>
            </div>

            <div class="evl-card">
                <div class="evl-section-head">
                    <i class="ti ti-chart-bar"></i>
                    <span>Detail Penilaian</span>
                </div>

                <div class="evl-score-grid">
                    <div class="evl-score">
                        <div class="evl-score-head">
                            <div class="evl-score-icon"><i class="ti ti-brain"></i></div>
                            <span class="evl-score-name">Soft Skill</span>
                        </div>
                        <div class="evl-score-val">{{ number_format($eva->soft_skill_score, 0) }}<span> / 100</span></div>
                        <div class="evl-prog"><div class="evl-prog-bar" style="width:{{ $eva->soft_skill_score }}%"></div></div>
                    </div>
                    <div class="evl-score">
                        <div class="evl-score-head">
                            <div class="evl-score-icon"><i class="ti ti-code"></i></div>
                            <span class="evl-score-name">Hard Skill</span>
                        </div>
                        <div class="evl-score-val">{{ number_format($eva->hard_skill_score, 0) }}<span> / 100</span></div>
                        <div class="evl-prog"><div class="evl-prog-bar" style="width:{{ $eva->hard_skill_score }}%"></div></div>
                    </div>
                    <div class="evl-score">
                        <div class="evl-score-head">
                            <div class="evl-score-icon"><i class="ti ti-calendar-check"></i></div>
                            <span class="evl-score-name">Kehadiran</span>
                        </div>
                        <div class="evl-score-val">{{ number_format($eva->attendance_score, 0) }}<span> / 100</span></div>
                        <div class="evl-prog"><div class="evl-prog-bar" style="width:{{ $eva->attendance_score }}%"></div></div>
                    </div>
                    <div class="evl-score">
                        <div class="evl-score-head">
                            <div class="evl-score-icon"><i class="ti ti-mood-smile"></i></div>
                            <span class="evl-score-name">Sikap</span>
                        </div>
                        <div class="evl-score-val">{{ number_format($eva->attitude_score, 0) }}<span> / 100</span></div>
                        <div class="evl-prog"><div class="evl-prog-bar" style="width:{{ $eva->attitude_score }}%"></div></div>
                    </div>
                </div>

                <div class="evl-meta-row">
                    <i class="ti ti-user-check"></i>
                    <div>
                        <span class="evl-meta-label">Pembimbing</span>
                        <p class="evl-meta-value">{{ $internship->supervisor?->supervisorProfile?->full_name ?? $internship->supervisor?->email ?? '-' }}</p>
                    </div>
                </div>

                @if($eva->remarks)
                    <div class="evl-meta-row">
                        <i class="ti ti-note"></i>
                        <div>
                            <span class="evl-meta-label">Catatan</span>
                            <p class="evl-meta-value">{{ $eva->remarks }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="evl-info">
                <p>Nilai Akhir = (Soft Skill × <strong>25%</strong>) + (Hard Skill × <strong>35%</strong>) + (Kehadiran × <strong>20%</strong>) + (Sikap × <strong>20%</strong>)</p>
                <p>Grade: <strong>A ≥ 85</strong> · <strong>B ≥ 70</strong> · <strong>C ≥ 55</strong> · <strong>D &lt; 55</strong></p>
            </div>
        @endif
    </div>
</div>