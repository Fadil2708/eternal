<div class="crt-root">
    <style>
        .crt-root {
            --crt-primary: #3155e7;
            --crt-primary-dark: #2444c9;
            --crt-primary-light: #eef2ff;
            --crt-text: #111936;
            --crt-muted: #64708a;
            --crt-border: #e5e7eb;
        }

        /* ═══ HEADER ═══ */
        .crt-header { margin-bottom: 22px; }
        .crt-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--crt-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .crt-sub { font-size: 13px; color: var(--crt-muted); margin: 0; }

        /* ═══ WRAP ═══ */
        .crt-wrap { max-width: 640px; margin: 0 auto; }

        /* ═══ EMPTY STATE ═══ */
        .crt-empty {
            text-align: center;
            padding: 48px 24px;
            background: #fff;
            border: 1px solid var(--crt-border);
            border-radius: 14px;
        }
        .crt-empty-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            border-radius: 18px;
            background: var(--crt-primary-light);
            color: var(--crt-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        .crt-empty-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--crt-text);
            margin: 0 0 6px;
        }
        .crt-empty-sub {
            font-size: 13px;
            color: var(--crt-muted);
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ═══ CERTIFICATE CARD ═══ */
        .crt-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #1e2a78 0%, #2444c9 55%, #3155e7 100%);
            border-radius: 18px;
            padding: 36px 30px;
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }
        .crt-card::after {
            content: '';
            position: absolute;
            right: -60px;
            top: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .crt-card::before {
            content: '';
            position: absolute;
            left: -50px;
            bottom: -80px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .crt-card > * { position: relative; z-index: 1; }
        .crt-cert-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            border-radius: 22px;
            background: rgba(255,255,255,.16);
            border: 2px solid rgba(255,255,255,.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }
        .crt-cert-title {
            font-size: 20px;
            font-weight: 800;
            margin: 0 0 4px;
            color: #fff;
        }
        .crt-cert-number {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,.78);
            margin: 0 0 20px;
        }
        .crt-grade {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 62px;
            height: 62px;
            border-radius: 20px;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 20px;
        }
        .crt-grade-a { background: #22c55e; border: 2px solid rgba(34,197,94,.6); }
        .crt-grade-b { background: #3b82f6; border: 2px solid rgba(59,130,246,.6); }
        .crt-grade-c { background: #f59e0b; border: 2px solid rgba(245,158,11,.6); }
        .crt-grade-d { background: #ef4444; border: 2px solid rgba(239,68,68,.6); }
        .crt-recipient {
            max-width: 320px;
            margin: 0 auto 22px;
            padding: 14px 18px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 12px;
        }
        .crt-recipient-name {
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 2px;
            color: #fff;
        }
        .crt-recipient-org {
            font-size: 12px;
            color: rgba(255,255,255,.82);
            margin: 0;
        }
        .crt-meta {
            max-width: 280px;
            margin: 0 auto 26px;
            text-align: left;
        }
        .crt-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            padding: 7px 0;
            border-bottom: 1px solid rgba(255,255,255,.14);
        }
        .crt-meta-row:last-child { border-bottom: none; }
        .crt-meta-label { color: rgba(255,255,255,.72); }
        .crt-meta-value { font-weight: 700; color: #fff; }
        .crt-download {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            color: var(--crt-primary);
            font-weight: 800;
            font-size: 14px;
            padding: 12px 26px;
            border-radius: 12px;
            text-decoration: none;
            transition: transform .15s ease, box-shadow .15s ease;
            box-shadow: 0 6px 18px rgba(10, 20, 60, .25);
        }
        .crt-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(10, 20, 60, .3);
            color: var(--crt-primary-dark);
        }
        .crt-download i { font-size: 18px; }

        /* ═══ VERIFY FOOTER ═══ */
        .crt-verify {
            background: var(--crt-primary-light);
            border: 1px solid #dbe3fb;
            border-radius: 14px;
            padding: 16px 22px;
            text-align: center;
        }
        .crt-verify p {
            margin: 0;
            font-size: 12px;
            color: var(--crt-muted);
            line-height: 1.6;
        }
        .crt-verify a {
            color: var(--crt-primary);
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
        }
        .crt-verify a:hover { text-decoration: underline; }
    </style>

    {{-- ═══ HEADER ═══ --}}
    <div class="crt-header">
        <div class="breadcrumb">
            <a href="{{ route('intern.dashboard') }}">Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <span>Sertifikat</span>
        </div>
        <h2 class="crt-title">Sertifikat</h2>
        <p class="crt-sub">Sertifikat resmi setelah magang Anda selesai dan dinilai</p>
    </div>

    <div class="crt-wrap">
        @if(!$hasCompletedInternship)
            <div class="crt-empty">
                <div class="crt-empty-icon"><i class="ti ti-certificate"></i></div>
                <h3 class="crt-empty-title">Sertifikat</h3>
                <p class="crt-empty-sub">Anda belum memiliki magang yang selesai. Sertifikat akan tersedia setelah magang selesai dan dinilai.</p>
            </div>
        @elseif(!$certificate)
            <div class="crt-empty">
                <div class="crt-empty-icon"><i class="ti ti-clock"></i></div>
                <h3 class="crt-empty-title">Sertifikat Belum Diterbitkan</h3>
                <p class="crt-empty-sub">Magang Anda sudah selesai, namun sertifikat masih dalam proses penerbitan oleh admin.</p>
            </div>
        @else
            <div class="crt-card">
                <div class="crt-cert-icon"><i class="ti ti-certificate"></i></div>
                <h3 class="crt-cert-title">Sertifikat Tersedia</h3>
                <p class="crt-cert-number">{{ $certificate->certificate_number }}</p>

                <div class="crt-grade crt-grade-{{ strtolower($certificate->grade) }}">
                    {{ $certificate->grade }}
                </div>

                @php $recipient = $certificate->intern?->internProfile; @endphp
                @if($recipient && ($recipient->full_name || $recipient->institution_name))
                    <div class="crt-recipient">
                        <p class="crt-recipient-name">{{ $recipient->full_name ?? '-' }}</p>
                        <p class="crt-recipient-org">{{ $recipient->institution_name ?? '' }}</p>
                    </div>
                @endif

                <div class="crt-meta">
                    <div class="crt-meta-row">
                        <span class="crt-meta-label">Nilai Akhir</span>
                        <span class="crt-meta-value">{{ number_format($certificate->final_score, 0) }} / 100</span>
                    </div>
                    <div class="crt-meta-row">
                        <span class="crt-meta-label">Grade</span>
                        <span class="crt-meta-value">{{ $certificate->grade }}</span>
                    </div>
                    <div class="crt-meta-row">
                        <span class="crt-meta-label">Diterbitkan</span>
                        <span class="crt-meta-value">{{ $certificate->issued_at?->isoFormat('D MMMM Y') ?? '-' }}</span>
                    </div>
                </div>

                <a href="{{ route('intern.certificates.download', $certificate->id) }}" class="crt-download">
                    <i class="ti ti-download"></i> Download Sertifikat
                </a>
            </div>

            @if($certificate->qr_code_url)
                <div class="crt-verify">
                    <p>Sertifikat dapat diverifikasi keasliannya melalui tautan berikut.</p>
                    <a href="{{ $certificate->qr_code_url }}" target="_blank" rel="noopener">
                        <i class="ti ti-shield-check"></i> Verifikasi Sertifikat
                    </a>
                </div>
            @endif
        @endif
    </div>
</div>