<?php

namespace App\Listeners;

use App\Services\AdminAuthNotificationService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;

class SendAdminAuthNotification
{
    public function __construct(
        private readonly AdminAuthNotificationService $notificationService,
    ) {
    }

    public function handle(Registered|Login $event): void
    {
        $operation = $event instanceof Registered ? 'Register' : 'Login';

        $this->notificationService->sendSuccessfulAuthNotification(
            operation: $operation,
            userName: data_get($event->user, 'name'),
            userEmail: (string) data_get($event->user, 'email'),
            ipAddress: request()->ip(),
        );
    }
}
