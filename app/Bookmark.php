<?php

declare(strict_types=1);

namespace App;

use Database\Factories\BookmarkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Bookmark extends Model
{
    /** @use HasFactory<BookmarkFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'diary_id',
    ];

    public function diary(): BelongsTo
    {
        return $this->belongsTo(Diary::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
