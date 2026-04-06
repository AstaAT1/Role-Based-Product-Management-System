<?php

namespace App\Services;

use App\Mail\NameOfMailer;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AdminAuthNotificationService
{
    public function sendSuccessfulAuthNotification(
        string $operation,
        string $userEmail,
        ?string $userName = null,
        ?string $ipAddress = null,
        ?CarbonInterface $occurredAt = null,
    ): void {
        $adminEmail = config('mail.admin_notify_address');

        if (blank($adminEmail)) {
            // Skip safely when the admin inbox is not configured so auth still works.
            Log::warning('Admin auth notification skipped because ADMIN_NOTIFY_EMAIL is not configured.', [
                'operation' => $operation,
                'user_email' => $userEmail,
            ]);

            return;
        }

        try {
            Mail::to($adminEmail)->send(new NameOfMailer(
                operation: $operation,
                userName: $userName,
                userEmail: $userEmail,
                occurredAt: $occurredAt ?? now(),
                ipAddress: $ipAddress,
            ));
        } catch (Throwable $exception) {
            // Log the mail failure instead of blocking a successful login/register flow.
            Log::error('Failed to send admin auth notification email.', [
                'operation' => $operation,
                'user_email' => $userEmail,
                'admin_email' => $adminEmail,
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
