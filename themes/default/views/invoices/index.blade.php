<div class="vexora-shell">
    <x-navigation.breadcrumb />
    <div class="mt-5">
        <h1 class="text-3xl font-bold sm:text-4xl">{{ __('navigation.invoices') }}</h1>
        <p class="mt-2 text-base/65">Review invoices, payment status, and Vexora Cloud billing history.</p>
    </div>

    <div class="mt-8 grid gap-4">
        @forelse ($invoices as $invoice)
        <a href="{{ route('invoices.show', $invoice) }}" wire:navigate class="vexora-card vexora-card-hover block p-5">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <div class="flex min-w-0 items-start gap-4">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-md bg-primary/10 text-primary">
                        <x-ri-bill-line class="size-6" />
                    </div>
                    <div class="min-w-0">
                        <h2 class="truncate text-xl font-semibold">{{ !$invoice->number && config('settings.invoice_proforma', false) ? __('invoices.proforma_invoice', ['id' => $invoice->id]) : __('invoices.invoice', ['id' => $invoice->number]) }}</h2>
                        @foreach ($invoice->items as $item)
                        <p class="mt-1 text-sm text-base/55">{{ $item->description }} · {{ __('invoices.invoice_date')}}: {{ $invoice->created_at->format('d M Y') }}</p>
                        @endforeach
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-3">
                    <span class="font-bold text-primary">{{ $invoice->formattedTotal }}</span>
                    <span class="vexora-badge
                        @if ($invoice->status == 'paid') text-success
                        @elseif($invoice->status == 'cancelled') text-info
                        @else text-warning
                        @endif">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </div>
            </div>
        </a>
        @empty
        <div class="vexora-card p-8 text-center">
            <x-ri-bill-line class="mx-auto size-10 text-base/35" />
            <p class="mt-3 text-base/65">{{ __('invoices.no_invoices') }}</p>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $invoices->links() }}
    </div>
</div>
