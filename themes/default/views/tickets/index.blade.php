<div class="vexora-shell">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <x-navigation.breadcrumb />
            <h1 class="mt-5 text-3xl font-bold sm:text-4xl">{{ __('navigation.tickets') }}</h1>
            <p class="mt-2 text-base/65">Support conversations for your Vexora Cloud services.</p>
        </div>
        <x-navigation.link :href="route('tickets.create')" class="flex items-center gap-2">
            <x-ri-add-line class="size-5" />
            <span>{{ __('ticket.create_ticket') }}</span>
        </x-navigation.link>
    </div>
    <div class="mt-8 grid gap-4">
    @forelse ($tickets as $ticket)
    <a href="{{ route('tickets.show', $ticket) }}" wire:navigate>
        <div class="vexora-card vexora-card-hover p-5">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="bg-secondary/10 p-2 rounded-lg">
                        <x-ri-ticket-line class="size-5 text-secondary" />
                    </div>
                    <span class="font-medium">#{{ $ticket->id }} - {{ $ticket->subject }}</span>
                </div>
                <span class="vexora-badge @if ($ticket->status == 'open') text-success @elseif($ticket->status == 'closed') text-inactive @else text-info @endif">{{ ucfirst($ticket->status) }}</span>
            </div>
            <p class="text-base text-sm">
                {{ __('ticket.last_activity') }}
                {{ $ticket->messages()->orderBy('created_at', 'desc')->first()?->created_at->diffForHumans() }}
                {{ $ticket->department ? ' - ' . $ticket->department : '' }}
            </p>
        </div>
    </a>
    @empty
    <div class="vexora-card p-8 text-center">
        <p class="text-base text-sm">{{ __('ticket.no_tickets') }}</p>
    </div>
    @endforelse
    </div>

    <div class="mt-6">
    {{ $tickets->links() }}
    </div>
</div>
