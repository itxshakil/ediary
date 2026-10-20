<?php

declare(strict_types=1);

namespace App\Enums;

enum ReminderKind: string
{
    case Streak = 'streak';
    case FirstEntry = 'first_entry';
    case WinBack = 'win_back';

    public function subject(?int $streak = null): string
    {
        return match ($this) {
            self::Streak => $streak !== null && $streak > 1 ? "Keep your {$streak}-day streak going" : 'Keep your writing streak going',
            self::FirstEntry => 'Your diary is ready for its first entry',
            self::WinBack => 'A few lines tonight?',
        };
    }
}
