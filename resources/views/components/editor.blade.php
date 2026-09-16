@props(['model' => null])

@php
    $wireModel = $model ?? $attributes->wire('model')->value();
@endphp

<div
    x-data="setupEditor($wire.entangle('{{ $wireModel }}').defer)"
    x-init="() => init($refs.editor)"
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <div x-ref="editor" class="tiptap-editor"></div>
</div>
