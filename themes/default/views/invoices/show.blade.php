<div class="vexora-shell">
    <div @if ($checkPayment) wire:poll.5s="checkPaymentStatus" @endif>
        @if ($this->pay || $showPayModal)
        @include('invoices.partials.payment-modal')
        @endif

        <div class="flex justify-end">
            <div class="max-w-[220px] w-full text-right">
                <button type="button" class="vexora-link text-sm font-semibold underline underline-offset-4" wire:click="downloadPDF">
                    <span wire:loading wire:target="downloadPDF">
                        <x-ri-loader-5-fill class="size-6 animate-spin" />
                    </span>
                    <span wire:loading.remove wire:target="downloadPDF">
                        {{ __('invoices.download_pdf') }}
                    </span>
                </button>
            </div>
        </div>

        <div class="vexora-card mt-4 p-5 sm:p-8 lg:p-10">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                <div>
                    <span class="vexora-kicker">Vexora Cloud billing</span>
                    <h1 class="mt-3 text-2xl font-bold sm:text-3xl">
                {{ !$invoice->number && config('settings.invoice_proforma', false) ? __('invoices.proforma_invoice', ['id'
            => $invoice->id]) : __('invoices.invoice', ['id' => $invoice->number]) }}
                    </h1>
                </div>
                <span class="vexora-badge w-fit
                    @if ($invoice->status == 'paid') text-success
                    @elseif($invoice->status == 'cancelled') text-info
                    @else text-warning
                    @endif">
                    {{ ucfirst($invoice->status) }}
                </span>
            </div>
            <div class="sm:flex justify-between pr-4 pt-4">
                <div class="mt-4 sm:mt-0">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-base/55">{{ __('invoices.issued_to') }}</p>
                    <p>{{ $invoice->user_name }}</p>
                    @foreach($invoice->user_properties as $property)
                    <p>{{ $property }}</p>
                    @endforeach
                </div>
                <div class="mt-4 sm:mt-0 sm:text-right">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-base/55">{{ __('invoices.bill_to') }}</p>
                    <p>{!! nl2br(e($invoice->bill_to)) !!}</p>
                </div>
            </div>
            <div class="sm:flex justify-between pr-4 pt-4 mt-6">
                <div class="">
                    <p class="text-base">{{ !$invoice->number && config('settings.invoice_proforma', false) ?
                    __('invoices.proforma_invoice_date') : __('invoices.invoice_date') }}: {{
                    $invoice->created_at->format('d M Y') }}</p>
                    @if($invoice->due_at)
                    <p class="text-base">{{ __('invoices.due_date') }}: {{ $invoice->due_at->format('d M Y') }}</p>
                    @endif
                    @if($invoice->number)
                    <p class="text-base">{{ __('invoices.invoice_no')}}: {{ $invoice->number }}</p>
                    @endif
                </div>
                <div class="max-w-[300px] w-full">
                    @if ($invoice->status == 'paid')
                    <div class="vexora-badge mt-6 justify-center text-success">
                        {{ __('invoices.paid') }}
                    </div>
                    @elseif ($invoice->status == 'pending')
                    @if($checkPayment || $invoice->transactions->where('status', \App\Enums\InvoiceTransactionStatus::Processing)->where('created_at', '>=', now()->subDays(1))->count() > 0)
                    <div class="mb-6 flex items-center justify-center text-center text-lg text-warning">
                        {{ __('invoices.payment_processing') }}
                        <x-ri-loader-5-fill aria-hidden="true" class="size-6 ms-2 fill-yellow-600 animate-spin" />
                    </div>
                    @else
                    <div class="mb-6 text-center text-lg">
                        @if($invoice->transactions->where('status', \App\Enums\InvoiceTransactionStatus::Processing)->count() > 0)
                        <span class="text-yellow-500">{{ __('invoices.payment_processing') }}</span>
                        <p class="text-sm">{{ __('invoices.duplicate_payment') }}</p>
                        @else
                        <span class="text-yellow-500">{{ __('invoices.payment_pending') }}</span>
                        @endif
                    </div>
                    <x-button.primary wire:click="$set('showPayModal', true)" class="mt-2" wire:loading.attr="disabled"
                        wire:target="$set('showPayModal')">
                        <span wire:loading wire:target="pay">Processing...</span>
                        <span wire:loading.remove wire:target="pay">Pay</span>
                    </x-button.primary>
                    @endif
                    @endif
                </div>
            </div>

            <div class="mt-12 overflow-x-auto rounded-lg border border-neutral/70">
                <table class="vexora-table">
                    <thead class="vexora-table-head">
                        <tr>
                            <th scope="col"
                                class="vexora-table-cell">
                                {{ __('invoices.item') }}
                            </th>
                            <th scope="col" class="vexora-table-cell">
                                {{ __('invoices.price') }}
                            </th>
                            <th scope="col" class="vexora-table-cell">
                                {{ __('invoices.quantity') }}
                            </th>
                            <th scope="col"
                                class="vexora-table-cell">
                                {{ __('invoices.total') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                        <tr>
                            <td class="vexora-table-cell whitespace-nowrap">
                                @if(in_array($item->reference_type, ['App\Models\Service', 'App\Models\ServiceUpgrade']))
                                <a href="{{ route('services.show', $item->reference_type == 'App\Models\Service' ? $item->reference_id : $item->reference->service_id) }}"
                                    class="hover:underline underline-offset-2">{{ $item->description }}
                                </a>
                                @else
                                {{ $item->description }}
                                @endif
                            </td>
                            <td class="vexora-table-cell whitespace-nowrap">{{ $item->formattedPrice }}
                            </td>
                            <td class="vexora-table-cell whitespace-nowrap">{{ $item->quantity }}</td>
                            <td class="vexora-table-cell whitespace-nowrap font-semibold">{{ $item->formattedTotal }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="space-y-3 sm:text-right sm:ml-auto sm:w-72 mt-10">
                @if ($invoice->formattedTotal->tax > 0)
                <div class="flex justify-between">
                    <div class="text-sm font-medium uppercase text-base/55">{{ __('invoices.subtotal') }}
                    </div>
                    <div class="text-base font-medium text-base">
                        {{ $invoice->formattedTotal->format($invoice->formattedTotal->subtotal) }}
                    </div>
                </div>
                <div class="flex justify-between">
                    <div class="text-sm font-medium uppercase text-base/55">
                        {{ $invoice->tax->name }} ({{ $invoice->tax->rate }}%)
                    </div>
                    <div class="text-base font-medium text-base">
                        {{ $invoice->formattedTotal->formatted->tax }}
                    </div>
                </div>
                @endif
                <div class="flex justify-between">
                    <div class="text-base font-semibold uppercase text-base">Total</div>
                    <div class="text-base font-bold text-primary">
                        {{ $invoice->formattedTotal }}
                    </div>
                </div>
            </div>

            @if ($invoice->transactions->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-2xl font-bold">{{ __('invoices.transactions') }}</h2>
                <div class="mt-4 overflow-x-auto rounded-lg border border-neutral/70">
                    <table class="vexora-table">
                        <thead class="vexora-table-head">
                            <tr>
                                <th scope="col"
                                    class="vexora-table-cell">
                                    {{ __('invoices.date') }}
                                </th>
                                <th scope="col" class="vexora-table-cell">
                                    {{ __('invoices.transaction_id') }}
                                </th>
                                <th scope="col" class="vexora-table-cell">
                                    {{ __('invoices.gateway') }}
                                </th>
                                <th scope="col" class="vexora-table-cell">
                                    {{ __('invoices.amount') }}
                                </th>
                                <th scope="col"
                                    class="vexora-table-cell">
                                    {{ __('invoices.status') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->transactions->sortByDesc('created_at') as $transaction)
                            <tr>
                                <td class="vexora-table-cell whitespace-nowrap">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="vexora-table-cell whitespace-nowrap">{{ $transaction->transaction_id }}
                                </td>
                                <td class="vexora-table-cell whitespace-nowrap">
                                    @if($transaction->is_credit_transaction)
                                    {{ __('invoices.paid_with_credits') }}
                                    @else
                                    {{ $transaction->gateway?->name }}
                                    @endif
                                </td>
                                <td class="vexora-table-cell whitespace-nowrap">{{ $transaction->formattedAmount }}
                                </td>
                                <td class="vexora-table-cell whitespace-nowrap">
                                    @if($transaction->status == \App\Enums\InvoiceTransactionStatus::Succeeded)
                                    <span class="text-green-600 font-semibold">{{
                                    __('invoices.transaction_statuses.succeeded') }}</span>
                                    @elseif($transaction->status == \App\Enums\InvoiceTransactionStatus::Processing)
                                    <span class="text-yellow-600 font-semibold flex items-center">
                                        {{ __('invoices.transaction_statuses.processing') }}
                                        <x-ri-loader-5-fill aria-hidden="true"
                                            class="size-6 me-2 fill-yellow-600 animate-spin" />
                                    </span>
                                    @elseif($transaction->status == \App\Enums\InvoiceTransactionStatus::Failed)
                                    <span class="text-red-600 font-semibold">{{ __('invoices.transaction_statuses.failed')
                                    }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>

    </div>
</div>
