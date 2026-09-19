<div class="vexora-shell">
    <x-navigation.breadcrumb />
    <div class="mt-6 grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
        @if ($product->image)
        <div class="vexora-card flex min-h-80 items-center justify-center overflow-hidden p-4">
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="max-h-[420px] w-full object-contain">
        </div>
        @endif
        <div class="vexora-card flex flex-col p-6 sm:p-8 {{ $product->image ? '' : 'lg:col-span-2' }}">
            <div class="flex flex-wrap items-center gap-2">
                @if ($product->stock === 0)
                <span class="vexora-badge text-error">{{ __('product.out_of_stock', ['product' => $product->name]) }}</span>
                @elseif($product->stock > 0)
                <span class="vexora-badge text-success">{{ __('product.in_stock') }}</span>
                @endif
                <span class="vexora-badge">Vexora Cloud</span>
            </div>
            <h1 class="mt-5 text-3xl font-bold sm:text-5xl">{{ $product->name }}</h1>
            <div class="mt-4 text-4xl font-bold text-primary">{{ $product->price()->formatted->price }}</div>
            @if($product->description)
            <article class="prose dark:prose-invert mt-6 text-base/70">
                {!! $product->description !!}
            </article>
            @endif
            <p class="mt-5 text-sm text-base/55">All prices are exclusive of applicable taxes.</p>
            <div class="mt-auto pt-8">
                @if ($product->stock !== 0 && $product->price()->available)
                <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}" wire:navigate>
                    <x-button.primary class="sm:!w-fit">{{ __('product.add_to_cart') }}</x-button.primary>
                </a>
                @else
                <x-button.secondary disabled class="sm:!w-fit">Currently unavailable</x-button.secondary>
                @endif
            </div>
        </div>
    </div>
</div>
