<?php

namespace App\Observers;

use App\Events\Invoice as InvoiceEvent;
use App\Jobs\Invoice\ProcessPaidInvoiceJob;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InvoiceObserver
{
    public function creating(Invoice $invoice): void
    {
        event(new InvoiceEvent\Creating($invoice));
    }

    public function created(Invoice $invoice): void
    {
        event(new InvoiceEvent\Created($invoice));

        $sendEmail = $invoice->send_create_email;

        dispatch(function () use ($invoice, $sendEmail) {
            event(new InvoiceEvent\Finalized($invoice, $sendEmail));
        })->afterResponse();
    }

    public function updating(Invoice $invoice): void
    {
        event(new InvoiceEvent\Updating($invoice));
    }

    public function updated(Invoice $invoice): void
    {
        if ($invoice->isDirty('status') && $invoice->status == 'paid') {
            DB::afterCommit(function () use ($invoice) {
                ProcessPaidInvoiceJob::dispatch($invoice);
                event(new InvoiceEvent\Paid($invoice));
            });
        }

        event(new InvoiceEvent\Updated($invoice));
    }

    public function deleted(Invoice $invoice): void
    {
        event(new InvoiceEvent\Deleted($invoice));
    }
}
