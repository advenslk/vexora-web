<div class="grid gap-3">
    @forelse ($services as $service)
    <a href="{{ route('services.show', $service) }}" wire:navigate class="group block rounded-lg border border-neutral/70 bg-background/45 p-4 transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/45">
        <div class="flex items-start justify-between gap-4">
            <div class="flex min-w-0 items-start gap-3">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-md bg-primary/10 text-primary">
                    <x-ri-instance-line class="size-5" />
                </div>
                <div class="min-w-0">
                    <span class="block truncate font-semibold">{{ $service->label }}</span>
                    <p class="mt-1 text-sm text-base/55">Product: {{ $service->product->category->name }} {{ in_array($service->plan->type, ['recurring']) ? ' - ' . __('services.every_period', [
                        'period' => $service->plan->billing_period > 1 ? $service->plan->billing_period : '',
                        'unit' => trans_choice(__('services.billing_cycles.' . $service->plan->billing_unit), $service->plan->billing_period)
                    ]) : '' }} {{ $service->expires_at ? '- ' . __('services.renews_on') . ': '. $service->expires_at->format('M d, Y') : ''}}</p>
                </div>
            </div>
            <span class="vexora-badge shrink-0
                @if ($service->status == 'active') text-success
                @elseif($service->status == 'suspended') text-inactive
                @else text-warning
                @endif">
                {{ __('services.statuses.' . $service->status) }}
            </span>
        </div>
    </a>
    @empty
    <div class="rounded-lg border border-dashed border-neutral/70 bg-background/35 p-6 text-center">
        <x-ri-server-line class="mx-auto size-8 text-base/35" />
        <p class="mt-3 text-sm text-base/60">{{ __('services.no_services') }}</p>
    </div>
    @endforelse
</div>
