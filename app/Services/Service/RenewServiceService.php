<?php

namespace App\Services\Service;

use App\Jobs\Server\CreateJob;
use App\Jobs\Server\UnsuspendJob;
use App\Models\Service;

class RenewServiceService
{
    public function handle(Service $service): void
    {
        if ($service->product->server) {
            if ($service->status === Service::STATUS_SUSPENDED) {
                UnsuspendJob::dispatch($service);
                return;
            }

            if ($service->status === Service::STATUS_PENDING) {
                CreateJob::dispatch($service);
                return;
            }
        }

        $service->expires_at = $service->calculateNextDueDate();
        $service->status = Service::STATUS_ACTIVE;
        $service->save();
    }
}
