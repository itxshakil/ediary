<?php

declare(strict_types=1);

namespace App\Enums;

enum Privacy: string
{
    case Private = 'private';
    case Followers = 'followers';
    case Public = 'public';
    case Unlisted = 'unlisted';

    /**
     * @return mixed[][]
     */
    public static function options(): array
    {
        return array_map(
            static fn (self $privacy): array => [
                'value' => $privacy->value,
                'label' => $privacy->label(),
                'emoji' => $privacy->emoji(),
            ],
            self::cases(),
        );
    }

    public function label(): string
    {
        return match ($this) {
            self::Private => 'Private (Only Me)',
            self::Followers => 'Followers Only',
            self::Public => 'Public',
            self::Unlisted => 'Unlisted (Link Only)',
        };
    }

    public function emoji(): string
    {
        return match ($this) {
            self::Private => '🔒',
            self::Followers => '👥',
            self::Public => '🌍',
            self::Unlisted => '🔗',
        };
    }

    /**
     * Who can view this entry?
     *
     * @return Audience[]
     */
    public function audiences(): array
    {
        return match ($this) {
            self::Private => [Audience::Owner],
            self::Followers => [Audience::Owner, Audience::Followers],
            self::Public, self::Unlisted => [
                Audience::Owner,
                Audience::Followers,
                Audience::Guests,
            ],
        };
    }

    /**
     * Generic access check.
     */
    public function allows(Audience $audience): bool
    {
        return in_array($audience, $this->audiences(), true);
    }

    /**
     * Semantic helpers.
     */
    public function visibleToOwner(): bool
    {
        return $this->allows(Audience::Owner);
    }

    public function visibleToFollowers(): bool
    {
        return $this->allows(Audience::Followers);
    }

    public function visibleToGuests(): bool
    {
        return $this->allows(Audience::Guests);
    }
}
