<?php

namespace App\Jobs\Server;

use App\Helpers\ExtensionHelper;
use App\Helpers\NotificationHelper;
use App\Models\Service;
use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Middleware\WithoutOverlapping;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TerminateJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;

    public $tries = 3;

    public $backoff = [10, 30, 60];

    public $uniqueFor = 600;

    /**
     * Create a new job instance.
     */
    public function __construct(public Service $service, public $sendNotification = true) {}

    public function uniqueId(): string
    {
        return 'service-terminate:' . $this->service->getKey();
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping($this->uniqueId()))->expireAfter($this->timeout + 60),
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->service->updateQuietly(['provisioning_status' => 'processing']);

        try {
            $data = [];
            try {
                $data = ExtensionHelper::terminateServer($this->service);
            } catch (Throwable $e) {
                if ($e->getMessage() !== 'No server assigned to this product') {
                    throw $e;
                }
            }

            $this->service->updateQuietly([
                'status' => Service::STATUS_CANCELLED,
                'provisioning_status' => 'completed',
                'provisioning_error' => null,
            ]);

            if ($this->service->product->stock !== null) {
                $this->service->product->increment('stock', $this->service->quantity);
            }

            $this->service->invoices()->where('status', 'pending')->update(['status' => 'cancelled']);

            if ($this->sendNotification) {
                NotificationHelper::serverTerminatedNotification($this->service->user, $this->service, is_array($data) ? $data : []);
            }
        } catch (Throwable $exception) {
            $this->service->updateQuietly([
                'provisioning_status' => 'failed',
                'provisioning_error' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    public function failed(Throwable $exception): void
    {
        $this->service->updateQuietly([
            'provisioning_status' => 'failed',
            'provisioning_error' => $exception->getMessage(),
        ]);
    }
}
