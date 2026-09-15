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
                <div class="field" x-data="{ ...tiptapEditor(), description: @entangle('description') }">
                    <label>Deskripsi</label>
                    <div class="tiptap-toolbar">
                        <button type="button" @click="toggleBold()" :class="{ 'is-active': isActive('bold') }" title="Bold (Ctrl+B)"><i class="ti ti-bold"></i></button>
                        <button type="button" @click="toggleItalic()" :class="{ 'is-active': isActive('italic') }" title="Italic (Ctrl+I)"><i class="ti ti-italic"></i></button>
                        <button type="button" @click="toggleUnderline()" :class="{ 'is-active': isActive('underline') }" title="Underline (Ctrl+U)"><i class="ti ti-underline"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="toggleHeading(2)" :class="{ 'is-active': isActive('heading', {level: 2}) }" title="Heading 2"><i class="ti ti-heading"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="toggleOrderedList()" :class="{ 'is-active': isActive('orderedList') }" title="Ordered List"><i class="ti ti-list-number"></i></button>
                        <button type="button" @click="toggleBulletList()" :class="{ 'is-active': isActive('bulletList') }" title="Bullet List"><i class="ti ti-list"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="toggleBlockquote()" :class="{ 'is-active': isActive('blockquote') }" title="Blockquote"><i class="ti ti-blockquote"></i></button>
                        <button type="button" @click="setHorizontalRule()" title="Horizontal Rule"><i class="ti ti-line"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="setLink()" :class="{ 'is-active': isActive('link') }" title="Insert Link"><i class="ti ti-link"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="setTextAlign('left')" :class="{ 'is-active': isActive({textAlign: 'left'}) }" title="Align Left"><i class="ti ti-align-left"></i></button>
                        <button type="button" @click="setTextAlign('center')" :class="{ 'is-active': isActive({textAlign: 'center'}) }" title="Align Center"><i class="ti ti-align-center"></i></button>
                        <button type="button" @click="setTextAlign('right')" :class="{ 'is-active': isActive({textAlign: 'right'}) }" title="Align Right"><i class="ti ti-align-right"></i></button>
                    </div>
                    <div wire:ignore x-ref="editor" class="tiptap-editor"></div>
                    @error('description') <div class="field-error">{{ $message }}</div> @enderror
                </div>
                <div class="field" x-data="{ ...tiptapEditor(), qualifications: @entangle('qualifications') }">
                    <label>Kualifikasi</label>
                    <div class="tiptap-toolbar">
                        <button type="button" @click="toggleBold()" :class="{ 'is-active': isActive('bold') }" title="Bold (Ctrl+B)"><i class="ti ti-bold"></i></button>
                        <button type="button" @click="toggleItalic()" :class="{ 'is-active': isActive('italic') }" title="Italic (Ctrl+I)"><i class="ti ti-italic"></i></button>
                        <button type="button" @click="toggleUnderline()" :class="{ 'is-active': isActive('underline') }" title="Underline (Ctrl+U)"><i class="ti ti-underline"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="toggleHeading(2)" :class="{ 'is-active': isActive('heading', {level: 2}) }" title="Heading 2"><i class="ti ti-heading"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="toggleOrderedList()" :class="{ 'is-active': isActive('orderedList') }" title="Ordered List"><i class="ti ti-list-number"></i></button>
                        <button type="button" @click="toggleBulletList()" :class="{ 'is-active': isActive('bulletList') }" title="Bullet List"><i class="ti ti-list"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="toggleBlockquote()" :class="{ 'is-active': isActive('blockquote') }" title="Blockquote"><i class="ti ti-blockquote"></i></button>
                        <button type="button" @click="setHorizontalRule()" title="Horizontal Rule"><i class="ti ti-line"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="setLink()" :class="{ 'is-active': isActive('link') }" title="Insert Link"><i class="ti ti-link"></i></button>
                        <span class="tiptap-separator"></span>
                        <button type="button" @click="setTextAlign('left')" :class="{ 'is-active': isActive({textAlign: 'left'}) }" title="Align Left"><i class="ti ti-align-left"></i></button>
                        <button type="button" @click="setTextAlign('center')" :class="{ 'is-active': isActive({textAlign: 'center'}) }" title="Align Center"><i class="ti ti-align-center"></i></button>
                        <button type="button" @click="setTextAlign('right')" :class="{ 'is-active': isActive({textAlign: 'right'}) }" title="Align Right"><i class="ti ti-align-right"></i></button>
                    </div>
                    <div wire:ignore x-ref="editor" class="tiptap-editor"></div>
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

        .tiptap-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
            padding: 6px 8px;
            border: 1.5px solid rgb(var(--panel-border));
            border-bottom: none;
            border-radius: var(--radius) var(--radius) 0 0;
            background: rgb(var(--input-bg));
        }
        .tiptap-toolbar button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 4px;
            background: transparent;
            color: rgb(var(--text-secondary));
            cursor: pointer;
            font-size: 14px;
            transition: all 0.15s ease;
        }
        .tiptap-toolbar button:hover {
            background: rgb(var(--brand) / 0.08);
            color: rgb(var(--brand));
        }
        .tiptap-toolbar button.is-active {
            background: rgb(var(--brand) / 0.15);
            color: rgb(var(--brand));
            font-weight: 600;
        }
        .tiptap-separator {
            width: 1px;
            height: 20px;
            background: rgb(var(--panel-border));
            margin: 5px 4px;
        }
        .tiptap-editor {
            min-height: 160px;
            padding: 12px 14px;
            border: 1.5px solid rgb(var(--panel-border));
            border-radius: 0 0 var(--radius) var(--radius);
            font-size: 13px;
            color: rgb(var(--text-secondary));
            background: rgb(var(--panel-bg));
            outline: none;
            transition: all var(--transition-fast);
        }
        .tiptap-editor:focus {
            border-color: rgb(var(--brand) / 1);
            box-shadow: 0 0 0 3px rgb(var(--brand) / 0.10);
        }
        .tiptap-editor p.is-editor-empty:first-child::before {
            content: attr(data-placeholder);
            float: left;
            color: rgb(var(--text-muted));
            pointer-events: none;
            height: 0;
        }
        .tiptap-editor h2 { font-size: 18px; font-weight: 700; margin: 12px 0 6px; }
        .tiptap-editor h3 { font-size: 15px; font-weight: 600; margin: 10px 0 4px; }
        .tiptap-editor ol { padding-left: 20px; list-style-type: decimal; }
        .tiptap-editor ul { padding-left: 20px; list-style-type: disc; }
        .tiptap-editor li { margin-bottom: 2px; }
        .tiptap-editor blockquote {
            border-left: 3px solid rgb(var(--brand) / 0.3);
            padding-left: 12px;
            margin: 8px 0;
            color: rgb(var(--text-muted));
            font-style: italic;
        }
        .tiptap-editor hr {
            border: none;
            border-top: 1.5px solid rgb(var(--panel-border));
            margin: 12px 0;
        }
        .tiptap-editor a {
            color: rgb(var(--brand));
            text-decoration: underline;
            cursor: pointer;
        }
        .tiptap-editor p { margin: 4px 0; line-height: 1.6; }
    </style>
</div>
