<div class="vexora-shell">
    @if($invoice = $service->invoices()->where('status', 'pending')->first())
    <div class="w-full mb-4">
        <div class="rounded-lg border border-warning/40 bg-warning/10 p-4 text-warning">
            <p class="font-medium">
                <x-ri-error-warning-fill class="mr-2 inline-block size-5" />{{ __('services.outstanding_invoice') }}
                <a href="{{ route('invoices.show', $invoice)}}"
                    class="underline underline-offset-2 hover:text-base">{{ __('services.view_and_pay') }}</a>.
            </p>
        </div>
    </div>
    @endif
    <div class="vexora-card p-6 sm:p-8">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
            <div>
                <span class="vexora-kicker">Service details</span>
                <h1 class="mt-2 text-3xl font-bold">{{ $service->label }}</h1>
                <p class="mt-2 text-base/60">{{ $service->product->name }}</p>
            </div>
            <span class="vexora-badge w-fit
                @if ($service->status == 'active') text-success
                @elseif($service->status == 'cancelled') text-error
                @else text-warning
                @endif">
                @if($service->cancellation && $service->status == 'active')
                {{ __('services.statuses.cancellation_pending') }}
                @else
                {{ __('services.statuses.' . $service->status) }}
                @endif
            </span>
        </div>
        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <div>
                <h4 class="text-lg font-semibold">{{ __('services.product_details') }}</h4>
                <div class="mt-4 grid gap-3 rounded-lg border border-neutral/70 bg-background/45 p-4">
                    @include('services.partials.label')
                    <div class="flex items-center justify-between gap-4 text-sm">
                        <span class="text-base/55">{{ __('services.price') }}</span>
                        <span class="font-semibold">{{ $service->formattedPrice }}</span>
                    </div>
                    @if($service->plan->type == 'recurring')
                    <div class="flex items-center justify-between gap-4 text-sm">
                        <span class="text-base/55">{{ __('services.billing_cycle') }}</span>
                        <span class="font-semibold">{{ __('services.every_period', [
                            'period' => $service->plan->billing_period > 1 ? $service->plan->billing_period : '',
                            'unit' => trans_choice(__('services.billing_cycles.' . $service->plan->billing_unit),
                            $service->plan->billing_period)
                            ])
                            }}</span>
                    </div>
                    @if($service->expires_at)
                    <div class="flex items-center justify-between gap-4 text-sm">
                        <span class="text-base/55">{{ __('services.renews_on') }}</span>
                        <span class="font-semibold">
                            {{ $service->expires_at->format('M d, Y') }}
                        </span>
                    </div>
                    @endif
                    @endif
                    @include('services.partials.billing-agreement')
                    @foreach ($fields as $field)
                    <div class="flex items-center justify-between gap-4 text-sm">
                        <span class="text-base/55">{{ $field['label'] }}</span>
                        <span class="font-semibold">{{ $field['text'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @if($service->cancellable || $service->upgradable || count($buttons) > 0)
            <div>
                <h4 class="text-lg font-semibold">{{ __('services.actions') }}</h4>
                <div class="mt-4 flex flex-row gap-2 flex-wrap">
                    @if($service->upgradable)
                    <a href="{{ route('services.upgrade', $service->id) }}">
                        <x-button.primary class="h-fit !w-fit">
                            <span>{{ __('services.upgrade') }}</span>
                        </x-button.primary>
                    </a>
                    @endif
                    @if($service->upgrade()->where('status', 'pending')->exists())
                    <x-button.primary class="h-fit !w-fit"
                        @click="Alpine.store('notifications').addNotification([{message: '{{ __('services.upgrade_pending') }}', type: 'error'}])">
                        <span>{{ __('services.upgrade') }}</span>
                    </x-button.primary>
                    @endif
                    @if($service->cancellable)
                    <x-button.danger class="h-fit !w-fit" wire:click="$set('showCancel', true)">
                        <span wire:loading.remove wire:target="$set('showCancel', true)">{{ __('services.cancel')
                            }}</span>
                        <x-loading target="$set('showCancel', true)" />
                    </x-button.danger>
                    @endif
                    @if($showCancel)
                    <x-modal open="true"
                        title="{{ __('services.cancellation', ['service' => $service->product->name]) }}"
                        width="max-w-3xl">
                        <livewire:services.cancel :service="$service" />
                        <x-slot name="closeTrigger">
                            <div class="flex gap-4">
                                <button wire:click="$set('showCancel', false)" @click="open = false"
                                    class="text-base/70 hover:text-base">
                                    <x-ri-close-fill class="size-6" />
                                </button>
                            </div>
                        </x-slot>
                    </x-modal>
                    @endif
                </div>
                <div class="mt-2 flex flex-row gap-2 flex-wrap">
                    @foreach ($buttons as $button)
                    <!-- If the button has a function then call it when clicked -->
                    @if (isset($button['function']))
                    <x-button.primary class="h-fit !w-fit" wire:click="goto('{{ $button['function'] }}')">
                        {{ $button['label'] }}
                    </x-button.primary>
                    @else
                    <a href="{{ $button['url'] }}"
                        @if(!empty($button['target'])) target="{{ $button['target'] }}" @endif
                        @if(($button['target'] ?? null) === '_blank') rel="noopener noreferrer" @endif>
                        <x-button.primary class="h-fit !w-fit">
                            {{ $button['label'] }}
                        </x-button.primary>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    @if (count($views) > 0)
    <div class="vexora-card mt-6 p-4">
        @if (count($views) > 1)
        <div class="flex w-fit mb-2 flex-row flex-wrap">
            @foreach ($views as $view)
            <button wire:click="changeView('{{ $view['name'] }}')"
                class="rounded-md px-4 py-2 text-sm font-semibold transition-colors {{ $view['name'] == $currentView ? 'bg-primary/10 text-primary' : 'text-base/65 hover:bg-background hover:text-base' }}">
                {{ $view['label'] }}
            </button>
            @endforeach
        </div>
        @endif

        <!-- show loading spinner -->
        <x-loading target="changeView" />
        <div wire:loading.remove wire:target="changeView">
            {!! $extensionView !!}
        </div>
    </div>
    @endif
</div>
