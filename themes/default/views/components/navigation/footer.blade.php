@php
    $categories = \Illuminate\Support\Facades\Cache::remember('vexora.footer.categories', now()->addMinutes(5), function () {
        return \App\Models\Category::whereNull('parent_id')->orderBy('sort')->get(['id', 'name', 'slug', 'parent_id', 'sort']);
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
@endphp

<footer class="footer">
    <a href="{{ $discordUrl }}" target="_blank" rel="noopener noreferrer" class="footer-cta">
        <div>
            <h2>Join Vexora <span>Community</span></h2>
            <p>Need VPS or VDS hosting? Join Discord and create a ticket so the Vexora Cloud team can confirm availability and configuration.</p>
        </div>
        <img src="/dezerx/joinus.png" alt="Join Vexora Cloud Discord">
    </a>

    <div class="footer-grid">
        <div class="footer-about">
            <img src="/assets/vexora-logo-new.png?v=20260912" class="footer-logo" alt="Vexora Cloud logo">
            <h3>Vexora Cloud</h3>
            <p>Premium Minecraft and Discord bot hosting connected to the real Vexora Cloud billing panel.</p>
            <p class="mt-2 text-sm text-base/55">Founded by Ayush Kumar Jha.</p>
        </div>

        <div>
            <h3>Hosting</h3>
            <a href="{{ $gameCategory ? route('category.show', ['category' => $gameCategory->slug]) : route('home') . '#plans' }}" wire:navigate>Game Servers</a>
            <a href="{{ $premiumCategory ? route('category.show', ['category' => $premiumCategory->slug]) : route('home') . '#plans' }}" wire:navigate>Premium Hosting</a>
            <a href="{{ $botCategory ? route('category.show', ['category' => $botCategory->slug]) : route('home') . '#plans' }}" wire:navigate>Bot Hosting</a>
            <a href="{{ $discordUrl }}" target="_blank" rel="noopener noreferrer">VPS / VDS</a>
        </div>

        <div>
            <h3>Panel</h3>
            <a href="{{ route('dashboard') }}" wire:navigate>Dashboard</a>
            @if(!config('settings.tickets_disabled', false))
                <a href="{{ route('tickets') }}" wire:navigate>Support</a>
            @endif
            <a href="{{ route('login') }}" wire:navigate>Login</a>
            @if(!config('settings.registration_disabled', false))
                <a href="{{ route('register') }}" wire:navigate>Create Account</a>
            @endif
        </div>

        <div>
            <h3>Company</h3>
            <a href="{{ route('home') }}" wire:navigate>Home</a>
            <a href="{{ route('founder') }}" wire:navigate>Founder</a>
            <a href="{{ $discordUrl }}" target="_blank" rel="noopener noreferrer">Discord</a>
            @if(config('settings.tos'))
                <a href="{{ config('settings.tos') }}" target="_blank" rel="noopener noreferrer">Terms</a>
            @endif
            @if(config('settings.privacy_policy'))
                <a href="{{ config('settings.privacy_policy') }}" target="_blank" rel="noopener noreferrer">Privacy</a>
            @endif
        </div>
    </div>

    <div class="footer-bottom">
        <span>© {{ date('Y') }} Vexora Cloud. All rights reserved.</span>
        <span>All prices are exclusive of applicable taxes.</span>
    </div>
</footer>
