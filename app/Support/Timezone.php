<?php

declare(strict_types=1);

namespace App\Support;

use DateTimeZone;
use Exception;

final class Timezone
{
    /**
     * Every zone a writer can pick, backward-compatible names included.
     * Linux system tzdata also lists files like "leapseconds" that DateTimeZone cannot open, so those are dropped.
     *
     * @return list<string>
     */
    public static function identifiers(): array
    {
        return once(static fn (): array => array_values(array_filter(
            DateTimeZone::listIdentifiers(DateTimeZone::ALL_WITH_BC),
            static function (string $zone): bool {
                try {
                    new DateTimeZone($zone);

                    return true;
                } catch (Exception) {
                    return false;
                }
            },
        )));
    }

    /**
     * The browser-reported timezone, or null when it is missing or not a real zone.
     * Never worth failing a signup or sign-in over, so bad input is dropped instead of rejected.
     */
    public static function fromBrowser(mixed $value): ?string
    {
        return is_string($value) && in_array($value, self::identifiers(), strict: true)
            ? $value
            : null;
    }
}
