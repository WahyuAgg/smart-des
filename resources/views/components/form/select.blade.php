{{--
  Props:
    label       : label field
    model       : path Alpine, mis. 'form.input_mode'
    options     : array [ ['value' => ..., 'label' => ...], ... ]
    placeholder : teks untuk opsi kosong/null (default: '- Pilih -')
    nullable    : true = tampilkan opsi kosong di atas (default: true)
    required    : true|false
--}}
@props([
    'label' => null,
    'model' => null,
    'options' => [],
    'placeholder' => '- Pilih -',
    'nullable' => true,
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

    <select
        x-model="{{ $model }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent'
        ]) }}
    >
        @if ($nullable)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach ($options as $opt)
            <option value="{{ $opt['value'] }}">
                {{ $opt['label'] }}
            </option>
        @endforeach
    </select>

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