<?php

declare(strict_types=1);

namespace App\Support;

final class TagList
{
    /**
     * Tag names from the comma-separated text the entry forms send.
     *
     * @return list<string>
     */
    public static function parse(mixed $rawTags): array
    {
        if (! is_string($rawTags) || mb_trim($rawTags) === '') {
            return [];
        }

        return array_values(array_filter(
            array_map(mb_trim(...), explode(',', $rawTags)),
            static fn (string $tag): bool => $tag !== '',
        ));
    }
}
