<div class="evf-root">

    <style>
        .evf-root {
            --evf-primary: #3155e7;
            --evf-primary-dark: #2444c9;
            --evf-primary-light: #eef2ff;
            --evf-text: #111936;
            --evf-muted: #64708a;
            --evf-border: #e5e7eb;
            --evf-amber: #b45309;
            --evf-amber-bg: #fffbeb;
            --evf-green: #16a34a;
            --evf-green-bg: #ecfdf5;
            --evf-red: #dc2626;
            --evf-red-bg: #fef2f2;
        }

        /* ═══ HEADER ═══ */
        .evf-header {
            margin-bottom: 20px;
        }
        .evf-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            margin-bottom: 6px;
        }
        .evf-breadcrumb a {
            color: var(--evf-primary);
            text-decoration: none;
            font-weight: 600;
        }
        .evf-breadcrumb a:hover { text-decoration: underline; }
        .evf-breadcrumb i { font-size: 14px; color: var(--evf-muted); }
        .evf-breadcrumb span { color: var(--evf-muted); }
        .evf-title {
            margin: 0 0 4px;
            font-size: 22px;
            font-weight: 700;
            color: var(--evf-text);
        }
        .evf-subtitle {
            margin: 0;
            font-size: 13px;
            color: var(--evf-muted);
        }

        /* ═══ DAFTAR PILIH PESERTA ═══ */
        .evf-list {
            background: #fff;
            border: 1px solid var(--evf-border);
            border-radius: 14px;
            padding: 20px;
        }
        .evf-list-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .evf-list-head h2 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: var(--evf-text);
        }
        .evf-list-count {
            font-size: 12px;
            font-weight: 600;
            color: var(--evf-primary);
            background: var(--evf-primary-light);
            padding: 4px 10px;
            border-radius: 999px;
        }
        .evf-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border: 1px solid var(--evf-border);
            border-radius: 12px;
            text-decoration: none;
            margin-bottom: 10px;
            transition: border-color .15s, box-shadow .15s;
        }
        .evf-item:last-child { margin-bottom: 0; }
        .evf-item:hover {
            border-color: var(--evf-primary);
            box-shadow: 0 2px 8px rgba(49, 85, 231, .10);
        }
        .evf-item-info { flex: 1; min-width: 0; }
        .evf-item-name {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: var(--evf-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .evf-item-meta {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--evf-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .evf-item-side {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .evf-item-grade {
            font-size: 12px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
        }
        .evf-item-grade.grade-A { background: var(--evf-green-bg); color: #065f46; }
        .evf-item-grade.grade-B { background: #f9eae8; color: #992b24; }
        .evf-item-grade.grade-C { background: var(--evf-amber-bg); color: #92400e; }
        .evf-item-grade.grade-D { background: var(--evf-red-bg); color: #991b1b; }
        .evf-item-score { font-size: 13px; font-weight: 700; color: var(--evf-text); }
        .evf-item-unrated {
            font-size: 12px;
            font-weight: 600;
            color: var(--evf-muted);
            background: #f3f4f6;
            padding: 4px 10px;
            border-radius: 999px;
        }
        .evf-item-arrow { color: #d1d5db; font-size: 18px; }

        /* ═══ EMPTY & LOCKED ═══ */
        .evf-panel {
            background: #fff;
            border: 1px solid var(--evf-border);
            border-radius: 14px;
        }
        .evf-empty,
        .evf-locked {
            text-align: center;
            padding: 48px 24px;
        }
        .evf-empty-icon,
        .evf-locked-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: var(--evf-primary-light);
            color: var(--evf-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }
        .evf-locked-icon { background: var(--evf-amber-bg); color: var(--evf-amber); }
        .evf-empty p,
        .evf-locked p {
            margin: 0 0 16px;
            font-size: 13px;
            color: var(--evf-muted);
        }
        .evf-empty h3,
        .evf-locked h3 {
            margin: 0 0 6px;
            font-size: 16px;
            font-weight: 700;
            color: var(--evf-text);
        }
        .evf-btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--evf-primary);
            background: #fff;
            border: 1px solid var(--evf-primary);
            border-radius: 8px;
            padding: 8px 16px;
            text-decoration: none;
            transition: background .15s;
        }
        .evf-btn-ghost:hover { background: var(--evf-primary-light); }

        /* ═══ FORM ═══ */
        .evf-card {
            background: #fff;
            border: 1px solid var(--evf-border);
            border-radius: 14px;
            padding: 20px;
        }
        .evf-student {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 16px;
            margin-bottom: 18px;
            border-bottom: 1px solid var(--evf-border);
        }
        .evf-student-name {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: var(--evf-text);
        }
        .evf-student-meta {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--evf-muted);
        }
        .evf-student-gender { margin-top: 2px; font-size: 12px; color: var(--evf-muted); }
        .evf-skills { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
        .evf-skill {
            font-size: 11px;
            font-weight: 600;
            color: var(--evf-primary);
            background: var(--evf-primary-light);
            padding: 3px 9px;
            border-radius: 999px;
        }
        .evf-form-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        /* ── kriteria ── */
        .evf-score {
            padding: 14px;
            border: 1px solid var(--evf-border);
            border-radius: 12px;
            margin-bottom: 12px;
        }
        .evf-score-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }
        .evf-score-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--evf-text);
        }
        .evf-score-desc {
            font-size: 12px;
            color: var(--evf-muted);
            margin-top: 2px;
        }
        .evf-score-weight {
            flex-shrink: 0;
            font-size: 11px;
            font-weight: 700;
            color: var(--evf-primary);
            background: var(--evf-primary-light);
            padding: 4px 10px;
            border-radius: 999px;
            white-space: nowrap;
        }
        .evf-score-inputs {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .evf-score-inputs input[type="range"] {
            flex: 1;
            accent-color: var(--evf-primary);
            height: 6px;
        }
        .evf-score-inputs input[type="number"] {
            width: 84px;
            border: 1px solid var(--evf-border);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--evf-text);
            text-align: center;
            outline: none;
        }
        .evf-score-inputs input[type="number"]:focus {
            border-color: var(--evf-primary);
            box-shadow: 0 0 0 3px rgba(49, 85, 231, .12);
        }
        .evf-score-bar {
            height: 6px;
            background: #eef1f5;
            border-radius: 999px;
            margin-top: 12px;
            overflow: hidden;
        }
        .evf-score-bar-fill {
            height: 100%;
            border-radius: 999px;
            transition: width .2s;
        }
        .evf-score-error {
            margin-top: 8px;
            font-size: 12px;
            color: var(--evf-red);
        }
        .evf-field { margin-top: 4px; }
        .evf-field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--evf-text);
            margin-bottom: 6px;
        }
        .evf-field textarea {
            width: 100%;
            border: 1px solid var(--evf-border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            font-family: inherit;
            color: var(--evf-text);
            resize: vertical;
            outline: none;
        }
        .evf-field textarea:focus {
            border-color: var(--evf-primary);
            box-shadow: 0 0 0 3px rgba(49, 85, 231, .12);
        }
        .evf-field-error {
            margin-top: 6px;
            font-size: 12px;
            color: var(--evf-red);
        }

        /* ── pratinjau ── */
        .evf-preview-card {
            position: sticky;
            top: 16px;
            border: 1px solid var(--evf-border);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .evf-preview-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--evf-text);
            padding: 12px 16px;
            border-bottom: 1px solid var(--evf-border);
        }
        .evf-preview-body { padding: 16px; text-align: center; }
        .evf-preview-grade {
            display: inline-block;
            font-size: 28px;
            font-weight: 700;
            padding: 4px 16px;
            border-radius: 10px;
        }
        .evf-preview-num {
            font-size: 34px;
            font-weight: 700;
            color: var(--evf-text);
            margin-top: 10px;
            line-height: 1.1;
        }
        .evf-preview-label {
            font-size: 12px;
            color: var(--evf-muted);
            margin-bottom: 14px;
        }
        .evf-preview-rows {
            border-top: 1px dashed var(--evf-border);
            padding-top: 12px;
            text-align: left;
        }
        .evf-preview-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 12px;
            color: var(--evf-muted);
            padding: 4px 0;
        }
        .evf-preview-total {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            color: var(--evf-text);
            border-top: 1px solid var(--evf-border);
            margin-top: 6px;
            padding-top: 10px;
        }

        /* ── aksi ── */
        .evf-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 20px;
        }
        .evf-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--evf-primary), var(--evf-primary-dark));
            border-radius: 8px;
            padding: 10px 18px;
            transition: opacity .15s;
        }
        .evf-btn-primary:hover { opacity: .92; }
        .evf-btn-loading { opacity: .6; cursor: wait; }
        .evf-btn-spin {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* ═══ MODAL KONFIRMASI ═══ */
        .evf-confirm-summary {
            background: #f8fafc;
            border: 1px solid var(--evf-border);
            border-radius: 10px;
            padding: 14px;
        }
        .evf-confirm-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 0;
        }
        .evf-confirm-label {
            width: 92px;
            flex-shrink: 0;
            font-size: 12px;
            font-weight: 600;
            color: var(--evf-text);
        }
        .evf-confirm-bar {
            flex: 1;
            height: 8px;
            background: #eef1f5;
            border-radius: 999px;
            overflow: hidden;
        }
        .evf-confirm-bar-fill {
            height: 100%;
            border-radius: 999px;
        }
        .evf-confirm-score {
            width: 28px;
            text-align: right;
            font-size: 12px;
            font-weight: 700;
            color: var(--evf-text);
        }
        .evf-confirm-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--evf-border);
            margin-top: 10px;
            padding-top: 12px;
        }
        .evf-confirm-footer-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--evf-text);
        }
        .evf-confirm-footer-value {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .evf-confirm-footer-grade {
            font-size: 14px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 6px;
        }
        .evf-confirm-footer-total {
            font-size: 18px;
            font-weight: 700;
            color: var(--evf-text);
        }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 900px) {
            .evf-form-grid {
                grid-template-columns: 1fr;
            }
            .evf-preview-card {
                position: static;
            }
        }
    </style>

    <div class="evf-header">
        <nav class="evf-breadcrumb">
            <a href="{{ route('supervisor.dashboard') }}" wire:navigate>Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <span>Evaluasi</span>
        </nav>
        <h1 class="evf-title">Evaluasi Peserta</h1>
        <p class="evf-subtitle">Beri penilaian akhir untuk peserta magang yang telah menyelesaikan masa magang.</p>
    </div>

    @if(!$internshipId)
        <div class="evf-list">
            <div class="evf-list-head">
                <h2>Pilih Peserta yang Akan Dinilai</h2>
                <span class="evf-list-count">{{ $completedInternships->count() }} magang selesai</span>
            </div>
            @forelse($completedInternships as $item)
            <a href="{{ route('supervisor.evaluations.show', $item->id) }}" wire:navigate class="evf-item">
                <x-avatar :name="$item->intern?->internProfile?->full_name ?? $item->intern?->email ?? ''" :size="36" />
                <div class="evf-item-info">
                    <p class="evf-item-name">{{ $item->intern?->internProfile?->full_name ?? $item->intern?->email }}</p>
                    <p class="evf-item-meta">{{ $item->vacancy?->title }}</p>
                </div>
                <div class="evf-item-side">
                    @if($item->evaluation)
                        <span class="evf-item-grade grade-{{ $item->evaluation->grade }}">{{ $item->evaluation->grade }}</span>
                        <span class="evf-item-score">{{ number_format($item->evaluation->final_score, 0) }}</span>
                    @else
                        <span class="evf-item-unrated">Belum dinilai</span>
                    @endif
                </div>
                <i class="ti ti-chevron-right evf-item-arrow"></i>
            </a>
            @empty
            <div class="evf-empty">
                <div class="evf-empty-icon"><i class="ti ti-star"></i></div>
                <p>Belum ada magang selesai yang perlu dinilai.</p>
            </div>
            @endforelse
        </div>
    @elseif(!$internship)
        <div class="evf-panel">
            <div class="evf-empty">
                <div class="evf-empty-icon"><i class="ti ti-alert-circle"></i></div>
                <p>Data tidak ditemukan atau Anda tidak berhak mengaksesnya.</p>
                <a href="{{ route('supervisor.evaluations.create', '') }}" wire:navigate class="evf-btn-ghost">Kembali ke daftar</a>
            </div>
        </div>
    @elseif($isLocked)
        <div class="evf-panel">
            <div class="evf-locked">
                <div class="evf-locked-icon"><i class="ti ti-lock"></i></div>
                <h3>Penilaian Terkunci</h3>
                <p>Penilaian tidak bisa diubah karena sertifikat sudah diterbitkan.</p>
                <a href="{{ route('supervisor.evaluations.create', '') }}" wire:navigate class="evf-btn-ghost">Kembali ke daftar</a>
            </div>
        </div>
    @else
        @php
            $s = floatval($soft_skill_score ?? 0);
            $h = floatval($hard_skill_score ?? 0);
            $att = floatval($attendance_score ?? 0);
            $ati = floatval($attitude_score ?? 0);
            $final = ($s * 0.25) + ($h * 0.35) + ($att * 0.20) + ($ati * 0.20);
            $hasAny = $s > 0 || $h > 0 || $att > 0 || $ati > 0;
            if ($final >= 85) { $grade = 'A'; } elseif ($final >= 70) { $grade = 'B'; } elseif ($final >= 55) { $grade = 'C'; } else { $grade = 'D'; }
            $fields = [
                ['key' => 'soft_skill_score', 'label' => 'Soft Skill', 'desc' => 'Komunikasi, kerjasama, inisiatif', 'weight' => '25%', 'val' => $s],
                ['key' => 'hard_skill_score', 'label' => 'Hard Skill', 'desc' => 'Kompetensi teknis sesuai bidang', 'weight' => '35%', 'val' => $h],
                ['key' => 'attendance_score', 'label' => 'Kehadiran', 'desc' => 'Tingkat kehadiran dan ketepatan waktu', 'weight' => '20%', 'val' => $att],
                ['key' => 'attitude_score', 'label' => 'Sikap', 'desc' => 'Etika, kedisiplinan, tanggung jawab', 'weight' => '20%', 'val' => $ati],
            ];
        @endphp

        <div class="evf-card">
            <div class="evf-student">
                <x-avatar :name="$internship->intern?->internProfile?->full_name ?? $internship->intern?->email ?? ''" :size="40" />
                <div style="flex:1;min-width:0">
                    <p class="evf-student-name">{{ $internship->intern?->internProfile?->full_name ?? $internship->intern?->email }}</p>
                    <p class="evf-student-meta">{{ $internship->vacancy?->title }}</p>
                    @php $evG = $internship->intern?->internProfile?->gender ?? null; @endphp
                    @if($evG)
                        <p class="evf-student-gender">{{ $evG === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                    @endif
                    @php $evSkills = $internship->intern?->internProfile?->skills ?? collect(); @endphp
                    @if($evSkills->isNotEmpty())
                        <div class="evf-skills">
                            @foreach($evSkills as $evS)
                                <span class="evf-skill">{{ $evS->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <form wire:submit="confirmSave">
                <div class="evf-form-grid">
                    <div class="evf-form-main">
                        @foreach($fields as $f)
                        <div class="evf-score">
                            <div class="evf-score-head">
                                <div>
                                    <div class="evf-score-label">{{ $f['label'] }}</div>
                                    <div class="evf-score-desc">{{ $f['desc'] }}</div>
                                </div>
                                <span class="evf-score-weight">Bobot {{ $f['weight'] }}</span>
                            </div>
                            <div class="evf-score-inputs">
                                <input type="range" min="0" max="100" step="1"
                                       wire:model.live="{{ $f['key'] }}">
                                <input type="number" min="0" max="100"
                                       wire:model.live="{{ $f['key'] }}">
                            </div>
                            <div class="evf-score-bar">
                                <div class="evf-score-bar-fill" style="width: {{ $f['val'] }}%;background:{{ $f['val'] >= 80 ? '#10B981' : ($f['val'] >= 60 ? '#F59E0B' : '#DC2626') }}"></div>
                            </div>
                            @error($f['key']) <div class="evf-score-error">{{ $message }}</div> @enderror
                        </div>
                        @endforeach

                        <div class="evf-field">
                            <label>Catatan</label>
                            <textarea wire:model="remarks" rows="3"></textarea>
                            @error('remarks') <div class="evf-field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="evf-preview" style="{{ !$hasAny ? 'opacity:.55;pointer-events:none' : '' }}">
                        <div class="evf-preview-card">
                            <div class="evf-preview-title">Pratinjau Nilai</div>
                            <div class="evf-preview-body">
                                <div class="evf-preview-grade grade-{{ $hasAny ? $grade : 'C' }}">{{ $hasAny ? $grade : 'C' }}</div>
                                <div class="evf-preview-num">{{ $hasAny ? number_format($final, 0) : '0' }}</div>
                                <div class="evf-preview-label">Nilai Akhir</div>
                                <div class="evf-preview-rows">
                                    @foreach($fields as $f)
                                    <div class="evf-preview-row">
                                        <span>{{ $f['label'] }}</span>
                                        <span>{{ number_format($f['val'], 0) }} x {{ $f['weight'] }}</span>
                                    </div>
                                    @endforeach
                                    <div class="evf-preview-total">
                                        <span>Total</span>
                                        <span>{{ number_format($final, 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="evf-actions">
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="evf-btn-loading" class="evf-btn-primary">
                        <i wire:loading.remove class="ti ti-device-floppy"></i>
                        <span wire:loading.remove>{{ $evaluation ? 'Simpan Perubahan' : 'Simpan Penilaian' }}</span>
                        <span wire:loading class="evf-btn-spin">
                            <i class="ti ti-loader animate-spin"></i>
                            Menyimpan...
                        </span>
                    </button>
                    <a href="{{ route('supervisor.evaluations.create', '') }}" wire:navigate class="evf-btn-ghost">Kembali ke daftar</a>
                </div>
            </form>
        </div>

        @if($confirmingSave)
        <div class="modal-wrap" aria-labelledby="confirm-save-title" role="dialog" aria-modal="true"
             x-data
             @keydown.escape.window="$wire.set('confirmingSave', false)">
            <div class="modal-backdrop" @click="$wire.set('confirmingSave', false)"></div>
            <div class="modal-center">
                <div class="modal-card modal-card-md">
                    <div class="modal-header">
                        <h3 id="confirm-save-title" class="modal-title">Konfirmasi Penilaian</h3>
                    </div>
                    <div class="modal-body">
                        <p class="text-body-sm" style="margin-bottom:16px">Yakin ingin menyimpan penilaian berikut?</p>
                        <div class="evf-confirm-summary">
                            @foreach($fields as $f)
                            <div class="evf-confirm-row">
                                <div class="evf-confirm-label">{{ $f['label'] }}</div>
                                <div class="evf-confirm-bar">
                                    <div class="evf-confirm-bar-fill" style="width:{{ $f['val'] }}%;background:{{ $f['val'] >= 80 ? '#10B981' : ($f['val'] >= 60 ? '#F59E0B' : '#DC2626') }}"></div>
                                </div>
                                <div class="evf-confirm-score">{{ number_format($f['val'], 0) }}</div>
                            </div>
                            @endforeach
                            <div class="evf-confirm-footer">
                                <span class="evf-confirm-footer-label">Nilai Akhir</span>
                                <div class="evf-confirm-footer-value">
                                    <div class="evf-confirm-footer-grade grade-{{ $grade }}">{{ $grade }}</div>
                                    <span class="evf-confirm-footer-total">{{ number_format($final, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="$set('confirmingSave', false)" class="btn-secondary">Batal</button>
                        <button wire:click="save"
                                wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                                class="btn-save">
                            <span wire:loading.remove>Ya, Simpan</span>
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
    @endif
</div>
