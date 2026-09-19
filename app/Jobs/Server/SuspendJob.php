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

class SuspendJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 3;
    public $backoff = [10, 30, 60];
    public $uniqueFor = 600;

    public $afterCommit = true;

    public function __construct(public Service $service, public $sendNotification = true) {}

    public function uniqueId(): string
    {
        return 'service-suspend:' . $this->service->getKey();
    }

    public function middleware(): array
    {
        return [
            (new WithoutOverlapping($this->uniqueId()))->expireAfter($this->timeout + 60),
        ];
    }

    public function handle(): void
    {
        $this->service->updateQuietly(['provisioning_status' => 'processing']);

        try {
            $data = ExtensionHelper::suspendServer($this->service);

            $this->service->status = Service::STATUS_SUSPENDED;
            $this->service->provisioning_status = 'completed';
            $this->service->provisioning_error = null;
            $this->service->save();

            if ($this->sendNotification) {
                NotificationHelper::serverSuspendedNotification($this->service->user, $this->service, is_array($data) ? $data : []);
            }
        } catch (Throwable $exception) {
            $this->service->updateQuietly([
                'provisioning_status' => 'failed',
                'provisioning_error' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}
