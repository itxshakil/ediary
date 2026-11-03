<?php

declare(strict_types=1);

namespace App;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'diary_id',
    'user_id',
    'comment',
])]
final class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function diary(): BelongsTo
    {
        return $this->belongsTo(Diary::class);
    }
}
