<?php

namespace App\Jobs\Invoice;

use App\Models\Invoice;
use App\Services\Invoice\ProcessPaidInvoiceService;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Middleware\WithoutOverlapping;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProcessPaidInvoiceJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 3;
    public $backoff = [10, 30, 60];
    public $uniqueFor = 600;
    public $afterCommit = true;

    public function __construct(public Invoice $invoice) {}

    public function uniqueId(): string
    {
        return 'invoice-paid-processing:' . $this->invoice->getKey();
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping($this->uniqueId()))->expireAfter($this->timeout + 60),
        ];
    }

    public function handle(ProcessPaidInvoiceService $processor): void
    {
        $processor->handle($this->invoice);
    }

    public function failed(Throwable $exception): void
    {
        report($exception);
    }
}
