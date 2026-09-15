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
                    <input type="hidden" wire:model.live="description" name="description">
                    <div wire:ignore>
                        <textarea id="description-editor">{{ $description }}</textarea>
                    </div>
                    @error('description') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="field">
                    <label>Kualifikasi</label>
                    <input type="hidden" wire:model.live="qualifications" name="qualifications">
                    <div wire:ignore>
                        <textarea id="qualifications-editor">{{ $qualifications }}</textarea>
                    </div>
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
                        <div class="adx-date-wrap">
                            <i class="ti ti-calendar adx-date-icon"></i>
                            <input wire:model="start_date" type="date" class="input">
                        </div>
                        @error('start_date') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Tgl Selesai</label>
                        <div class="adx-date-wrap">
                            <i class="ti ti-calendar adx-date-icon"></i>
                            <input wire:model="end_date" type="date" class="input">
                        </div>
                        @error('end_date') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label>Batas Pendaftaran</label>
                        <div class="adx-date-wrap">
                            <i class="ti ti-calendar adx-date-icon"></i>
                            <input wire:model="application_deadline" type="date" class="input">
                        </div>
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
    <style nonce="{{ $cspNonce }}">
        .adx-date-wrap { position: relative; }
        .adx-date-icon {
            position: absolute;
            left: 14px; top: 50%; transform: translateY(-50%);
            color: var(--muted, #6b7280);
            font-size: 16px; pointer-events: none;
            transition: color .2s ease;
        }
        .adx-date-wrap:focus-within .adx-date-icon { color: var(--primary, #3b82f6); }
        .adx-date-wrap .input { padding-left: 42px; position: relative; z-index: 2; }
    </style>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js" nonce="{{ $cspNonce }}" id="ckeditor-cdn"></script>
    <script nonce="{{ $cspNonce }}">
    function initCKEditors() {
        function initCKEditor(selector, inputName) {
            var el = document.querySelector(selector);
            if (!el || el.dataset.ckeditorInit) return;
            ClassicEditor.create(el, {
                toolbar: [
                    'bold', 'italic', 'underline', '|',
                    'heading', '|',
                    'numberedList', 'bulletedList', '|',
                    'blockQuote', 'horizontalRule', 'link', '|',
                    'alignment:left', 'alignment:center', 'alignment:right', '|',
                    'undo', 'redo'
                ]
            }).then(function(editor) {
                el.dataset.ckeditorInit = '1';
                editor.model.document.on('change:data', function() {
                    var input = document.querySelector('input[name="' + inputName + '"]');
                    if (input) {
                        input.value = editor.getData();
                        input.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                });
            });
        }
        initCKEditor('#description-editor', 'description');
        initCKEditor('#qualifications-editor', 'qualifications');
    }
    document.getElementById('ckeditor-cdn').onload = function() {
        initCKEditors();
    };
    if (window.ClassicEditor) {
        initCKEditors();
    }
    </script>
</div>
