@props([
    'label' => null,
    'model' => null,
    'placeholder' => null,
    'required' => false,
    'rows' => 3,
    'hint' => null,
])

<div>
  @if ($label)
    <label class="block text-sm font-medium text-slate-700 mb-1">
      {{ $label }}
      @if ($required) <span class="text-red-500">*</span> @endif
    </label>
  @endif

  <textarea rows="{{ $rows }}"
            x-model="{{ $model }}"
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            {{ $attributes->merge(['class' => 'w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent']) }}></textarea>

  @if ($hint)
    <p class="text-xs text-slate-400 mt-1">{{ $hint }}</p>
  @endif
</div>
