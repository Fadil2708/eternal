<div>
    <style>
        .spf-root {
            --spf-primary: #3155e7;
            --spf-primary-dark: #2444c9;
            --spf-primary-light: #eef2ff;
            --spf-text: #111936;
            --spf-muted: #64708a;
            --spf-border: #e5e7eb;
            --spf-danger: #dc2626;
        }

        .spf-header {
            margin-bottom: 22px;
        }
        .spf-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--spf-text);
            margin: 2px 0 4px;
            line-height: 1.3;
        }
        .spf-sub {
            font-size: 13px;
            color: var(--spf-muted);
            margin: 0;
        }

        .spf-card {
            max-width: 720px;
            background: #fff;
            border: 1px solid var(--spf-border);
            border-radius: 14px;
            padding: 24px;
        }
        .spf-card-title {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 14px;
            font-weight: 800;
            color: var(--spf-text);
            margin: 0 0 20px;
        }
        .spf-card-title i {
            font-size: 17px;
            color: var(--spf-primary);
        }

        .spf-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 16px;
        }
        .spf-field {
            margin-bottom: 16px;
        }
        .spf-field-full {
            grid-column: 1 / -1;
        }
        .spf-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--spf-text);
            margin-bottom: 6px;
        }
        .spf-required {
            color: var(--spf-danger);
        }
        .spf-input {
            width: 100%;
            padding: 11px 13px;
            font-size: 13px;
            font-family: inherit;
            color: var(--spf-text);
            background: #fff;
            border: 1px solid var(--spf-border);
            border-radius: 10px;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .spf-input::placeholder {
            color: #9aa3b5;
        }
        .spf-input:focus {
            border-color: var(--spf-primary);
            box-shadow: 0 0 0 3px var(--spf-primary-light);
        }
        .spf-input.is-invalid {
            border-color: var(--spf-danger);
        }
        .spf-error {
            font-size: 12px;
            color: var(--spf-danger);
            margin-top: 6px;
        }

        .spf-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 6px;
            padding-top: 18px;
            border-top: 1px solid var(--spf-border);
        }
        .spf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 20px;
            font-size: 13px;
            font-weight: 700;
            font-family: inherit;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: background .15s ease, box-shadow .15s ease, transform .15s ease;
        }
        .spf-btn-primary {
            background: linear-gradient(135deg, #3155e7, #2444c9);
            color: #fff;
            border: none;
            box-shadow: 0 4px 12px rgba(49, 85, 231, .28);
        }
        .spf-btn-primary:hover:not(:disabled) {
            box-shadow: 0 6px 18px rgba(49, 85, 231, .38);
            transform: translateY(-1px);
        }
        .spf-btn-primary:disabled {
            opacity: .6;
            cursor: wait;
        }
        .spf-btn-ghost {
            background: #fff;
            color: var(--spf-muted);
            border: 1px solid var(--spf-border);
        }
        .spf-btn-ghost:hover {
            background: #f8fafc;
            color: var(--spf-text);
        }

        @media (max-width: 620px) {
            .spf-grid {
                grid-template-columns: 1fr;
            }
            .spf-card {
                padding: 18px 16px;
            }
        }
    </style>

    <div class="spf-root">
        <div class="spf-header">
            <div class="breadcrumb">
                <a href="{{ route('supervisor.dashboard') }}" wire:navigate>Dashboard</a>
                <i class="ti ti-chevron-right"></i>
                <span>Profil</span>
            </div>
            <h2 class="spf-title">Profil Pembimbing</h2>
            <p class="spf-sub">Perbarui data diri Anda sebagai pembimbing</p>
        </div>

        <form wire:submit="save">
            <div class="spf-card">
                <h3 class="spf-card-title">
                    <i class="ti ti-user-circle"></i>
                    Data Diri
                </h3>

                <div class="spf-grid">
                    <div class="spf-field">
                        <label class="spf-label" for="spf-full-name">Nama Lengkap <span class="spf-required">*</span></label>
                        <input id="spf-full-name" wire:model="full_name" type="text" class="spf-input @error('full_name') is-invalid @enderror" placeholder="Masukkan nama lengkap">
                        @error('full_name') <div class="spf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="spf-field">
                        <label class="spf-label" for="spf-employee-id">NIP</label>
                        <input id="spf-employee-id" wire:model="employee_id" type="text" class="spf-input @error('employee_id') is-invalid @enderror" placeholder="Masukkan NIP">
                        @error('employee_id') <div class="spf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="spf-field">
                        <label class="spf-label" for="spf-division">Divisi</label>
                        <input id="spf-division" wire:model="division" type="text" class="spf-input @error('division') is-invalid @enderror" placeholder="Contoh: IT Support">
                        @error('division') <div class="spf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="spf-field">
                        <label class="spf-label" for="spf-position">Jabatan</label>
                        <input id="spf-position" wire:model="position" type="text" class="spf-input @error('position') is-invalid @enderror" placeholder="Contoh: Staff IT">
                        @error('position') <div class="spf-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="spf-field spf-field-full">
                        <label class="spf-label" for="spf-phone">No. Telepon</label>
                        <input id="spf-phone" wire:model="phone" type="text" class="spf-input @error('phone') is-invalid @enderror" placeholder="Contoh: 0812-3456-7890">
                        @error('phone') <div class="spf-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="spf-actions" style="max-width:720px">
                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait" class="spf-btn spf-btn-primary">
                    <i wire:loading.remove class="ti ti-device-floppy"></i>
                    <span wire:loading.remove>Simpan Profil</span>
                    <span wire:loading class="inline-flex items-center gap-1">
                        <i class="ti ti-loader animate-spin"></i>
                        Menyimpan...
                    </span>
                </button>
                <a href="{{ route('supervisor.dashboard') }}" wire:navigate class="spf-btn spf-btn-ghost">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>