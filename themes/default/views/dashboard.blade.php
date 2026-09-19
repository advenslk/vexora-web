@php
    $user = Auth::user();
    $activeServices = $user->services()->where('status', 'active')->count();
    $unpaidInvoices = $user->invoices()->where('status', 'pending')->count();
    $openTickets = config('settings.tickets_disabled', false) ? 0 : $user->tickets()->where('status', '!=', 'closed')->count();
    $firstName = trim(explode(' ', $user->name)[0] ?? $user->name);
    $creditAmount = $user->credits()->sum('amount') ?? 0;
    $attentionCount = $unpaidInvoices + (! $user->two_factor_secret ? 1 : 0);
@endphp

<div class="vexora-dashboard-page">
    <section class="az-dashboard-hero">
        <div>
            <p class="az-greeting">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : (now()->hour < 21 ? 'evening' : 'night')) }}</p>
            <h1>Welcome back, {{ $firstName }}!</h1>
            <p>Manage your active services, invoices, tickets, and stay updated here.</p>
        </div>
        <div class="az-credit-box">
            <span>Credits</span>
            <strong>₹{{ number_format($creditAmount, 2) }}</strong>
        </div>
    </section>

    <nav class="az-quick-actions" aria-label="Dashboard quick actions">
        <a href="{{ route('home') }}#plans">
            <x-ri-server-fill class="size-5" />
            <span>Buy Server</span>
        </a>
        @if(!config('settings.tickets_disabled', false))
            <a href="{{ route('tickets') }}" wire:navigate>
                <x-ri-customer-service-2-fill class="size-5" />
                <span>Support</span>
            </a>
        @endif
        <a href="{{ route('account') }}" wire:navigate>
            <x-ri-user-settings-fill class="size-5" />
            <span>Account</span>
        </a>
        <a href="{{ route('services') }}" wire:navigate>
            <x-ri-archive-stack-fill class="size-5" />
            <span>Services</span>
        </a>
    </nav>

    @if($unpaidInvoices > 0 || ! $user->two_factor_secret)
        <section class="az-heads-up">
            <div class="az-heads-up-title">
                <span><x-ri-error-warning-fill class="size-4" /></span>
                <div>
                    <p>Heads up</p>
                    <h2>{{ $attentionCount }} {{ Str::plural('thing', $attentionCount) }} {{ $attentionCount === 1 ? 'needs' : 'need' }} a look</h2>
                </div>
            </div>

            @if($unpaidInvoices > 0)
                <a href="{{ route('invoices') }}" wire:navigate class="az-alert-row danger">
                    <span><x-ri-receipt-fill class="size-4" /></span>
                    <div>
                        <strong>{{ $unpaidInvoices }} unpaid {{ Str::plural('invoice', $unpaidInvoices) }}</strong>
                        <small>These ones are still waiting to be paid.</small>
                    </div>
                    <em>Pay now</em>
                </a>
            @endif

            @if(! $user->two_factor_secret)
                <a href="{{ route('account.security') }}" wire:navigate class="az-alert-row primary">
                    <span><x-ri-shield-keyhole-fill class="size-4" /></span>
                    <div>
                        <strong>Two factor authentication is off</strong>
                        <small>Turn it on to lock your account down properly.</small>
                    </div>
                    <em>Enable</em>
                </a>
            @endif
        </section>
    @endif

    <section class="az-metrics">
        <a href="{{ route('services') }}" wire:navigate class="az-metric-card primary">
            <x-ri-archive-stack-fill class="az-metric-bg" />
            <strong>{{ $activeServices }}</strong>
            <span>Active Services</span>
        </a>
        <a href="{{ route('invoices') }}" wire:navigate class="az-metric-card warning">
            <x-ri-receipt-fill class="az-metric-bg" />
            <strong>{{ $unpaidInvoices }}</strong>
            <span>Unpaid Invoices</span>
        </a>
        @if(!config('settings.tickets_disabled', false))
            <a href="{{ route('tickets') }}" wire:navigate class="az-metric-card success">
                <x-ri-customer-service-fill class="az-metric-bg" />
                <strong>{{ $openTickets }}</strong>
                <span>Open Tickets</span>
            </a>
        @endif
    </section>

    <section class="az-widget-grid">
        <article class="az-widget-card">
            <header>
                <div>
                    <span class="az-widget-icon primary"><x-ri-archive-stack-fill class="size-5" /></span>
                    <h2>{{ __('dashboard.active_services') }}</h2>
                </div>
                <small>{{ $activeServices }}</small>
            </header>
            <livewire:services.widget status="active" />
            <a href="{{ route('services') }}" wire:navigate class="az-view-all">View All <x-ri-arrow-right-line class="size-4" /></a>
        </article>

        <article class="az-widget-card">
            <header>
                <div>
                    <span class="az-widget-icon warning"><x-ri-receipt-fill class="size-5" /></span>
                    <h2>{{ __('dashboard.unpaid_invoices') }}</h2>
                </div>
                <small>{{ $unpaidInvoices }}</small>
            </header>
            <livewire:invoices.widget :limit="3" />
            <a href="{{ route('invoices') }}" wire:navigate class="az-view-all">View All <x-ri-arrow-right-line class="size-4" /></a>
        </article>

        @if(!config('settings.tickets_disabled', false))
            <article class="az-widget-card">
                <header>
                    <div>
                        <span class="az-widget-icon success"><x-ri-customer-service-fill class="size-5" /></span>
                        <h2>{{ __('dashboard.open_tickets') }}</h2>
                    </div>
                    <a href="{{ route('tickets.create') }}" wire:navigate class="az-add-ticket" aria-label="Create ticket">
                        <x-ri-add-fill class="size-5" />
                    </a>
                </header>
                <livewire:tickets.widget />
                <a href="{{ route('tickets') }}" wire:navigate class="az-view-all">View All <x-ri-arrow-right-line class="size-4" /></a>
            </article>
        @endif
    </section>

    {!! hook('pages.dashboard') !!}
</div>
