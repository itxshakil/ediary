<?php

declare(strict_types=1);

namespace App\Support;

use DateTimeZone;

final class Timezone
{
    /**
     * The browser-reported timezone, or null when it is missing or not a real zone.
     * Never worth failing a signup or sign-in over, so bad input is dropped instead of rejected.
     */
    public static function fromBrowser(mixed $value): ?string
    {
        return is_string($value) && in_array($value, DateTimeZone::listIdentifiers(DateTimeZone::ALL_WITH_BC), strict: true)
            ? $value
            : null;
    }
}
