<div class="vexora-shell">
    <x-navigation.breadcrumb />
    <div class="mt-5 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <h1 class="text-3xl font-bold sm:text-4xl">{{ __('services.services') }}</h1>
            <p class="mt-2 text-base/65">Manage your Vexora Cloud services and renewal status.</p>
        </div>
        <a href="{{ route('home') }}#plans"><x-button.primary class="sm:!w-fit">Order Service</x-button.primary></a>
    </div>

    <div class="mt-8 grid gap-4">
        @forelse ($services as $service)
        <a href="{{ route('services.show', $service) }}" wire:navigate class="vexora-card vexora-card-hover block p-5">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div class="flex min-w-0 items-start gap-4">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-md bg-primary/10 text-primary">
                        <x-ri-instance-line class="size-6" />
                    </div>
                    <div class="min-w-0">
                        <h2 class="truncate text-xl font-semibold">{{ $service->label }}</h2>
                        <p class="mt-1 text-sm text-base/55">
                            {{ $service->product->name }} · {{ $service->formattedPrice }}
                            @if($service->expires_at && $service->expires_at > now())
                            · {{ __('services.renews_in') }} {{ $service->expires_at->longAbsoluteDiffForHumans() }}
                            @endif
                        </p>
                    </div>
                </div>
                <span class="vexora-badge w-fit
                    @if ($service->status == 'active') text-success
                    @elseif($service->status == 'suspended' || $service->status == 'cancelled') text-inactive
                    @else text-warning
                    @endif">
                    {{ __('services.statuses.' . $service->status) }}
                </span>
            </div>
        </a>
        @empty
        <div class="vexora-card p-8 text-center">
            <x-ri-server-line class="mx-auto size-10 text-base/35" />
            <p class="mt-3 text-base/65">{{ __('services.no_services') }}</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $services->links() }}
    </div>
</div>
