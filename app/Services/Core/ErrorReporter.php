<?php

declare(strict_types=1);

namespace App\Services\Core;

use App\Http\Middleware\RequestLogger;
use App\Mail\ExceptionOccurred;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

final class ErrorReporter
{
    public function report(Throwable $exception): void
    {
        $recipients = $this->validRecipients();
        if ($recipients === []) {
            Log::error('ErrorReporter: No valid developer emails configured.');

            return;
        }

        $key = $this->rateLimitKey($exception);

        if (Cache::add($key, true, now()->addMinutes(5)) === false) {
            return;
        }

        $payload = $this->buildPayload($exception, request());

        try {
            Mail::to($recipients)->send(new ExceptionOccurred($payload));
        } catch (Throwable $throwable) {
            Log::error('ErrorReporter: Failed to send exception email.', [
                'exception' => $throwable->getMessage(),
            ]);
        }
    }

    /**
     * @return array<int, string>
     */
    private function validRecipients(): array
    {
        $emails = config('mail.support.address', []);

        if (is_string($emails)) {
            $emails = explode(',', $emails);
        }

        if (! is_array($emails)) {
            return [];
        }

        return array_values(array_filter(
            array_map(static fn ($email): string => mb_trim((string) $email), $emails),
            static fn (string $email) => filter_var($email, FILTER_VALIDATE_EMAIL),
        ));
    }

    private function rateLimitKey(Throwable $exception): string
    {
        $hash = md5($exception->getMessage() . $exception->getFile());
        $hash = md5($hash . microtime());

        return 'exception:' . $hash;
    }

    /**
     * @return array<string, mixed>
     */
    private function buildPayload(Throwable $exception, ?Request $request): array
    {
        return [
            'message_short' => class_basename($exception),
            'message' => $exception->getMessage(),
            'file' => basename($exception->getFile()),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'timestamp' => now()->toDateTimeString(),
            'url' => $request?->fullUrl(),
            'method' => $request?->method(),
            'payload' => $this->sanitizePayload($request?->all() ?? []),
            'user' => $request?->user()?->getAuthIdentifier(),
            'environment' => app()->environment(),
            'request_id' => $request?->header(RequestLogger::X_REQUEST_ID) ?? 'N/A',
            'ip' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ];
    }

    private function sanitizePayload(array $payload): array
    {
        $fields = config('error_mail.sensitive_fields', []);

        foreach ($fields as $field) {
            Arr::set($payload, $field, '****');
        }

        return $payload;
    }
}
