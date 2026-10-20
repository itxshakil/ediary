<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\User;
use Illuminate\Support\Arr;
use RuntimeException;

/**
 * A friendly public handle for new accounts, such as "quiet-river-4821".
 *
 * Usernames show up in profile links, so they are never derived from the email address;
 * people can pick their own later in Settings.
 */
final class GenerateUsernameAction
{
    private const array ADJECTIVES = ['quiet', 'gentle', 'bright', 'calm', 'golden', 'misty', 'sunny', 'silver', 'brave', 'kind', 'cozy', 'lucky', 'swift', 'wise', 'still'];

    private const array NOUNS = ['river', 'meadow', 'maple', 'harbor', 'willow', 'sparrow', 'comet', 'lantern', 'pebble', 'ember', 'cedar', 'orchid', 'robin', 'tide', 'grove'];

    private const int ATTEMPTS = 20;

    public function execute(): string
    {
        for ($attempt = 0; $attempt < self::ATTEMPTS; $attempt++) {
            $username = sprintf('%s-%s-%04d', Arr::random(self::ADJECTIVES), Arr::random(self::NOUNS), random_int(0, 9999));

            if (! User::query()->where('username', $username)->exists()) {
                return $username;
            }
        }

        throw new RuntimeException('Could not find a free username.');
    }
}
