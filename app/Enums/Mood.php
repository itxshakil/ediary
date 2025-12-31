<?php

declare(strict_types=1);

namespace App\Enums;

enum Mood: string
{
    case Happy = 'happy';
    case Sad = 'sad';
    case Calm = 'calm';
    case Angry = 'angry';
    case Anxious = 'anxious';
    case Thoughtful = 'thoughtful';
    case Tired = 'tired';
    case Excited = 'excited';
    case Neutral = 'neutral';

    /**
     * @return mixed[][]
     */
    public static function options(): array
    {
        return array_map(
            static fn (self $mood): array => [
                'value' => $mood->value,
                'label' => $mood->label(),
                'emoji' => $mood->emoji(),
                'score' => $mood->score(),
                'category' => $mood->category(),
            ],
            self::cases(),
        );
    }

    /**
     * Average mood score from a collection.
     *
     * @param iterable<self> $moods
     */
    public static function averageScore(iterable $moods): float
    {
        $scores = array_map(
            static fn (self $mood): int => $mood->score(),
            is_array($moods) ? $moods : iterator_to_array($moods),
        );

        return count($scores)
            ? round(array_sum($scores) / count($scores), 2)
            : 0;
    }

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function emoji(): string
    {
        return match ($this) {
            self::Happy => '😊',
            self::Sad => '😢',
            self::Calm => '😌',
            self::Angry => '😠',
            self::Anxious => '😰',
            self::Thoughtful => '🤔',
            self::Tired => '😴',
            self::Excited => '🤩',
            self::Neutral => '😐',
        };
    }

    /**
     * Emotional polarity score (-2 to +2).
     */
    public function score(): int
    {
        return match ($this) {
            self::Happy, self::Excited => 2,
            self::Calm => 1,
            self::Neutral, self::Thoughtful => 0,
            self::Tired => -1,
            self::Sad, self::Angry, self::Anxious => -2,
        };
    }

    public function isPositive(): bool
    {
        return $this->score() > 0;
    }

    public function isNegative(): bool
    {
        return $this->score() < 0;
    }

    public function isNeutral(): bool
    {
        return $this->score() === 0;
    }

    /**
     * Mood category (for grouping and charts).
     */
    public function category(): string
    {
        return match ($this) {
            self::Happy, self::Excited => 'positive',
            self::Calm => 'balanced',
            self::Neutral, self::Thoughtful => 'neutral',
            self::Tired, self::Sad, self::Angry, self::Anxious => 'negative',
        };
    }
}
