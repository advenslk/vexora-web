<div class="flex items-center {{ $divClass ?? '' }}">
    {{-- <input type="hidden" name="{{ $name }}" value="0" /> --}}
    <input type="checkbox" name="{{ $name }}" id="{{ $id ?? $name }}"
        {{ $attributes->except(['label', 'name', 'id', 'class', 'divClass', 'required']) }}
        class="form-checkbox size-4 rounded border-neutral bg-background-secondary text-primary ring-offset-background transition-colors focus:ring-2 focus:ring-primary" />
    <label class="ml-2 text-sm text-base/75" for="{{ $id ?? $name }}">
        @if(isset($label))
            {{ $label }}
        @else
            {{ $slot }}
        @endif
    </label>

    @error($name)
        <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror
</div>
