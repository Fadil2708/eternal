<div class="adx-root">
    <div class="adx-header" style="margin-bottom:20px">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.vacancies.index') }}" wire:navigate>Lowongan</a>
                <i class="ti ti-chevron-right"></i>
                <span>{{ $isEditing ? 'Edit' : 'Buat Baru' }}</span>
            </div>
            <h2 class="adx-title">{{ $isEditing ? 'Edit Lowongan' : 'Buat Lowongan Baru' }}</h2>
        </div>

        <div class="adx-header-right">
            <a href="{{ route('admin.vacancies.index') }}" wire:navigate class="adx-btn adx-btn-ghost">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <form wire:submit="save">
        <div class="form-layout">
            <div class="form-main">
                <div class="form-row-3">
                    <div class="field">
                        <label>Judul Lowongan</label>
                        <input wire:model="title" type="text" class="input">
                        @error('title') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Divisi</label>
                        <input wire:model="division" type="text" class="input">
                        @error('division') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Kuota</label>
                        <input wire:model="quota" type="number" min="1" class="input">
                        @error('quota') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="field">
                    <label>Deskripsi</label>
                    <input type="hidden" id="description-input" value="{{ $description }}" wire:ignore>
                    <trix-editor input="description-input" wire:ignore.self x-data x-on:trix-change.debounce.1000ms="$wire.set('description', $event.target.value)"></trix-editor>
                    @error('description') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label>Kualifikasi</label>
                    <input type="hidden" id="qualifications-input" value="{{ $qualifications }}" wire:ignore>
                    <trix-editor input="qualifications-input" wire:ignore.self x-data x-on:trix-change.debounce.1000ms="$wire.set('qualifications', $event.target.value)"></trix-editor>
                    @error('qualifications') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-row-3">
                    <div class="field">
                        <label>Status</label>
                        <select wire:model="status" class="input">
                            <option value="draft">Draft</option>
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                        @error('status') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Tgl Mulai</label>
                        <input wire:model="start_date" type="date" class="input">
                        @error('start_date') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Tgl Selesai</label>
                        <input wire:model="end_date" type="date" class="input">
                        @error('end_date') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Batas Pendaftaran</label>
                        <input wire:model="application_deadline" type="date" class="input">
                        @error('application_deadline') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4" style="margin-top:24px">
            <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait" class="adx-btn adx-btn-primary">
                <i wire:loading.remove class="ti ti-device-floppy" style="font-size:16px"></i>
                <span wire:loading.remove>{{ $isEditing ? 'Perbarui' : 'Buat' }} Lowongan</span>
                <span wire:loading class="inline-flex items-center gap-1">
                    <i class="ti ti-loader animate-spin" style="font-size:16px"></i>
                    Menyimpan...
                </span>
            </button>
            <a href="{{ route('admin.vacancies.index') }}" wire:navigate class="adx-btn adx-btn-ghost">
                Batal
            </a>
        </div>
    </form>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.19/dist/trix.css">
    <style nonce="{{ $cspNonce }}">
        trix-editor {
            width: 100%; min-height: 160px;
            border: 1.5px solid rgb(var(--panel-border)); border-radius: var(--radius);
            font-size: 13px; color: rgb(var(--text-secondary));
            background: rgb(var(--input-bg)); outline: none;
            transition: all var(--transition-fast);
        }
        trix-editor:focus { border-color: rgb(var(--brand) / 1); background: rgb(var(--panel-bg)); box-shadow: 0 0 0 3px rgb(var(--brand) / 0.10); }
        trix-toolbar .trix-button-group--file-tools { display: none; }
        trix-toolbar { padding: 4px 0; }
        trix-toolbar .trix-button { padding: 6px 8px; }
    </style>
    <script nonce="{{ $cspNonce }}" src="https://cdn.jsdelivr.net/npm/trix@2.1.19/dist/trix.umd.min.js" defer></script>
</div>
