<div class="fr-wrap">

    <style>
        /* ===== FINAL REPORT ===== */
        :root {
            --fr-primary: #3155e7;
            --fr-primary-dark: #2444c9;
            --fr-primary-light: #eef2ff;
            --fr-text: #111936;
            --fr-text-secondary: #64708a;
            --fr-border: #e5e7eb;
            --fr-radius: 14px;
            --fr-radius-sm: 10px;
            --fr-shadow-sm: 0 1px 3px rgba(15, 23, 42, .06);
            --fr-shadow-md: 0 4px 12px rgba(15, 23, 42, .08);
        }

        .fr-wrap {
            max-width: 720px;
            margin: 0 auto;
        }

        /* ===== HEADER ===== */
        .fr-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .fr-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--fr-text);
            margin: 0 0 4px;
        }

        .fr-header p {
            font-size: 13px;
            color: var(--fr-text-secondary);
            margin: 0;
        }

        .fr-header-date {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
            padding: 7px 12px;
            background: #fff;
            border: 1px solid var(--fr-border);
            border-radius: 99px;
            font-size: 12px;
            color: var(--fr-text-secondary);
            box-shadow: var(--fr-shadow-sm);
        }

        .fr-header-date i {
            color: var(--fr-primary);
            font-size: 14px;
        }

        /* ===== STATUS CARD ===== */
        .fr-status {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 22px;
            background: #fff;
            border: 1px solid var(--fr-border);
            border-left: 4px solid var(--fr-border);
            border-radius: var(--fr-radius);
            box-shadow: var(--fr-shadow-sm);
            margin-bottom: 16px;
        }

        .fr-status-ok   { border-left-color: #34c17b; }
        .fr-status-wait { border-left-color: #f59e0b; }
        .fr-status-error{ border-left-color: #ef4444; }

        .fr-status-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .fr-status-ok .fr-status-icon    { background: #e9faf2; color: #0f8a52; }
        .fr-status-wait .fr-status-icon  { background: #fffbeb; color: #b45309; }
        .fr-status-error .fr-status-icon { background: #fef2f2; color: #dc2626; }

        .fr-status-body {
            flex: 1;
            min-width: 0;
        }

        .fr-status-body h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--fr-text);
            margin: 0 0 4px;
        }

        .fr-status-body p {
            font-size: 13px;
            color: var(--fr-text-secondary);
            margin: 0 0 8px;
            line-height: 1.5;
        }

        .fr-status-meta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #98a2b3;
        }

        .fr-status-meta i {
            font-size: 12px;
        }

        .fr-btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
            padding: 9px 16px;
            border-radius: var(--fr-radius-sm);
            background: var(--fr-primary-light);
            color: var(--fr-primary);
            font-family: inherit;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all .15s ease;
        }

        .fr-btn-outline:hover {
            background: #e0e7ff;
        }

        .fr-btn-outline i {
            font-size: 14px;
        }

        /* ===== CARD ===== */
        .fr-card {
            background: #fff;
            border: 1px solid var(--fr-border);
            border-radius: var(--fr-radius);
            box-shadow: var(--fr-shadow-sm);
            overflow: hidden;
        }

        .fr-card-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 18px 22px;
            border-bottom: 1px solid var(--fr-border);
        }

        .fr-card-head i {
            font-size: 20px;
            color: var(--fr-primary);
        }

        .fr-card-head h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--fr-text);
            margin: 0;
        }

        .fr-card-body {
            padding: 22px;
        }

        /* ===== FORM ===== */
        .fr-field {
            margin-bottom: 18px;
        }

        .fr-field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #98a2b3;
            margin-bottom: 7px;
        }

        .fr-req {
            color: #dc2626;
        }

        .fr-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--fr-border);
            border-radius: var(--fr-radius-sm);
            font-family: inherit;
            font-size: 13px;
            color: var(--fr-text);
            background: #fff;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .fr-input:focus {
            border-color: #c7d2fe;
            box-shadow: 0 0 0 3px rgba(49, 85, 231, .12);
        }

        .fr-input::placeholder {
            color: #a8a5a0;
        }

        .fr-drop {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 32px 20px;
            border: 1.5px dashed #c7d2fe;
            border-radius: var(--fr-radius-sm);
            background: var(--fr-primary-light);
            cursor: pointer;
            text-align: center;
            transition: border-color .15s ease, background .15s ease;
        }

        .fr-drop:hover {
            border-color: var(--fr-primary);
            background: #e4eafe;
        }

        .fr-drop input {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .fr-drop i {
            font-size: 30px;
            color: var(--fr-primary);
            margin-bottom: 4px;
        }

        .fr-drop-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--fr-text);
        }

        .fr-drop-sub {
            font-size: 11px;
            color: var(--fr-text-secondary);
        }

        .fr-err {
            font-size: 11px;
            color: #dc2626;
            margin-top: 5px;
        }

        /* ===== ACTIONS ===== */
        .fr-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
        }

        .fr-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 11px 22px;
            border-radius: var(--fr-radius-sm);
            background: var(--fr-primary);
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all .2s ease;
        }

        .fr-btn-primary:hover {
            background: var(--fr-primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--fr-shadow-md);
        }

        .fr-loading {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .fr-btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: var(--fr-radius-sm);
            background: #fff;
            color: var(--fr-text-secondary);
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--fr-border);
            transition: all .15s ease;
        }

        .fr-btn-ghost:hover {
            background: #f1f3f9;
        }

        /* ===== EMPTY STATE ===== */
        .fr-empty {
            text-align: center;
            padding: 56px 24px;
            background: #fff;
            border: 1px solid var(--fr-border);
            border-radius: var(--fr-radius);
            box-shadow: var(--fr-shadow-sm);
        }

        .fr-empty-sub {
            font-size: 13px;
            color: var(--fr-text-secondary);
            margin: 12px 0 20px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .fr-header { flex-direction: column; }
            .fr-header-date { align-self: flex-start; }
            .fr-status { flex-direction: column; }
            .fr-actions { flex-direction: column; align-items: stretch; }
        }
    </style>

    {{-- HEADER --}}
    <div class="fr-header">
        <div>
            <h2>Laporan Akhir</h2>
            <p>Unggah laporan hasil magang kamu untuk direview pembimbing.</p>
        </div>
        <span class="fr-header-date">
            <i class="ti ti-calendar"></i>
            {{ now()->translatedFormat('l, d M Y') }}
        </span>
    </div>

    @if(!$hasActiveInternship)
        <div class="fr-empty">
            <x-empty-state icon="ti-file-description" message="Anda belum memiliki magang aktif." />
            <p class="fr-empty-sub">Laporan akhir hanya bisa diunggah saat magang berlangsung.</p>
            <a href="{{ route('intern.vacancies') }}" wire:navigate class="fr-btn-primary">
                <i class="ti ti-briefcase"></i> Cari Lowongan
            </a>
        </div>
    @else

        {{-- STATUS: APPROVED --}}
        @if($existingReport && $existingReport->supervisor_approval === 'approved')
            <div class="fr-status fr-status-ok">
                <div class="fr-status-icon"><i class="ti ti-circle-check"></i></div>
                <div class="fr-status-body">
                    <h3>Laporan Akhir Disetujui</h3>
                    <p>{{ $existingReport->title }}</p>
                    <span class="fr-status-meta">
                        <i class="ti ti-calendar-check"></i>
                        Disetujui {{ $existingReport->approved_at?->isoFormat('D MMMM Y') ?? '—' }}
                    </span>
                </div>
                @if($existingReport->file_url)
                    <a href="{{ route('private.serve', ['path' => $existingReport->file_url]) }}" target="_blank" class="fr-btn-outline">
                        <i class="ti ti-download"></i> Lihat File
                    </a>
                @endif
            </div>

        {{-- STATUS: PENDING --}}
        @elseif($existingReport && $existingReport->supervisor_approval === 'pending')
            <div class="fr-status fr-status-wait">
                <div class="fr-status-icon"><i class="ti ti-clock"></i></div>
                <div class="fr-status-body">
                    <h3>Laporan Sedang Direview</h3>
                    <p>{{ $existingReport->title }} — menunggu persetujuan pembimbing.</p>
                    <span class="fr-status-meta">
                        <i class="ti ti-calendar-event"></i>
                        Dikirim {{ $existingReport->submitted_at?->isoFormat('D MMMM Y') ?? '—' }}
                    </span>
                </div>
                @if($existingReport->file_url)
                    <a href="{{ route('private.serve', ['path' => $existingReport->file_url]) }}" target="_blank" class="fr-btn-outline">
                        <i class="ti ti-download"></i> Lihat File
                    </a>
                @endif
            </div>

        {{-- STATUS: REJECTED --}}
        @elseif($existingReport && $existingReport->supervisor_approval === 'rejected')
            <div class="fr-status fr-status-error">
                <div class="fr-status-icon"><i class="ti ti-alert-circle"></i></div>
                <div class="fr-status-body">
                    <h3>Laporan Perlu Direvisi</h3>
                    <p>Silakan perbaiki dan unggah ulang laporan kamu.</p>
                    <span class="fr-status-meta">
                        <i class="ti ti-file"></i>
                        {{ $existingReport->title }}
                    </span>
                </div>
            </div>
        @endif

        {{-- UPLOAD FORM (hanya saat bisa upload) --}}
        @if($canUpload)
            <div class="fr-card">
                <div class="fr-card-head">
                    <i class="ti ti-upload"></i>
                    <h3>{{ $existingReport ? 'Unggah Ulang Laporan' : 'Unggah Laporan Akhir' }}</h3>
                </div>
                <div class="fr-card-body">
                    <form wire:submit="upload">
                        <div class="fr-field">
                            <label>Judul Laporan <span class="fr-req">*</span></label>
                            <input wire:model="title" type="text" class="fr-input" placeholder="Contoh: Laporan Praktik Kerja Lapangan di Eternal Internship">
                            @error('title') <div class="fr-err">{{ $message }}</div> @enderror
                        </div>
                        <div class="fr-field">
                            <label>File Laporan <span class="fr-req">*</span></label>
                            <label class="fr-drop">
                                <input wire:model="file" type="file" accept=".pdf,.doc,.docx">
                                <i class="ti ti-file-upload"></i>
                                <span class="fr-drop-title">Klik untuk pilih file</span>
                                <span class="fr-drop-sub">Format PDF / DOC / DOCX, maksimal 20MB</span>
                            </label>
                            @error('file') <div class="fr-err">{{ $message }}</div> @enderror
                        </div>

                        <div class="fr-actions">
                            <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait" class="fr-btn-primary">
                                <i wire:loading.remove class="ti ti-upload"></i>
                                <span wire:loading.remove>{{ $existingReport ? 'Upload Ulang' : 'Upload Laporan' }}</span>
                                <span wire:loading class="fr-loading">
                                    <i class="ti ti-loader animate-spin"></i>
                                    Mengupload...
                                </span>
                            </button>
                            <a href="{{ route('intern.dashboard') }}" wire:navigate class="fr-btn-ghost">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    @endif

</div>