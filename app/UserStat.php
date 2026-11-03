<?php

declare(strict_types=1);

namespace App;

use Database\Factories\UserStatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'current_streak',
    'longest_streak',
    'last_entry_date',
    'total_entries',
    'total_words',
    'freeze_cards',
])]
final class UserStat extends Model
{
    /** @use HasFactory<UserStatFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_entry_date' => 'date',
            'current_streak' => 'integer',
            'longest_streak' => 'integer',
            'total_entries' => 'integer',
            'total_words' => 'integer',
            'freeze_cards' => 'integer',
        ];
    }
}
