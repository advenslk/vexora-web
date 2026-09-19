<?php

namespace App\Services\Invoice;

use App\Models\Credit;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\ServiceUpgrade;
use App\Services\Service\RenewServiceService;
use App\Services\ServiceUpgrade\ServiceUpgradeService;
use Illuminate\Support\Facades\DB;

class ProcessPaidInvoiceService
{
    public function handle(Invoice $invoice): void
    {
        DB::transaction(function () use ($invoice): void {
            $invoice = Invoice::query()
                ->lockForUpdate()
                ->with(['items.reference', 'user'])
                ->findOrFail($invoice->getKey());

            if ($invoice->paid_processed_at !== null) {
                return;
            }

            $invoice->items->each(function ($item) use ($invoice): void {
                if ($item->reference_type === Service::class) {
                    $service = $item->reference;
                    if ($service instanceof Service) {
                        (new RenewServiceService)->handle($service);
                    }

                    return;
                }

                if ($item->reference_type === ServiceUpgrade::class) {
                    $serviceUpgrade = $item->reference;
                    if ($serviceUpgrade instanceof ServiceUpgrade && $serviceUpgrade->status === ServiceUpgrade::STATUS_PENDING) {
                        (new ServiceUpgradeService)->handle($serviceUpgrade);
                    }

                    return;
                }

                if ($item->reference_type === Credit::class) {
                    $credit = $invoice->user->credits()
                        ->where('currency_code', $invoice->currency_code)
                        ->lockForUpdate()
                        ->first();

                    if ($credit) {
                        $credit->increment('amount', $item->price);
                    } else {
                        $invoice->user->credits()->create([
                            'currency_code' => $invoice->currency_code,
                            'amount' => $item->price,
                        ]);
                    }
                }
            });

            $invoice->forceFill(['paid_processed_at' => now()])->saveQuietly();
        });
    }
}
