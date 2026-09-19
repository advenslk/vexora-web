<div class="container mt-14 billing-plain">
    <h1 class="sr-only">Cart</h1>

    <div class="flex flex-col md:grid md:grid-cols-4 gap-6">
        <div class="flex flex-col col-span-3 gap-4">
            @if (Cart::items()->count() === 0)
            <div class="billing-empty bg-background-secondary rounded-md border border-neutral">
                <x-ri-shopping-bag-4-fill class="size-6 text-primary" />
                <h2>{{ __('product.empty_cart') }}</h2>
                <a href="{{ route('home') }}#plans" wire:navigate>
                    <x-button.primary class="h-fit !w-fit">View Plans</x-button.primary>
                </a>
            </div>
            @endif
            @foreach (Cart::items() as $item)
            @php
                $cartProductContext = strtolower(implode(' ', array_filter([
                    $item->product->name ?? '',
                    $item->product->category->name ?? '',
                    $item->product->category->slug ?? '',
                ])));

                $cartItemBackground = str_contains($cartProductContext, 'bot')
                    ? asset('dezerx/banners/node.webp')
                    : asset('dezerx/banners/minecraft-banners.webp');
            @endphp
            <div class="billing-item billing-item--media bg-background-secondary rounded-md border border-neutral" style="--billing-bg: url('{{ $cartItemBackground }}');">
                <div class="min-w-0">
                    <h2>{{ $item->product->name }}</h2>
                    <p>
                        @foreach ($item->config_options as $option)
                        {{ $option['option_name'] }}: {{ $option['value_name'] }}<br>
                        @endforeach
                    </p>
                </div>
                <div class="billing-item-side">
                    <h3>
                        {{ $item->price->format($item->price->total * $item->quantity) }} @if ($item->quantity > 1)
                        <span>({{ $item->price }} each)</span>
                        @endif
                    </h3>
                    <div class="billing-actions">
                        @if ($item->product->allow_quantity == 'combined')
                        <div class="billing-quantity">
                            <x-button.secondary
                                wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                class="h-full !w-fit">
                                -
                            </x-button.secondary>
                            <x-form.input class="h-10 text-center" disabled divClass="!mt-0 !w-14" value="{{ $item->quantity }}" name="quantity" />
                            <x-button.secondary
                                wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }});"
                                class="h-full !w-fit">
                                +
                            </x-button.secondary>
                        </div>
                        @endif
                        <a href="{{ route('products.checkout', [$item->product->category, $item->product, 'edit' => $item->id]) }}"
                            wire:navigate>
                            <x-button.secondary class="h-fit w-fit">
                                {{ __('product.edit') }}
                            </x-button.secondary>
                        </a>
                        <x-button.danger wire:click="removeProduct({{ $item->id }})" class="h-fit !w-fit">
                            <x-loading target="removeProduct({{ $item->id }})" />
                            <div wire:loading.remove wire:target="removeProduct({{ $item->id }})">
                                {{ __('product.remove') }}
                            </div>
                        </x-button.danger>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex flex-col gap-4">
            @if (Cart::items()->count() > 0)
            <aside class="billing-summary bg-background-secondary rounded-md border border-neutral">
                <div class="billing-summary-head">
                    <span>Secure checkout</span>
                    <h2>{{ __('product.order_summary') }}</h2>
                </div>
                <div class="billing-coupon">
                    @if(!$coupon)
                    <x-form.input wire:model="coupon" name="coupon" label="Coupon" />
                    <x-button.primary wire:click="applyCoupon" class="h-fit !w-fit mb-0.5" wire:loading.attr="disabled">
                        <x-loading target="applyCoupon" />
                        <div wire:loading.remove wire:target="applyCoupon">
                            {{ __('product.apply') }}
                        </div>
                    </x-button.primary>
                    @else
                    <div class="flex justify-between items-center w-full">
                        <h4 class="text-center w-full">{{ $coupon->code }}</h4>
                        <x-button.secondary wire:click="removeCoupon" class="h-fit !w-fit">
                            {{ __('product.remove') }}
                        </x-button.secondary>
                    </div>
                    @endif
                </div>

                <div class="billing-totals">
                    <div>
                        <span>{{ __('invoices.subtotal') }}</span>
                        <strong>{{ $total->format($total->subtotal) }}</strong>
                    </div>
                @if ($total->tax > 0)
                    <div>
                        <span>{{ \App\Classes\Settings::tax()->name }} ({{ \App\Classes\Settings::tax()->rate }}%)</span>
                        <strong>{{ $total->format($total->tax) }}</strong>
                    </div>
                @endif
                    <div class="billing-total">
                        <span>{{ __('invoices.total') }}</span>
                        <strong>{{ $total->format($total->total) }}</strong>
                    </div>
                </div>

                <p class="billing-tax-note">All prices are exclusive of applicable taxes.</p>

                <div class="flex flex-col gap-2 w-full col-span-1">
                    @if(config('settings.tos'))
                    <x-form.checkbox wire:model="tos" name="tos">
                        {{ __('product.tos') }}
                        <a href="{{ config('settings.tos') }}" target="_blank" class="text-primary hover:text-primary/80">
                            {{ __('product.tos_link') }}
                        </a>
                    </x-form.checkbox>
                    @endif

                    <div class="flex flex-row justify-end gap-2">
                        <x-button.primary wire:click="checkout" class="h-fit" wire:loading.attr="disabled">
                            <x-loading target="checkout" />
                            <div wire:loading.remove wire:target="checkout">
                                {{ __('product.checkout') }}
                            </div>
                        </x-button.primary>
                    </div>
                </div>
            </aside>
            @endif
        </div>
    </div>
</div>
