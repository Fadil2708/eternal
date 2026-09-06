<div class="lbf-root">
    <style>
        .lbf-root {
            --lbf-primary: #3155e7;
            --lbf-primary-dark: #2444c9;
            --lbf-primary-light: #eef2ff;
            --lbf-text: #111936;
            --lbf-muted: #64708a;
            --lbf-border: #e5e7eb;
            --lbf-danger: #dc2626;
            --lbf-amber-bg: #fffbeb;
            --lbf-amber-border: #fde68a;
            --lbf-amber-text: #92400e;
        }

        /* ═══ HEADER ═══ */
        .lbf-header { margin-bottom: 22px; }
        .lbf-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--lbf-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .lbf-sub { font-size: 13px; color: var(--lbf-muted); margin: 0; }

        /* ═══ WRAP ═══ */
        .lbf-wrap { max-width: 720px; margin: 0 auto; }
        .lbf-card {
            background: #fff;
            border: 1px solid var(--lbf-border);
            border-radius: 14px;
            padding: 24px 26px;
        }
        .lbf-section-head {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 11px;
            font-weight: 800;
            color: var(--lbf-primary);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 20px;
        }
        .lbf-section-head i { font-size: 15px; }

        /* ═══ FIELDS ═══ */
        .lbf-field { margin-bottom: 20px; }
        .lbf-field label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            font-weight: 700;
            color: var(--lbf-text);
            margin-bottom: 7px;
        }
        .lbf-field label .lbf-req { color: var(--lbf-danger); }
        .lbf-input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d4d9e3;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: var(--lbf-text);
            background: #fff;
            line-height: 1.55;
            transition: border-color .15s, box-shadow .15s;
            resize: vertical;
        }
        .lbf-input:focus {
            outline: none;
            border-color: var(--lbf-primary);
            box-shadow: 0 0 0 3px rgba(49,85,231,.15);
        }
        .lbf-input::placeholder { color: #a8b0c1; }
        .lbf-input-wrap { position: relative; }
        .lbf-input-wrap > i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: var(--lbf-primary);
            pointer-events: none;
        }
        .lbf-input-wrap .lbf-date { padding-left: 40px; }
        .lbf-error { font-size: 12px; color: var(--lbf-danger); font-weight: 600; margin-top: 6px; }

        /* ═══ COUNTER ═══ */
        .lbf-counter {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: var(--lbf-muted);
            margin-top: 6px;
        }
        .lbf-counter b { font-weight: 700; }
        .lbf-counter-ok { color: #16a34a; }
        .lbf-counter-warn { color: #d97706; }

        /* ═══ BANNER REVISI ═══ */
        .lbf-banner {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }
        .lbf-banner > i { font-size: 22px; flex-shrink: 0; }
        .lbf-banner-warn {
            background: var(--lbf-amber-bg);
            border: 1px solid var(--lbf-amber-border);
        }
        .lbf-banner-warn > i { color: #d97706; }
        .lbf-banner strong {
            display: block;
            font-size: 13px;
            color: var(--lbf-amber-text);
            margin-bottom: 2px;
        }
        .lbf-banner span { font-size: 12px; color: var(--lbf-amber-text); opacity: .9; }

        /* ═══ ATTENDANCE TYPE RADIO ═══ */
        .lbf-attendance {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .lbf-attendance-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 20px 14px;
            border: 2px solid #d4d9e3;
            border-radius: 14px;
            background: #fff;
            cursor: pointer;
            transition: all .2s;
            text-align: center;
        }
        .lbf-attendance-card:hover {
            border-color: #a5b4fc;
            background: #fafbff;
        }
        .lbf-attendance-card.active {
            border-color: var(--lbf-primary);
            background: var(--lbf-primary-light);
            box-shadow: 0 0 0 3px rgba(49, 85, 231, .12);
        }
        .lbf-attendance-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
        .lbf-attendance-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            background: #f1f5f9;
            color: var(--lbf-muted);
            transition: all .2s;
        }
        .lbf-attendance-card.active .lbf-attendance-icon {
            background: var(--lbf-primary);
            color: #fff;
        }
        .lbf-attendance-card[data-type="sakit"].active .lbf-attendance-icon {
            background: #f59e0b;
        }
        .lbf-attendance-card[data-type="izin"].active .lbf-attendance-icon {
            background: #6366f1;
        }
        .lbf-attendance-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--lbf-text);
        }
        .lbf-attendance-desc {
            font-size: 11px;
            color: var(--lbf-muted);
            line-height: 1.4;
        }
        .lbf-attendance-card.active .lbf-attendance-desc {
            color: #475569;
        }
        @media (max-width: 560px) {
            .lbf-attendance { grid-template-columns: 1fr; }
            .lbf-attendance-card { flex-direction: row; text-align: left; padding: 14px 16px; gap: 12px; }
        }

        /* ═══ BUTTONS ═══ */
        .lbf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            border: none;
            transition: all .15s;
            text-decoration: none;
        }
        .lbf-btn i { font-size: 15px; }
        .lbf-btn-primary {
            color: #fff;
            background: linear-gradient(90deg, var(--lbf-primary-dark), var(--lbf-primary));
            box-shadow: 0 6px 18px rgba(49,85,231,.3);
        }
        .lbf-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(49,85,231,.4); }
        .lbf-btn-secondary {
            color: var(--lbf-primary);
            background: var(--lbf-primary-light);
        }
        .lbf-btn-secondary:hover { background: #e2e8ff; }
        .lbf-btn-ghost {
            color: var(--lbf-muted);
            background: #fff;
            border: 1px solid var(--lbf-border);
            padding: 12px 18px;
        }
        .lbf-btn-ghost:hover { color: var(--lbf-text); border-color: #c7cedd; }
        .lbf-btn:disabled { opacity: .65; cursor: not-allowed; transform: none; }
        .lbf-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 18px;
            margin-top: 4px;
            border-top: 1px solid var(--lbf-border);
        }
        .lbf-spin { animation: lbf-spin 1s linear infinite; }
        @keyframes lbf-spin { 100% { transform: rotate(360deg); } }

        /* ═══ EMPTY STATE ═══ */
        .lbf-empty {
            text-align: center;
            padding: 48px 24px;
            background: #fff;
            border: 1px solid var(--lbf-border);
            border-radius: 14px;
        }
        .lbf-empty-icon {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            border-radius: 18px;
            background: var(--lbf-primary-light);
            color: var(--lbf-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }
        .lbf-empty-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--lbf-text);
            margin: 0 0 6px;
        }
        .lbf-empty-sub {
            font-size: 13px;
            color: var(--lbf-muted);
            max-width: 380px;
            margin: 0 auto 20px;
            line-height: 1.6;
        }
        .lbf-empty .lbf-btn { display: inline-flex; }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 560px) {
            .lbf-card { padding: 20px 18px; }
            .lbf-actions { flex-wrap: wrap; justify-content: stretch; }
            .lbf-actions .lbf-btn { flex: 1; }
            .lbf-actions .lbf-btn-ghost { flex: 0 0 auto; }
        }
    </style>

    {{-- ═══ HEADER ═══ --}}
    <div class="lbf-header">
        <div class="breadcrumb">
            <a href="{{ route('intern.dashboard') }}">Dashboard</a>
            <i class="ti ti-chevron-right"></i>
            <a href="{{ route('intern.logbooks') }}">Logbook</a>
            <i class="ti ti-chevron-right"></i>
            <span>{{ $logbookId ? 'Edit' : 'Buat' }}</span>
        </div>
        <h2 class="lbf-title">{{ $logbookId ? 'Edit Logbook' : 'Buat Logbook Baru' }}</h2>
        <p class="lbf-sub">{{ $logbookId ? 'Perbaiki dan perbarui catatan kegiatan harian Anda' : 'Catat kegiatan harian Anda selama magang' }}</p>
    </div>

    <div class="lbf-wrap">
        @if(!$hasActiveInternship)
            <div class="lbf-empty">
                <div class="lbf-empty-icon"><i class="ti ti-notebook-off"></i></div>
                <h3 class="lbf-empty-title">Tidak Ada Magang Aktif</h3>
                <p class="lbf-empty-sub">Anda tidak memiliki magang aktif saat ini, sehingga belum bisa membuat logbook.</p>
                <a href="{{ route('intern.vacancies') }}" class="lbf-btn lbf-btn-primary">
                    <i class="ti ti-briefcase"></i> Cari Lowongan
                </a>
            </div>
        @else
            <div class="lbf-card">
                @if($validationStatus === 'revision_requested')
                    <div class="lbf-banner lbf-banner-warn">
                        <i class="ti ti-alert-triangle"></i>
                        <div>
                            <strong>Perlu Revisi</strong>
                            <span>Logbook ini perlu direvisi. Silakan perbaiki dan kirim ulang.</span>
                        </div>
                    </div>
                @endif

                <div class="lbf-section-head">
                    <i class="ti ti-calendar-event"></i>
                    <span>Informasi Kegiatan</span>
                </div>

                <form wire:submit="saveAsDraft">
                    <div class="lbf-field">
                        <label>Tanggal Kegiatan <span class="lbf-req">*</span></label>
                        <div class="lbf-input-wrap">
                            <i class="ti ti-calendar"></i>
                            <input wire:model="activity_date" type="date" max="{{ date('Y-m-d') }}" class="lbf-input lbf-date">
                        </div>
                        @error('activity_date') <div class="lbf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="lbf-field">
                        <label>Jenis Kehadiran <span class="lbf-req">*</span></label>
                        <div class="lbf-attendance">
                            <label class="lbf-attendance-card {{ $attendanceType === 'hadir' ? 'active' : '' }}" data-type="hadir" wire:click="$set('attendanceType', 'hadir')">
                                <input type="radio" wire:model="attendanceType" value="hadir">
                                <div class="lbf-attendance-icon"><i class="ti ti-user-check"></i></div>
                                <div>
                                    <div class="lbf-attendance-label">Hadir</div>
                                    <div class="lbf-attendance-desc">Isi kegiatan harian seperti biasa</div>
                                </div>
                            </label>
                            <label class="lbf-attendance-card {{ $attendanceType === 'sakit' ? 'active' : '' }}" data-type="sakit" wire:click="$set('attendanceType', 'sakit')">
                                <input type="radio" wire:model="attendanceType" value="sakit">
                                <div class="lbf-attendance-icon"><i class="ti ti-heart-rate-monitor"></i></div>
                                <div>
                                    <div class="lbf-attendance-label">Sakit</div>
                                    <div class="lbf-attendance-desc">Otomatis disetujui</div>
                                </div>
                            </label>
                            <label class="lbf-attendance-card {{ $attendanceType === 'izin' ? 'active' : '' }}" data-type="izin" wire:click="$set('attendanceType', 'izin')">
                                <input type="radio" wire:model="attendanceType" value="izin">
                                <div class="lbf-attendance-icon"><i class="ti ti-user-off"></i></div>
                                <div>
                                    <div class="lbf-attendance-label">Izin</div>
                                    <div class="lbf-attendance-desc">Otomatis disetujui</div>
                                </div>
                            </label>
                        </div>
                        @error('attendanceType') <div class="lbf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="lbf-field" x-data="{ len: 0 }">
                        <label>Uraian Kegiatan @if($attendanceType === 'hadir')<span class="lbf-req">*</span>@endif</label>
                        <textarea
                            wire:model="activities"
                            rows="5"
                            class="lbf-input"
                            placeholder="{{ $attendanceType === 'hadir' ? 'Jelaskan kegiatan yang dilakukan hari ini...' : 'Opsional - jelaskan detail (jika ada)...' }}"
                            x-init="len = $el.value.length"
                            @input="len = $el.value.length"
                        ></textarea>
                        <div class="lbf-counter" :class="len < 20 ? 'lbf-counter-warn' : 'lbf-counter-ok'">
                            <i class="ti ti-edit"></i>
                            @if($attendanceType === 'hadir')
                                Minimal 20 karakter ·
                            @endif
                            <span x-text="len"></span> karakter
                        </div>
                        @error('activities') <div class="lbf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="lbf-field" x-data="{ len: 0 }">
                        <label>Hasil / Output @if($attendanceType === 'hadir')<span class="lbf-req">*</span>@endif</label>
                        <textarea
                            wire:model="output"
                            rows="3"
                            class="lbf-input"
                            placeholder="{{ $attendanceType === 'hadir' ? 'Apa hasil atau output dari kegiatan hari ini...' : 'Opsional - hasil dari kegiatan (jika ada)...' }}"
                            x-init="len = $el.value.length"
                            @input="len = $el.value.length"
                        ></textarea>
                        <div class="lbf-counter" :class="len < 10 ? 'lbf-counter-warn' : 'lbf-counter-ok'">
                            <i class="ti ti-checkbox"></i>
                            @if($attendanceType === 'hadir')
                                Minimal 10 karakter ·
                            @endif
                            <span x-text="len"></span> karakter
                        </div>
                        @error('output') <div class="lbf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="lbf-actions">
                        <a href="{{ route('intern.logbooks') }}" wire:navigate class="lbf-btn lbf-btn-ghost">
                            <i class="ti ti-x"></i> Batal
                        </a>
                        <button type="submit" class="lbf-btn lbf-btn-secondary" wire:loading.attr="disabled">
                            <span wire:loading.remove><i class="ti ti-device-floppy"></i> {{ $logbookId ? 'Simpan Perubahan' : 'Simpan Draft' }}</span>
                            <span wire:loading><i class="ti ti-loader lbf-spin"></i> Menyimpan...</span>
                        </button>
                        <button type="button" wire:click="submit" class="lbf-btn lbf-btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <i class="ti ti-send"></i>
                                @if($attendanceType === 'sakit' || $attendanceType === 'izin')
                                    Simpan & Kirim (Otomatis Disetujui)
                                @elseif($validationStatus === 'revision_requested')
                                    Kirim Ulang
                                @else
                                    Simpan & Kirim
                                @endif
                            </span>
                            <span wire:loading><i class="ti ti-loader lbf-spin"></i> Mengirim...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>