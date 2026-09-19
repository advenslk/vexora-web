<div class="panel-page">
    <main class="panel-main">
    <div class="panel-topbar">
        <div>
        <x-navigation.breadcrumb />
        <h1>{{ $product->name }}</h1>
        <p>Configure your Vexora Cloud service and continue through the secure billing flow.</p>
        </div>
    </div>

    <div class="panel-checkout">
        <div class="panel-main">
            <section class="panel-card order-card">
                <div class="panel-section-head">
                    <div>
                        <span class="panel-badge">Vexora Cloud hosting</span>
                        <h2>Order Details</h2>
                    </div>
                </div>
                <div class="panel-support">
                    @if ($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-20 w-20 rounded-md object-cover">
                    @endif
                    <div>
                        <h3>{{ $product->name }}</h3>
                        <article class="prose prose-sm dark:prose-invert mt-3 max-h-36 overflow-y-auto">
                            {!! $product->description !!}
                        </article>
                    </div>
                </div>
            </section>

            @if ($product->availablePlans()->count() > 1)
            <section class="panel-card order-card">
                <h2>Billing plan</h2>
                <x-form.select wire:model.live="plan_id" name="plan_id" label="Select a plan">
                    @foreach ($product->availablePlans() as $availablePlan)
                    <option value="{{ $availablePlan->id }}">
                        {{ $availablePlan->name }} -
                        {{ $availablePlan->price()->formatted->price }}
                        @if ($availablePlan->price()->has_setup_fee)
                        + {{ $availablePlan->price()->formatted->setup_fee }} {{ __('product.setup_fee') }}
                        @endif
                    </option>
                    @endforeach
                </x-form.select>
            </section>
            @endif

            @if($product->configOptions->count() || count($this->getCheckoutConfig()))
            <section class="panel-card order-card">
                <h2>Configuration</h2>
                <div class="setup-form">
                    @foreach ($product->configOptions as $configOption)
                    @php
                        $showPriceTag = $configOption->children->filter(fn ($value) => !$value->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->is_free)->count() > 0;
                    @endphp
                    <x-form.configoption :config="$configOption" :name="'configOptions.' . $configOption->id" :showPriceTag="$showPriceTag" :plan="$plan">
                        @if ($configOption->type == 'select')
                        @foreach ($configOption->children as $configOptionValue)
                        <option value="{{ $configOptionValue->id }}">
                            {{ $configOptionValue->name }}
                            {{ ($showPriceTag && $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->available) ? ' - ' . $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit) : '' }}
                        </option>
                        @endforeach
                        @elseif($configOption->type == 'radio')
                        @foreach ($configOption->children as $configOptionValue)
                        <div class="flex items-center gap-2">
                            <input type="radio" id="{{ $configOptionValue->id }}" name="{{ $configOption->id }}" wire:model.live="configOptions.{{ $configOption->id }}" value="{{ $configOptionValue->id }}" />
                            <label for="{{ $configOptionValue->id }}">
                                {{ $configOptionValue->name }}
                                {{ ($showPriceTag && $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit)->available) ? ' - ' . $configOptionValue->price(billing_period: $plan->billing_period, billing_unit: $plan->billing_unit) : '' }}
                            </label>
                        </div>
                        @endforeach
                        @endif
                    </x-form.configoption>
                    @endforeach

                    @foreach ($this->getCheckoutConfig() as $configOption)
                    @php $configOption = (object) $configOption; @endphp
                    <x-form.configoption :config="$configOption" :name="'checkoutConfig.' . $configOption->name">
                        @if ($configOption->type == 'select')
                        @foreach ($configOption->options as $configOptionValue => $configOptionValueName)
                        <option value="{{ $configOptionValue }}">{{ $configOptionValueName }}</option>
                        @endforeach
                        @elseif($configOption->type == 'radio')
                        @foreach ($configOption->options as $configOptionValue => $configOptionValueName)
                        <div class="flex items-center gap-2">
                            <input type="radio" id="{{ $configOptionValue }}" name="{{ $configOption->name }}" wire:model.live="checkoutConfig.{{ $configOption->name }}" value="{{ $configOptionValue }}" />
                            <label for="{{ $configOptionValue }}">{{ $configOptionValueName }}</label>
                        </div>
                        @endforeach
                        @endif
                    </x-form.configoption>
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        <aside class="panel-card summary-card">
            <h2>{{ __('product.order_summary') }}</h2>
            <dl>
                @if ($total->total_tax > 0)
                <div>
                    <dt>{{ __('invoices.subtotal') }}</dt>
                    <dd>{{ $total->format($total->subtotal) }}</dd>
                </div>
                <div>
                    <dt>{{ \App\Classes\Settings::tax()->name }} ({{ \App\Classes\Settings::tax()->rate }}%)</dt>
                    <dd>{{ $total->formatted->total_tax }}</dd>
                </div>
                @endif
                <div class="total">
                    <dt>{{ __('product.total_today') }}</dt>
                    <dd>{{ $total }}</dd>
                </div>
                @if ($total->setup_fee > 0 && $plan->type == 'recurring')
                <div>
                    <dt>{{ __('product.then_after_x', ['time' => $plan->billing_period . ' ' . trans_choice(__('services.billing_cycles.' . $plan->billing_unit), $plan->billing_period)]) }}</dt>
                    <dd>{{ $total->format($total->price) }}</dd>
                </div>
                @endif
            </dl>
            <p>All prices are exclusive of applicable taxes.</p>
            @if (($product->stock > 0 || !$product->stock) && $product->price()->available)
            <div>
                <x-button.primary wire:click="checkout" wire:loading.attr="disabled">
                    <x-loading target="checkout" />
                    <div wire:loading.remove wire:target="checkout">{{ __('product.checkout') }}</div>
                </x-button.primary>
            </div>
            @endif
        </aside>
    </div>
    </main>
</div>
