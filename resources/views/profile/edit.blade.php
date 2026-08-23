<x-app-layout>
    @section('title', 'Profil')
    @php $pageTitle = 'Profil'; @endphp

    <style>
        .acp-root {
            --acp-primary: #3155e7;
            --acp-primary-dark: #2444c9;
            --acp-primary-light: #eef2ff;
            --acp-text: #111936;
            --acp-muted: #64708a;
            --acp-border: #e5e7eb;
            --acp-danger: #dc2626;
        }

        /* ═══ HEADER ═══ */
        .acp-header { margin-bottom: 22px; }
        .acp-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--acp-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .acp-sub { font-size: 13px; color: var(--acp-muted); margin: 0; }

        /* ═══ WRAP ═══ */
        .acp-wrap { max-width: 640px; margin: 0 auto; }
        .acp-card {
            background: #fff;
            border: 1px solid var(--acp-border);
            border-radius: 14px;
            padding: 26px;
            margin-bottom: 20px;
        }
        .acp-card-danger {
            background: #fff;
            border: 1px solid #fecaca;
            border-radius: 14px;
            padding: 26px;
            margin-bottom: 20px;
        }
        .acp-card-head { display: flex; align-items: flex-start; gap: 13px; margin-bottom: 18px; }
        .acp-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: var(--acp-primary-light);
            color: var(--acp-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
        }
        .acp-card-danger .acp-card-icon {
            background: #fee2e2;
            color: var(--acp-danger);
        }
        .acp-card-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--acp-text);
            margin: 0 0 3px;
        }
        .acp-card-sub { font-size: 13px; color: var(--acp-muted); margin: 0; line-height: 1.55; }

        /* ═══ FIELDS ═══ */
        .acp-field { margin-bottom: 18px; }
        .acp-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--acp-text);
            margin-bottom: 7px;
        }
        .acp-required { color: var(--acp-danger); }
        .acp-input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--acp-border);
            border-radius: 11px;
            font-size: 14px;
            font-family: inherit;
            color: var(--acp-text);
            background: #fff;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .acp-input:focus {
            outline: none;
            border-color: var(--acp-primary);
            box-shadow: 0 0 0 3px rgba(49, 85, 231, .14);
        }
        .acp-error { font-size: 12px; color: var(--acp-danger); margin-top: 6px; }

        /* ═══ INFO BANNER ═══ */
        .acp-info {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            background: var(--acp-primary-light);
            border: 1px solid #dbe3fb;
            border-radius: 11px;
            padding: 12px 14px;
            margin-top: 12px;
        }
        .acp-info > i { color: var(--acp-primary); font-size: 17px; margin-top: 1px; }
        .acp-info p { margin: 0; font-size: 13px; color: var(--acp-text); line-height: 1.55; }
        .acp-info button {
            background: none;
            border: none;
            padding: 0;
            color: var(--acp-primary);
            font-size: 13px;
            font-weight: 700;
            text-decoration: underline;
            cursor: pointer;
            font-family: inherit;
        }
        .acp-info-success { color: #16a34a; font-weight: 700; }

        /* ═══ BUTTONS ═══ */
        .acp-footer { display: flex; align-items: center; gap: 14px; margin-top: 24px; }
        .acp-submit {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 26px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(90deg, var(--acp-primary-dark), var(--acp-primary));
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: opacity .15s ease, transform .15s ease;
        }
        .acp-submit:hover:not(:disabled) { transform: translateY(-1px); }
        .acp-submit:disabled { opacity: .6; cursor: wait; }
        .acp-saved {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #16a34a;
        }
        .acp-spin { animation: acp-rotate .8s linear infinite; }
        @keyframes acp-rotate { to { transform: rotate(360deg); } }

        .acp-danger-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            border: none;
            border-radius: 11px;
            background: var(--acp-danger);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s ease, transform .15s ease;
        }
        .acp-danger-btn:hover:not(:disabled) { background: #b91c1c; transform: translateY(-1px); }
        .acp-danger-btn:disabled { opacity: .6; cursor: wait; }

        /* ═══ MODAL INNER ═══ */
        .acp-modal-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--acp-text);
            margin: 0 0 8px;
        }
        .acp-modal-text {
            font-size: 13px;
            color: var(--acp-muted);
            line-height: 1.6;
            margin: 0 0 20px;
        }
        .acp-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
        }
        .acp-btn-cancel {
            padding: 10px 20px;
            border: 1px solid var(--acp-border);
            border-radius: 10px;
            background: #fff;
            color: var(--acp-text);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: background .15s ease;
        }
        .acp-btn-cancel:hover { background: #f8fafc; }

        @media (max-width: 560px) {
            .acp-card, .acp-card-danger { padding: 20px 18px; }
        }
    </style>

    <div class="acp-root">
        {{-- ═══ HEADER ═══ --}}
        <div class="acp-header">
            <div class="breadcrumb">
                <span>Profil</span>
            </div>
            <h2 class="acp-title">Edit Profil</h2>
            <p class="acp-sub">Kelola informasi akun dan keamanan Anda</p>
        </div>

        <div class="acp-wrap">
            <div class="acp-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="acp-card">
                @include('profile.partials.update-password-form')
            </div>

            <div class="acp-card-danger">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>