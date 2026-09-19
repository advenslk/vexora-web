<div class="grid gap-3">
    @foreach ($tickets as $ticket)
    <a href="{{ route('tickets.show', $ticket) }}" wire:navigate>
        <div class="rounded-lg border border-neutral/70 bg-background/45 p-4 transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/45">
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
    @endforeach
</div>
