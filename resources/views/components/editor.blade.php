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
                if (typeof window.setupEditor !== 'function') {
                    requestAnimationFrame(boot);
                    return;
                }
                const data = window.setupEditor(self.content);
                self.editor = data.editor;
                if (data.init) data.init.call(self, el);
            }
            boot();
        }
    }"
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <div x-ref="editor" class="tiptap-editor">{!! $slot !!}</div>
</div>
