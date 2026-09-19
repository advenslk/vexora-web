@props(['name', 'label' => null, 'required' => false, 'divClass' => null, 'class' => null,'placeholder' => null, 'id' => null, 'type' => null, 'hideRequiredIndicator' => false, 'dirty' => false])
<fieldset class="flex flex-col w-full {{ $divClass ?? '' }}">
    @if ($label)
        <label for="{{ $name }}" class="mb-1 text-sm font-medium text-base/80">
            {{ $label }}
            @if ($required && !$hideRequiredIndicator)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <input type="{{ $type ?? 'text' }}" id="{{ $id ?? $name }}" name="{{ $name }}"
        class="block w-full rounded-md border border-neutral/80 bg-background-secondary/80 text-sm text-base shadow-sm transition-all duration-200 ease-out placeholder:text-base/35 focus:border-primary focus:ring-1 focus:ring-primary disabled:bg-background-secondary/50 disabled:cursor-not-allowed {{ $class ?? '' }} @if ($type !== 'color') px-3 py-2.5 @endif"
        placeholder="{{ $placeholder ?? ($label ?? '') }}"
        @if ($dirty && isset($attributes['wire:model'])) wire:dirty.class="!border-yellow-600" @endif
        {{ $attributes->except(['placeholder', 'label', 'id', 'name', 'type', 'class', 'divClass', 'required', 'hideRequiredIndicator', 'dirty']) }} @required($required) />
    @error($name)
        <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror
</fieldset>
