<aside id="main-aside" class="vexora-aside md:flex hidden">
    <div class="vexora-aside-brand">
        <a href="{{ route('home') }}" wire:navigate class="vexora-aside-logo" aria-label="Vexora Cloud home">
            <img src="/assets/vexora-logo-new.png?v=20260912" alt="Vexora Cloud logo">
            <span>
                <strong>Vexora Cloud</strong>
                <small>Client panel</small>
            </span>
        </a>
    </div>

    <x-navigation.sidebar-links />

    @auth
        <div class="vexora-aside-user">
            <div class="vexora-aside-user-card">
                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }} avatar">
                <span>
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>{{ auth()->user()->email }}</small>
                </span>
            </div>

            <div class="vexora-aside-user-actions">
                <a href="{{ route('account') }}" wire:navigate>
                    <x-ri-user-settings-fill class="size-4" />
                    <span>Account</span>
                </a>
                @if(auth()->user()->role_id !== null)
                    <a href="{{ route('filament.admin.pages.dashboard') }}" class="vexora-admin-area-link">
                        <x-ri-shield-user-fill class="size-4" />
                        <span>Admin Area</span>
                    </a>
                @endif
            </div>
        </div>
    @endauth
</aside>

<nav class="vexora-mobile-dock" aria-label="Customer panel navigation">
    <a href="{{ route('dashboard') }}" wire:navigate class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <x-ri-dashboard-fill class="size-5" />
        <span>Dash</span>
    </a>
    <a href="{{ route('services') }}" wire:navigate class="{{ request()->routeIs('services*') ? 'active' : '' }}">
        <x-ri-archive-stack-fill class="size-5" />
        <span>Services</span>
    </a>
    <a href="{{ route('invoices') }}" wire:navigate class="{{ request()->routeIs('invoices*') ? 'active' : '' }}">
        <x-ri-receipt-fill class="size-5" />
        <span>Invoices</span>
    </a>
    @if(!config('settings.tickets_disabled', false))
        <a href="{{ route('tickets') }}" wire:navigate class="{{ request()->routeIs('tickets*') ? 'active' : '' }}">
            <x-ri-customer-service-fill class="size-5" />
            <span>Tickets</span>
        </a>
    @endif
    @auth
        @if(auth()->user()->role_id !== null)
            <a href="{{ route('filament.admin.pages.dashboard') }}">
                <x-ri-shield-user-fill class="size-5" />
                <span>Admin</span>
            </a>
        @endif
    @endauth
</nav>
