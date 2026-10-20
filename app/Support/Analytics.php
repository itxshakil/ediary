<?php

declare(strict_types=1);

namespace App\Support;

use App\User;
use Illuminate\Contracts\Session\Session;

/**
 * Funnel events raised on the server and handed to GTM's dataLayer on the next rendered page.
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
        $this->session->push(self::KEY, ['event' => $event, ...$params]);
    }

    public function entryCreated(User $user, string $source): void
    {
        $this->track('entry_created', [
            'source' => $source,
            'first_entry' => $user->diaries()->count() === 1,
        ]);
    }

    /**
     * @return list<array<string, scalar>>
     */
    public function pull(): array
    {
        return $this->session->pull(self::KEY, []);
    }
}
