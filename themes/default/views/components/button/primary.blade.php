<button 
    {{ $attributes->merge(['class' => 'inline-flex min-h-11 items-center gap-2 justify-center rounded-md bg-primary px-4.5 py-2.5 text-sm font-semibold text-white shadow-[0_12px_30px_rgb(37_99_235/0.22)] transition-all duration-200 ease-out hover:-translate-y-0.5 hover:bg-primary/90 hover:shadow-[0_16px_38px_rgb(37_99_235/0.28)] active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:translate-y-0 w-full cursor-pointer']) }}>
    @if (isset($type) && $type === 'submit')
        <div role="status" wire:loading>
            <x-ri-loader-5-fill aria-hidden="true" class="size-6 me-2 fill-background animate-spin" />
            <span class="sr-only">Loading...</span>
        </div>
        <div wire:loading.remove>
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</button>
