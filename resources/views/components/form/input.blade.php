{{--
  Input teks generik untuk form CRUD master-data.

  Props:
    label       : label field
    model       : path Alpine, mis. 'form.nama'
    type        : text|number (default: text)
    placeholder : placeholder input
    required    : true|false
    hint        : teks bantuan kecil di bawah input
    error       : ekspresi Alpine utk pesan error, mis. 'errors.nama' (opsional)
--}}
@props([
    'label' => null,
    'type' => 'text',
    'model',
    'placeholder' => null,
    'required' => false,
    'hint' => null,
    'error' => null,
    'wrapperClass' => '',
])

<div class="{{ $wrapperClass }}">
    @if ($label)
        <label class="block text-sm font-medium text-slate-700 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        x-model="{{ $model }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->merge([
            'class' => 'w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent'
        ]) }}
    />

    @if ($hint)
        <p class="mt-1 text-xs text-slate-400">{{ $hint }}</p>
    @endif

    @if ($error)
        <p
            x-show="{{ $error }}"
            x-text="{{ $error }}"
            class="mt-1 text-xs text-red-500"
        ></p>
    @endif
</div>