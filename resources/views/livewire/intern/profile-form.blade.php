<div class="prf-root">
    <style>
        .prf-root {
            --prf-primary: #3155e7;
            --prf-primary-dark: #2444c9;
            --prf-primary-light: #eef2ff;
            --prf-text: #111936;
            --prf-muted: #64708a;
            --prf-border: #e5e7eb;
            --prf-danger: #dc2626;
            --prf-success: #16a34a;
        }

        /* ═══ HEADER ═══ */
        .prf-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }
        .prf-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--prf-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .prf-sub {
            font-size: 13px;
            color: var(--prf-muted);
            margin: 0;
        }
        .prf-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .prf-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            color: #15803d;
            background: #ecfdf3;
            border: 1px solid #bbf7d0;
            padding: 7px 13px;
            border-radius: 999px;
        }
        .prf-status-muted {
            color: var(--prf-muted);
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        /* ═══ CARD ═══ */
        .prf-wrap { max-width: 760px; margin: 0 auto; }
        .prf-card {
            background: #fff;
            border: 1px solid var(--prf-border);
            border-radius: 14px;
            padding: 22px 24px;
            margin-bottom: 20px;
        }
        .prf-section-head {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 11px;
            font-weight: 800;
            color: var(--prf-primary);
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: 18px;
        }
        .prf-section-head i { font-size: 15px; }

        /* ═══ IDENTITY ═══ */
        .prf-identity {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 18px;
            background: linear-gradient(135deg, #1e2a78 0%, #2444c9 55%, #3155e7 100%);
            border: none;
            color: #fff;
            margin-bottom: 20px;
        }
        .prf-identity::after {
            content: '';
            position: absolute;
            right: -50px;
            top: -50px;
            width: 190px;
            height: 190px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }
        .prf-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: rgba(255,255,255,.16);
            border: 2px solid rgba(255,255,255,.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }
        .prf-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .prf-identity-main { flex: 1; min-width: 0; position: relative; z-index: 1; }
        .prf-identity-name {
            font-size: 19px;
            font-weight: 800;
            margin: 0 0 3px;
            color: #fff;
            line-height: 1.3;
        }
        .prf-identity-line {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: rgba(255,255,255,.88);
            margin: 2px 0;
        }
        .prf-identity-line i { font-size: 14px; }
        .prf-identity-badge { position: relative; z-index: 1; flex-shrink: 0; }
        .prf-badge-open {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.3);
        }

        /* ═══ VIEW GRID ═══ */
        .prf-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .prf-item {
            background: #f8fafc;
            border: 1px solid var(--prf-border);
            border-radius: 12px;
            padding: 14px 16px;
        }
        .prf-item-wide { grid-column: span 2; }
        .prf-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 800;
            color: var(--prf-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 5px;
        }
        .prf-label i { font-size: 12px; color: var(--prf-primary); }
        .prf-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--prf-text);
            line-height: 1.45;
            word-break: break-word;
        }
        .prf-empty { color: #a8b0c1; font-weight: 400; }

        /* ═══ SKILL BADGES (view) ═══ */
        .prf-skills { display: flex; flex-wrap: wrap; gap: 8px; }
        .prf-skill-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--prf-primary-light);
            color: var(--prf-primary);
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 999px;
        }

        /* ═══ DOCS (view) ═══ */
        .prf-docs {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .prf-doc {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 22px 16px;
            border: 1px solid var(--prf-border);
            border-radius: 12px;
            background: #fafbfe;
            text-align: center;
            text-decoration: none;
            transition: all .2s;
        }
        .prf-doc-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: #f1f5f9;
            color: #94a3b8;
        }
        .prf-doc.done {
            border-color: #bbf7d0;
            background: #f0fdf4;
        }
        .prf-doc.done .prf-doc-icon { background: #dcfce7; color: var(--prf-success); }
        .prf-doc:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(49,85,231,.08);
        }
        .prf-doc-name { font-size: 12px; font-weight: 700; color: var(--prf-text); }
        .prf-doc-status { font-size: 11px; color: var(--prf-muted); }
        .prf-doc.done .prf-doc-status { color: var(--prf-success); font-weight: 600; }

        /* ═══ FORM ═══ */
        .prf-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .prf-field { display: flex; flex-direction: column; gap: 6px; }
        .prf-field-wide { grid-column: span 2; }
        .prf-field label {
            font-size: 12px;
            font-weight: 700;
            color: var(--prf-text);
        }
        .prf-req { color: var(--prf-danger); }
        .prf-input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d4d9e3;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            color: var(--prf-text);
            background: #fff;
            transition: border-color .15s, box-shadow .15s;
        }
        .prf-input:focus {
            outline: none;
            border-color: var(--prf-primary);
            box-shadow: 0 0 0 3px rgba(49,85,231,.15);
        }
        .prf-input::placeholder { color: #a8b0c1; }
        .prf-error { font-size: 12px; color: var(--prf-danger); font-weight: 600; margin-top: 2px; }
        .prf-hint { font-size: 12px; color: var(--prf-muted); margin: 8px 0 0; }

        /* ═══ BUTTONS ═══ */
        .prf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            border: none;
            transition: all .15s;
            text-decoration: none;
        }
        .prf-btn-primary {
            color: #fff;
            background: linear-gradient(90deg, var(--prf-primary-dark), var(--prf-primary));
            box-shadow: 0 6px 18px rgba(49,85,231,.3);
        }
        .prf-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(49,85,231,.4); }
        .prf-btn-primary:disabled { opacity: .65; cursor: not-allowed; transform: none; }
        .prf-btn-outline {
            color: var(--prf-muted);
            background: #fff;
            border: 1px solid var(--prf-border);
        }
        .prf-btn-outline:hover { color: var(--prf-text); border-color: #c7cedd; }
        .prf-actions { display: flex; justify-content: flex-end; gap: 10px; padding-top: 4px; }
        .prf-spin { animation: prf-spin 1s linear infinite; }
        @keyframes prf-spin { 100% { transform: rotate(360deg); } }

        /* ═══ UPLOAD ═══ */
        .prf-upload { position: relative; }
        .prf-dropzone {
            display: flex;
            align-items: center;
            gap: 14px;
            border: 2px dashed #cdd4e0;
            border-radius: 12px;
            padding: 16px;
            background: #fafbfe;
            cursor: pointer;
            transition: border-color .15s, background .15s;
        }
        .prf-dropzone:hover { border-color: var(--prf-primary); background: var(--prf-primary-light); }
        .prf-drop-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--prf-primary-light);
            color: var(--prf-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .prf-drop-title { font-size: 13px; font-weight: 700; color: var(--prf-text); margin: 0 0 2px; }
        .prf-drop-sub { font-size: 12px; color: var(--prf-muted); }
        .prf-file-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            width: 1px;
            height: 1px;
        }
        .prf-photo-preview {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            overflow: hidden;
            background: var(--prf-primary-light);
            color: var(--prf-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
            border: 2px solid #cdd4e0;
        }
        .prf-photo-preview img { width: 100%; height: 100%; object-fit: cover; }
        .prf-upload-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            margin-top: 8px;
        }
        .prf-upload-ok { color: var(--prf-success); font-weight: 600; }
        .prf-upload-loading { color: var(--prf-primary); }

        /* ═══ SKILL PICKER ═══ */
        .prf-skill-wrap { position: relative; }
        .prf-skill-trigger {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
            min-height: 46px;
            padding: 8px 12px;
            border: 1px solid #d4d9e3;
            border-radius: 10px;
            background: #fff;
            cursor: pointer;
            transition: border-color .15s, box-shadow .15s;
        }
        .prf-skill-trigger:hover,
        .prf-skill-trigger:focus-within {
            border-color: var(--prf-primary);
            box-shadow: 0 0 0 3px rgba(49,85,231,.12);
        }
        .prf-skill-placeholder { color: #a8b0c1; font-size: 13px; }
        .prf-skill-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--prf-primary-light);
            color: var(--prf-primary);
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 999px;
        }
        .prf-skill-tag i { cursor: pointer; font-size: 13px; opacity: .7; }
        .prf-skill-tag i:hover { opacity: 1; }
        .prf-skill-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid var(--prf-border);
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(17,25,54,.14);
            z-index: 30;
            padding: 12px;
            max-height: 320px;
            overflow-y: auto;
        }
        .prf-skill-search {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #d4d9e3;
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            margin-bottom: 10px;
        }
        .prf-skill-search:focus { outline: none; border-color: var(--prf-primary); }
        .prf-skill-options { display: flex; flex-direction: column; gap: 2px; }
        .prf-skill-cat {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--prf-muted);
            padding: 6px 8px 4px;
        }
        .prf-skill-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            color: var(--prf-text);
            transition: background .12s;
        }
        .prf-skill-option:hover { background: #f8fafc; }
        .prf-skill-option input { accent-color: var(--prf-primary); }
        .prf-skill-pop {
            font-size: 10px;
            font-weight: 700;
            color: var(--prf-primary);
            background: var(--prf-primary-light);
            padding: 2px 8px;
            border-radius: 999px;
        }
        .prf-skill-check { margin-left: auto; color: var(--prf-primary); font-size: 15px; }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 640px) {
            .prf-grid, .prf-form-grid { grid-template-columns: 1fr; }
            .prf-item-wide, .prf-field-wide { grid-column: span 1; }
            .prf-docs { grid-template-columns: 1fr; }
            .prf-identity { flex-wrap: wrap; }
            .prf-identity-badge { margin-left: auto; }
        }
    </style>

    {{-- ═══ HEADER ═══ --}}
    <div class="prf-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('intern.dashboard') }}">Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Profil</span>
            </div>
            <h2 class="prf-title">{{ $isEditing ? 'Edit Profil' : 'Profil Saya' }}</h2>
            <p class="prf-sub">{{ $isEditing ? 'Ubah data diri dan dokumen Anda' : 'Data diri Anda sebagai peserta magang' }}</p>
        </div>
        @if($hasProfile)
            <div class="prf-header-actions">
                <span class="prf-status {{ $isEditing ? 'prf-status-muted' : '' }}">
                    <i class="ti {{ $isEditing ? 'ti-pencil' : 'ti-circle-check' }}"></i>
                    {{ $isEditing ? 'Sedang diedit' : 'Profil Lengkap' }}
                </span>
                @if(!$isEditing)
                    <button type="button" wire:click="$set('isEditing', true)" class="prf-btn prf-btn-primary">
                        <i class="ti ti-pencil"></i> Edit Profil
                    </button>
                @endif
            </div>
        @endif
    </div>

    <div class="prf-wrap">
        @if(!$isEditing && $hasProfile)
            {{-- ═══ MODE LIHAT ═══ --}}

            <div class="prf-card prf-identity">
                <div class="prf-avatar">
                    @if($existingPhoto)
                        <img src="{{ route('profile.file', 'photo') }}" alt="Foto Profil" loading="lazy">
                    @else
                        <span>{{ strtoupper(substr($full_name, 0, 1) ?: '?') }}</span>
                    @endif
                </div>
                <div class="prf-identity-main">
                    <h3 class="prf-identity-name">{{ $full_name }}</h3>
                    <p class="prf-identity-line"><i class="ti ti-building"></i> {{ $institution_name }}</p>
                    @if($major)
                        <p class="prf-identity-line"><i class="ti ti-book"></i> {{ $major }}</p>
                    @endif
                </div>
                <div class="prf-identity-badge">
                    <span class="prf-badge-open"><i class="ti ti-shield-check"></i> Profil Lengkap</span>
                </div>
            </div>

            <div class="prf-card">
                <div class="prf-section-head">
                    <i class="ti ti-user"></i>
                    <span>Data Pribadi</span>
                </div>
                <div class="prf-grid">
                    <div class="prf-item">
                        <div class="prf-label"><i class="ti ti-user"></i> Nama Lengkap</div>
                        <div class="prf-value">@if($full_name){{ $full_name }}@else<span class="prf-empty">—</span>@endif</div>
                    </div>
                    <div class="prf-item">
                        <div class="prf-label"><i class="ti ti-gender-male"></i> Jenis Kelamin</div>
                        <div class="prf-value">
                            @if($gender === 'male') Laki-laki
                            @elseif($gender === 'female') Perempuan
                            @else <span class="prf-empty">—</span>
                            @endif
                        </div>
                    </div>
                    <div class="prf-item">
                        <div class="prf-label"><i class="ti ti-id"></i> NIM / NIS</div>
                        <div class="prf-value">@if($student_id){{ $student_id }}@else<span class="prf-empty">—</span>@endif</div>
                    </div>
                    <div class="prf-item">
                        <div class="prf-label"><i class="ti ti-building"></i> Nama Institusi</div>
                        <div class="prf-value">@if($institution_name){{ $institution_name }}@else<span class="prf-empty">—</span>@endif</div>
                    </div>
                    <div class="prf-item">
                        <div class="prf-label"><i class="ti ti-category"></i> Jenis Institusi</div>
                        <div class="prf-value">
                            @switch($institution_type)
                                @case('university') Universitas @break
                                @case('vocational') SMK / Politeknik @break
                                @case('highschool') SMA / Sederajat @break
                                @default <span class="prf-empty">—</span>
                            @endswitch
                        </div>
                    </div>
                    <div class="prf-item">
                        <div class="prf-label"><i class="ti ti-book"></i> Jurusan</div>
                        <div class="prf-value">@if($major){{ $major }}@else<span class="prf-empty">—</span>@endif</div>
                    </div>
                    <div class="prf-item">
                        <div class="prf-label"><i class="ti ti-phone"></i> No. Telepon</div>
                        <div class="prf-value">@if($phone){{ $phone }}@else<span class="prf-empty">—</span>@endif</div>
                    </div>
                    <div class="prf-item">
                        <div class="prf-label"><i class="ti ti-cake"></i> Tanggal Lahir</div>
                        <div class="prf-value">@if($date_of_birth){{ \Carbon\Carbon::parse($date_of_birth)->translatedFormat('d F Y') }}@else<span class="prf-empty">—</span>@endif</div>
                    </div>
                    <div class="prf-item prf-item-wide">
                        <div class="prf-label"><i class="ti ti-map-pin"></i> Alamat</div>
                        <div class="prf-value">@if($address){{ $address }}@else<span class="prf-empty">—</span>@endif</div>
                    </div>
                    <div class="prf-item prf-item-wide">
                        <div class="prf-label"><i class="ti ti-star"></i> Keahlian</div>
                        <div class="prf-value">
                            @forelse($skillsList as $skill)
                                <span class="prf-skill-badge"><i class="ti ti-bolt"></i>{{ $skill->name }}</span>
                            @empty
                                <span class="prf-empty">—</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="prf-card">
                <div class="prf-section-head">
                    <i class="ti ti-files"></i>
                    <span>Dokumen</span>
                </div>
                <div class="prf-docs">
                    @if($existingPhoto)
                        <a href="{{ route('profile.file', 'photo') }}" target="_blank" class="prf-doc done">
                            <div class="prf-doc-icon"><i class="ti ti-photo"></i></div>
                            <span class="prf-doc-name">Foto Profil</span>
                            <span class="prf-doc-status"><i class="ti ti-circle-check"></i> Terunggah</span>
                        </a>
                    @else
                        <span class="prf-doc">
                            <div class="prf-doc-icon"><i class="ti ti-photo-off"></i></div>
                            <span class="prf-doc-name">Foto Profil</span>
                            <span class="prf-doc-status">Belum diunggah</span>
                        </span>
                    @endif

                    @if($existingCv)
                        <a href="{{ route('profile.file', 'cv') }}" target="_blank" class="prf-doc done">
                            <div class="prf-doc-icon"><i class="ti ti-file-text"></i></div>
                            <span class="prf-doc-name">CV / Resume</span>
                            <span class="prf-doc-status"><i class="ti ti-circle-check"></i> Terunggah</span>
                        </a>
                    @else
                        <span class="prf-doc">
                            <div class="prf-doc-icon"><i class="ti ti-file-off"></i></div>
                            <span class="prf-doc-name">CV / Resume</span>
                            <span class="prf-doc-status">Belum diunggah</span>
                        </span>
                    @endif

                    @if($existingCoverLetter)
                        <a href="{{ route('profile.file', 'cover-letter') }}" target="_blank" class="prf-doc done">
                            <div class="prf-doc-icon"><i class="ti ti-mail"></i></div>
                            <span class="prf-doc-name">Surat Permohonan</span>
                            <span class="prf-doc-status"><i class="ti ti-circle-check"></i> Terunggah</span>
                        </a>
                    @else
                        <span class="prf-doc">
                            <div class="prf-doc-icon"><i class="ti ti-mail-off"></i></div>
                            <span class="prf-doc-name">Surat Permohonan</span>
                            <span class="prf-doc-status">Belum diunggah</span>
                        </span>
                    @endif
                </div>
            </div>

        @else
            {{-- ═══ MODE EDIT ═══ --}}
            <form wire:submit="save" enctype="multipart/form-data">
                <div class="prf-card">
                    <div class="prf-section-head">
                        <i class="ti ti-user"></i>
                        <span>Data Pribadi</span>
                    </div>

                    <div class="prf-form-grid">
                        <div class="prf-field">
                            <label>Nama Lengkap <span class="prf-req">*</span></label>
                            <input wire:model="full_name" type="text" class="prf-input" placeholder="Nama lengkap Anda">
                            @error('full_name') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field">
                            <label>Jenis Kelamin</label>
                            <select wire:model="gender" class="prf-input">
                                <option value="">Pilih...</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                            @error('gender') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field">
                            <label>NIM / NIS <span class="prf-req">*</span></label>
                            <input wire:model="student_id" type="text" class="prf-input" placeholder="Nomor induk mahasiswa/siswa">
                            @error('student_id') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field">
                            <label>Nama Institusi <span class="prf-req">*</span></label>
                            <input wire:model="institution_name" type="text" class="prf-input" placeholder="Nama sekolah/kampus">
                            @error('institution_name') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field">
                            <label>Jenis Institusi <span class="prf-req">*</span></label>
                            <select wire:model="institution_type" class="prf-input">
                                <option value="">Pilih...</option>
                                <option value="university">Universitas</option>
                                <option value="vocational">SMK / Politeknik</option>
                                <option value="highschool">SMA / Sederajat</option>
                            </select>
                            @error('institution_type') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field">
                            <label>Jurusan <span class="prf-req">*</span></label>
                            <input wire:model="major" type="text" class="prf-input" placeholder="Teknik Informatika">
                            @error('major') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field">
                            <label>No. Telepon</label>
                            <input wire:model="phone" type="text" class="prf-input" placeholder="08xxxxxxxxxx">
                            @error('phone') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field">
                            <label>Tanggal Lahir</label>
                            <input wire:model="date_of_birth" type="date" class="prf-input">
                            @error('date_of_birth') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field prf-field-wide">
                            <label>Alamat</label>
                            <textarea wire:model="address" rows="3" class="prf-input" placeholder="Alamat tempat tinggal"></textarea>
                            @error('address') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="prf-field prf-field-wide">
                            <label>Keahlian</label>
                            <div x-data="skillPicker()" x-init="init(@js($selectedSkills), @js($allSkills->flatten()->map(fn($s) => ['id' => (int)$s->id, 'name' => $s->name])->values()->toArray()))" class="prf-skill-wrap">
                                <div class="prf-skill-trigger" @click="open = !open" @click.away="open = false">
                                    <template x-for="id in selected" :key="id">
                                        <span class="prf-skill-tag" @click.stop="removeSkill(id)">
                                            <span x-text="getName(id)"></span>
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </template>
                                    <span x-show="!selected.length" class="prf-skill-placeholder">Pilih keahlian Anda...</span>
                                </div>
                                <div x-show="open" class="prf-skill-dropdown" x-cloak>
                                    <input type="text" x-model="search" placeholder="Cari keahlian..." class="prf-skill-search" @click.stop>
                                    <div x-show="!search.length" class="prf-skill-options">
                                        <div class="prf-skill-cat">Keahlian Populer</div>
                                        <template x-for="s in allSkills.slice(0, 5)" :key="s.id">
                                            <label class="prf-skill-option">
                                                <input type="checkbox" :value="s.id" x-model="selected" @change="sync($event)">
                                                <span x-text="s.name"></span>
                                                <span class="prf-skill-pop">Populer</span>
                                                <i class="ti ti-check prf-skill-check" x-show="selected.includes(String(s.id))"></i>
                                            </label>
                                        </template>
                                    </div>
                                    <div x-show="search.length > 0" class="prf-skill-options">
                                        <div class="prf-skill-cat">Semua Keahlian</div>
                                        @foreach($allSkills->flatten() as $skill)
                                        <label class="prf-skill-option" x-show="'{{ strtolower($skill->name) }}'.includes(search.toLowerCase())">
                                            <input type="checkbox" :value="{{ $skill->id }}" x-model="selected" @change="sync($event)">
                                            <span>{{ $skill->name }}</span>
                                            <i class="ti ti-check prf-skill-check" x-show="selected.includes('{{ $skill->id }}')"></i>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <p class="prf-hint">Klik kolom untuk membuka daftar keahlian, pilih sesuai bidang Anda</p>
                            @error('selectedSkills') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="prf-card">
                    <div class="prf-section-head">
                        <i class="ti ti-files"></i>
                        <span>Upload Dokumen</span>
                    </div>

                    <div class="prf-form-grid">
                        <div class="prf-field">
                            <label>Foto Profil</label>
                            <div class="prf-upload">
                                <label class="prf-dropzone">
                                    <div class="prf-photo-preview">
                                        @if($photo)
                                            <img src="{{ $photo->temporaryUrl() }}" alt="Preview Foto">
                                        @elseif($existingPhoto)
                                            <img src="{{ route('profile.file', 'photo') }}" alt="Foto Profil">
                                        @else
                                            <i class="ti ti-user"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="prf-drop-title">Pilih file foto</p>
                                        <p class="prf-drop-sub">JPG / PNG, maks 2MB</p>
                                    </div>
                                    <input wire:model="photo" type="file" accept="image/jpeg,image/png" class="prf-file-input">
                                </label>
                            </div>
                            <div wire:loading wire:target="photo" class="prf-upload-status prf-upload-loading">
                                <i class="ti ti-loader prf-spin"></i> Mengupload foto...
                            </div>
                            @if($photo)
                                <div class="prf-upload-status prf-upload-ok">
                                    <i class="ti ti-circle-check"></i> {{ $photo->getClientOriginalName() }}
                                </div>
                            @endif
                            @if($existingPhoto && !$photo)
                                <div class="prf-upload-status prf-upload-ok">
                                    <i class="ti ti-circle-check"></i> Foto terunggah
                                </div>
                            @endif
                            @error('photo') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="prf-field">
                            <label>CV / Resume</label>
                            <div class="prf-upload">
                                <label class="prf-dropzone">
                                    <div class="prf-drop-icon"><i class="ti ti-file-text"></i></div>
                                    <div>
                                        <p class="prf-drop-title">Pilih file CV</p>
                                        <p class="prf-drop-sub">PDF, maks 5MB</p>
                                    </div>
                                    <input wire:key="profile-cv-upload" wire:model="cv" type="file" accept=".pdf" class="prf-file-input">
                                </label>
                            </div>
                            <div wire:loading wire:target="cv" class="prf-upload-status prf-upload-loading">
                                <i class="ti ti-loader prf-spin"></i> Mengupload CV...
                            </div>
                            @if($cv)
                                <div class="prf-upload-status prf-upload-ok">
                                    <i class="ti ti-circle-check"></i> {{ $cv->getClientOriginalName() }}
                                </div>
                            @endif
                            @if($existingCv && !$cv)
                                <div class="prf-upload-status prf-upload-ok">
                                    <i class="ti ti-circle-check"></i> CV terunggah
                                </div>
                            @endif
                            @error('cv') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="prf-field prf-field-wide">
                            <label>Surat Permohonan</label>
                            <div class="prf-upload">
                                <label class="prf-dropzone">
                                    <div class="prf-drop-icon"><i class="ti ti-mail"></i></div>
                                    <div>
                                        <p class="prf-drop-title">Pilih file surat permohonan</p>
                                        <p class="prf-drop-sub">PDF, maks 5MB</p>
                                    </div>
                                    <input wire:key="profile-cover-letter-upload" wire:model="cover_letter" type="file" accept=".pdf" class="prf-file-input">
                                </label>
                            </div>
                            <div wire:loading wire:target="cover_letter" class="prf-upload-status prf-upload-loading">
                                <i class="ti ti-loader prf-spin"></i> Mengupload surat...
                            </div>
                            @if($cover_letter)
                                <div class="prf-upload-status prf-upload-ok">
                                    <i class="ti ti-circle-check"></i> {{ $cover_letter->getClientOriginalName() }}
                                </div>
                            @endif
                            @if($existingCoverLetter && !$cover_letter)
                                <div class="prf-upload-status prf-upload-ok">
                                    <i class="ti ti-circle-check"></i> Surat Permohonan terunggah
                                </div>
                            @endif
                            @error('cover_letter') <div class="prf-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="prf-actions">
                    @if($hasProfile)
                        <button type="button" wire:click="cancelEdit" class="prf-btn prf-btn-outline">
                            <i class="ti ti-x"></i> Batal
                        </button>
                    @endif
                    <button type="submit" class="prf-btn prf-btn-primary"
                            wire:loading.attr="disabled"
                            wire:loading.class="prf-btn-loading">
                        <span wire:loading.remove><i class="ti ti-device-floppy"></i> Simpan Profil</span>
                        <span wire:loading><i class="ti ti-loader prf-spin"></i> Menyimpan...</span>
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>