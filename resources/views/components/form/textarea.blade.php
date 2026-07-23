{{--
  Textarea generik untuk form CRUD master-data.

  Props:
    label       : label field
    model       : path Alpine, mis. 'form.keterangan'
    placeholder : teks placeholder
    required    : true|false
    rows        : jumlah baris (default: 3)
    hint        : teks bantuan kecil di bawah textarea
    error       : ekspresi Alpine untuk pesan error, mis. 'errors.keterangan' (opsional)
    wrapperClass : kelas tambahan untuk wrapper div
--}}
@props([
    'label' => null,
    'model' => null,
    'placeholder' => null,
    'required' => false,
    'rows' => 3,
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

    <textarea
        rows="{{ $rows }}"
        x-model="{{ $model }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $attributes->merge([
            'class' => 'w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent'
        ]) }}
    ></textarea>

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