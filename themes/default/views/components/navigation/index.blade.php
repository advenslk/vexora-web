@php
    $categories = \Illuminate\Support\Facades\Cache::remember('vexora.navigation.categories', now()->addMinutes(5), function () {
        return \App\Models\Category::whereNull('parent_id')
            ->where(function ($query) {
                $query->whereHas('children')->orWhereHas('products', fn ($query) => $query->where('hidden', false));
            })
            ->orderBy('sort')
            ->get(['id', 'name', 'slug', 'parent_id', 'sort']);
    });

    $categoryByText = function (array $needles) use ($categories) {
        return $categories->first(function ($category) use ($needles) {
            $name = \Illuminate\Support\Str::lower($category->name . ' ' . $category->slug);
            foreach ($needles as $needle) {
                if (\Illuminate\Support\Str::contains($name, $needle)) {
                    return true;
                }
            }
            return false;
        });
    };

    $gameCategory = $categoryByText(['budget', 'game', 'minecraft']) ?? $categories->first();
    $premiumCategory = $categoryByText(['premium', 'epyc', 'amd']) ?? $gameCategory;
    $botCategory = $categoryByText(['bot', 'discord']) ?? $categories->first();
    $discordUrl = 'https://discord.gg/eRxmF3NHpf';
    $anchor = route('home') . '#plans';

    $links = [
        ['label' => 'Home', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'Game Servers', 'href' => $gameCategory ? route('category.show', ['category' => $gameCategory->slug]) : $anchor, 'active' => $gameCategory && request()->livewireUrl() === route('category.show', ['category' => $gameCategory->slug])],
        ['label' => 'Premium Hosting', 'href' => $premiumCategory ? route('category.show', ['category' => $premiumCategory->slug]) : $anchor, 'active' => $premiumCategory && request()->livewireUrl() === route('category.show', ['category' => $premiumCategory->slug])],
        ['label' => 'Bot Hosting', 'href' => $botCategory ? route('category.show', ['category' => $botCategory->slug]) : $anchor, 'active' => $botCategory && request()->livewireUrl() === route('category.show', ['category' => $botCategory->slug])],
        ['label' => 'VPS', 'href' => $discordUrl, 'active' => false, 'external' => true],
        ['label' => 'VDS', 'href' => $discordUrl, 'active' => false, 'external' => true],
        ['label' => 'Support', 'href' => route('tickets'), 'active' => request()->routeIs('tickets*'), 'condition' => !config('settings.tickets_disabled', false)],
    ];
    $links = array_values(array_filter($links, fn ($link) => $link['condition'] ?? true));
@endphp

<header
    x-data="{
        open: false,
        scrolled: false,
        init() {
            this.scrolled = window.scrollY > 12;
            window.addEventListener('scroll', () => this.scrolled = window.scrollY > 12, { passive: true });
            this.$watch('open', value => { document.documentElement.style.overflow = value ? 'hidden' : '' });
        }
    }"
    :class="{ 'scrolled': scrolled }"
    class="nav-shell"
>
    <nav class="navbar" aria-label="Main navigation">
        <a href="{{ route('home') }}" wire:navigate class="brand" aria-label="Vexora Cloud home">
            <img src="/assets/vexora-logo-new.png?v=20260912" alt="Vexora Cloud logo">
            <span>Vexora Cloud</span>
        </a>

        <div class="desktop-nav">
            @foreach ($links as $link)
                <a
                    href="{{ $link['href'] }}"
                    @if(!($link['external'] ?? false)) wire:navigate @else target="_blank" rel="noopener noreferrer" @endif
                    class="{{ $link['active'] ? 'active' : '' }}"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="nav-actions">
            <livewire:components.cart />
            @if(auth()->check())
                <livewire:components.notifications />
                <a href="{{ route('dashboard') }}" wire:navigate class="desktop-only">Dashboard</a>
                <div class="desktop-only">
                    <x-dropdown :showArrow="false">
                        <x-slot:trigger>
                            <img src="{{ auth()->user()->avatar }}" class="size-10 rounded-md border border-white/15 bg-white/10" alt="{{ auth()->user()->name }} avatar" />
                        </x-slot:trigger>
                        <x-slot:content>
                            <div class="border-b border-neutral/70 p-3">
                                <span class="block break-words text-sm font-semibold text-base">{{ auth()->user()->name }}</span>
                                <span class="block break-words text-xs text-base/60">{{ auth()->user()->email }}</span>
                            </div>
                            @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                                <x-navigation.link :href="$nav['url']" :spa="isset($nav['spa']) ? $nav['spa'] : true">
                                    {{ $nav['name'] }}
                                </x-navigation.link>
                            @endforeach
                            <livewire:auth.logout />
                        </x-slot:content>
                    </x-dropdown>
                </div>
            @else
                <a href="{{ route('login') }}" wire:navigate class="desktop-only">Login</a>
                @if(!config('settings.registration_disabled', false))
                    <a href="{{ route('register') }}" wire:navigate class="vx-button primary desktop-only">Get Started</a>
                @endif
            @endif

            <button type="button" class="menu-toggle" @click="open = !open" aria-label="Toggle menu" :aria-expanded="open.toString()">
                <x-ri-menu-line x-show="!open" class="size-5" />
                <x-ri-close-line x-show="open" x-cloak class="size-5" />
            </button>
        </div>
    </nav>

    <div x-show="open" x-cloak x-transition.opacity.duration.180ms class="mobile-drawer" @click.outside="open = false">
        @foreach ($links as $link)
            <a
                href="{{ $link['href'] }}"
                @if(!($link['external'] ?? false)) wire:navigate @else target="_blank" rel="noopener noreferrer" @endif
                @click="open = false"
                class="{{ $link['active'] ? 'active' : '' }}"
            >
                {{ $link['label'] }}
            </a>
        @endforeach

        @if(auth()->check())
            <a href="{{ route('dashboard') }}" wire:navigate @click="open = false">Dashboard</a>
            @foreach (\App\Classes\Navigation::getAccountDropdownLinks() as $nav)
                <a href="{{ $nav['url'] }}" @if($nav['spa'] ?? true) wire:navigate @endif @click="open = false">{{ $nav['name'] }}</a>
            @endforeach
            <livewire:auth.logout />
        @else
            <a href="{{ route('login') }}" wire:navigate @click="open = false">Login</a>
            @if(!config('settings.registration_disabled', false))
                <a href="{{ route('register') }}" wire:navigate @click="open = false" class="vx-button primary">Get Started</a>
            @endif
        @endif
    </div>
</header>
