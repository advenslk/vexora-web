<div class="vexora-shell">
    <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
        <aside class="vexora-card h-fit p-5">
            <x-navigation.breadcrumb />
            <h1 class="mt-5 text-2xl font-bold">{{ $category->name }}</h1>
            @if($category->description)
            <article class="prose prose-sm dark:prose-invert mt-3 text-base/65">
                {!! $category->description !!}
            </article>
            @endif
            <div class="mt-6 grid gap-2">
                @foreach ($categories as $ccategory)
                <a href="{{ route('category.show', ['category' => $ccategory->slug]) }}" wire:navigate class="rounded-md px-3 py-2 text-sm font-semibold transition-colors {{ $category->id == $ccategory->id ? 'bg-primary/10 text-primary' : 'text-base/70 hover:bg-background hover:text-base' }}">
                    {{ $ccategory->name }}
                </a>
                @endforeach
            </div>
        </aside>

        <div class="grid gap-6">
            @if (count($childCategories) >= 1)
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($childCategories as $childCategory)
                <div class="vexora-card vexora-card-hover flex flex-col overflow-hidden">
                    @if ($childCategory->image)
                    <img src="{{ Storage::url($childCategory->image) }}" alt="{{ $childCategory->name }}" class="h-44 w-full object-cover">
                    @endif
                    <div class="flex grow flex-col p-5">
                        <h2 class="text-xl font-bold">{{ $childCategory->name }}</h2>
                        @if(theme('show_category_description', true))
                        <article class="prose prose-sm dark:prose-invert mt-3 text-base/65">
                            {!! $childCategory->description !!}
                        </article>
                        @endif
                        <a href="{{ route('category.show', ['category' => $childCategory->slug]) }}" wire:navigate class="mt-auto pt-5">
                            <x-button.secondary>
                                {{ __('common.button.view') }}
                                <x-ri-arrow-right-fill class="size-5" />
                            </x-button.secondary>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
                <div class="vexora-card vexora-card-hover flex flex-col overflow-hidden">
                    @if ($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-44 w-full object-cover">
                    @endif
                    <div class="flex grow flex-col p-5">
                        <div class="flex items-start justify-between gap-3">
                            <h2 class="text-xl font-bold">{{ $product->name }}</h2>
                            @if ($product->stock === 0)
                            <span class="vexora-badge text-error">Out of stock</span>
                            @elseif($product->stock > 0)
                            <span class="vexora-badge text-success">In stock</span>
                            @endif
                        </div>
                        <div class="mt-4 text-3xl font-bold">{{ $product->price()->formatted->price }}</div>
                        @if($product->description)
                        <article class="prose prose-sm dark:prose-invert mt-4 line-clamp-4 text-base/65">
                            {!! $product->description !!}
                        </article>
                        @endif
                        <div class="mt-auto flex flex-col gap-2 pt-6 sm:flex-row">
                            <a href="{{ route('products.show', ['category' => $product->category, 'product' => $product->slug]) }}" wire:navigate class="flex-1">
                                <x-button.secondary>{{ __('common.button.view') }}</x-button.secondary>
                            </a>
                            @if ($product->stock !== 0 && $product->price()->available)
                            <a href="{{ route('products.checkout', ['category' => $product->category, 'product' => $product->slug]) }}" wire:navigate class="flex-1">
                                <x-button.primary>{{ __('product.add_to_cart') }}</x-button.primary>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="vexora-card p-8 text-center sm:col-span-2 xl:col-span-3">
                    <x-ri-server-line class="mx-auto size-10 text-base/35" />
                    <p class="mt-3 text-base/65">No products are available in this category yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
