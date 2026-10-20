<?php

declare(strict_types=1);

namespace App\Support;

use App\User;
use Illuminate\Contracts\Session\Session;

/**
 * Funnel events raised on the server and sent to Google Analytics (gtag) on the next rendered page.
 *
 * Events wait in the session until a page with the main layout renders, so ones raised by
 * redirects and JSON requests (offline sync, the landing-page signup) are still delivered once.
 */
final readonly class Analytics
{
    private const string KEY = 'analytics.events';

    public function __construct(private Session $session) {}

    /**
     * @param array<string, scalar> $params
     */
    public function track(string $event, array $params = []): void
    {
        $this->session->push(self::KEY, ['name' => $event, 'params' => $params]);
    }

    public function entryCreated(User $user, string $source): void
    {
        $this->track('entry_created', [
            'source' => $source,
            'first_entry' => $user->diaries()->count() === 1,
        ]);
    }

    /**
     * @return list<array{name: string, params: array<string, scalar>}>
     */
    public function pull(): array
    {
        $events = [];

        // Sessions from before the gtag switch may still hold the old dataLayer shape; drop those.
        foreach ((array) $this->session->pull(self::KEY, []) as $event) {
            if (is_array($event) && is_string($event['name'] ?? null) && is_array($event['params'] ?? null)) {
                /** @var array<string, scalar> $params */
                $params = $event['params'];
                $events[] = ['name' => $event['name'], 'params' => $params];
            }
        }

        return $events;
    }
}
