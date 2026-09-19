<button 
    {{ $attributes->merge(['class' => 'inline-flex min-h-11 items-center gap-2 justify-center rounded-md border border-neutral/80 bg-background-secondary/80 px-4.5 py-2.5 text-sm font-semibold text-base transition-all duration-200 ease-out hover:-translate-y-0.5 hover:border-primary/45 hover:bg-background-secondary active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:translate-y-0 w-full cursor-pointer']) }}>
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
