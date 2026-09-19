<div class="grid gap-3">
    @forelse ($invoices as $invoice)
    <a href="{{ route('invoices.show', $invoice) }}" wire:navigate class="block rounded-lg border border-neutral/70 bg-background/45 p-4 transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/45">
        <div class="flex items-start justify-between gap-4">
            <div class="flex min-w-0 items-start gap-3">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-md bg-primary/10 text-primary">
                    <x-ri-bill-line class="size-5" />
                </div>
                <div class="min-w-0">
                    <span class="block truncate font-semibold">{{ !$invoice->number && config('settings.invoice_proforma', false) ? __('invoices.proforma_invoice', ['id' => $invoice->id]) : __('invoices.invoice', ['id' => $invoice->number]) }}</span>
                    <p class="mt-1 text-sm text-base/55">{{ $invoice->formattedTotal }} · {{ $invoice->created_at->format('d M Y') }}</p>
                </div>
            </div>
            <span class="vexora-badge shrink-0
                @if ($invoice->status == 'paid') text-success
                @elseif($invoice->status == 'cancelled') text-info
                @else text-warning
                @endif">
                {{ ucfirst($invoice->status) }}
            </span>
        </div>
    </a>
    @empty
    <div class="rounded-lg border border-dashed border-neutral/70 bg-background/35 p-6 text-center">
        <x-ri-bill-line class="mx-auto size-8 text-base/35" />
        <p class="mt-3 text-sm text-base/60">{{ __('invoices.no_invoices') }}</p>
    </div>
    @endforelse
</div>
