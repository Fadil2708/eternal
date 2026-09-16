@props(['model' => null])

@php
    $wireModel = $model ?? $attributes->wire('model')->value();
@endphp

<div
    x-data="{
        content: $wire.entangle('{{ $wireModel }}').defer,
        editor: null,
        init() {
            const self = this;
            const el = this.$refs.editor;
            function boot() {
                if (typeof window.createTiptapEditor !== 'function') {
                    requestAnimationFrame(boot);
                    return;
                }
                self.editor = window.createTiptapEditor(
                    el,
                    self.content || el.innerHTML,
                    (html) => { self.content = html; }
                );
            }
            boot();
        },
        exec(cmd) {
            if (!this.editor) return;
            cmd(this.editor.chain().focus());
        },
        isActive(name, attrs) {
            return this.editor ? this.editor.isActive(name, attrs) : false;
        }
    }"
    wire:ignore
    x-ignore
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <div class="tiptap-toolbar">
        <button type="button" @click="exec(c => c.toggleBold())" :class="{ 'active': isActive('bold') }" title="Bold">
            <i class="ti ti-bold"></i>
        </button>
        <button type="button" @click="exec(c => c.toggleItalic())" :class="{ 'active': isActive('italic') }" title="Italic">
            <i class="ti ti-italic"></i>
        </button>
        <button type="button" @click="exec(c => c.toggleStrike())" :class="{ 'active': isActive('strike') }" title="Strikethrough">
            <i class="ti ti-strikethrough"></i>
        </button>
        <span class="tiptap-separator"></span>
        <button type="button" @click="exec(c => c.toggleHeading({ level: 2 }))" :class="{ 'active': isActive('heading', { level: 2 }) }" title="Heading 2">
            <i class="ti ti-h-2"></i>
        </button>
        <button type="button" @click="exec(c => c.toggleHeading({ level: 3 }))" :class="{ 'active': isActive('heading', { level: 3 }) }" title="Heading 3">
            <i class="ti ti-h-3"></i>
        </button>
        <span class="tiptap-separator"></span>
        <button type="button" @click="exec(c => c.toggleBulletList())" :class="{ 'active': isActive('bulletList') }" title="Bullet List">
            <i class="ti ti-list"></i>
        </button>
        <button type="button" @click="exec(c => c.toggleOrderedList())" :class="{ 'active': isActive('orderedList') }" title="Numbered List">
            <i class="ti ti-list-ol"></i>
        </button>
        <button type="button" @click="exec(c => c.toggleBlockquote())" :class="{ 'active': isActive('blockquote') }" title="Blockquote">
            <i class="ti ti-quote"></i>
        </button>
        <span class="tiptap-separator"></span>
        <button type="button" @click="exec(c => c.setTextAlign('left'))" title="Align Left">
            <i class="ti ti-align-left"></i>
        </button>
        <button type="button" @click="exec(c => c.setTextAlign('center'))" title="Align Center">
            <i class="ti ti-align-center"></i>
        </button>
        <button type="button" @click="exec(c => c.setTextAlign('right'))" title="Align Right">
            <i class="ti ti-align-right"></i>
        </button>
        <span class="tiptap-separator"></span>
        <button type="button" @click="exec(c => {
            const url = prompt('URL:', 'https://');
            if (url) c.setLink({ href: url });
        })" :class="{ 'active': isActive('link') }" title="Link">
            <i class="ti ti-link"></i>
        </button>
        <button type="button" @click="exec(c => c.setParagraph())" :class="{ 'active': isActive('paragraph') }" title="Paragraph">
            <i class="ti ti-text"></i>
        </button>
        <button type="button" @click="exec(c => c.setHorizontalRule())" title="Horizontal Rule">
            <i class="ti ti-minus"></i>
        </button>
    </div>

    <div x-ref="editor" class="tiptap-editor">{!! $slot !!}</div>
</div>
