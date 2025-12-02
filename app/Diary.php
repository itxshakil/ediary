<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Database\Factories\DiaryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

/**
 * @property Carbon $created_at
 */
final class Diary extends Model
{
    /** @use HasFactory<DiaryFactory> */
    use HasFactory;

    protected $fillable = ['entry'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return Attribute<string, string>
     */
    protected function entry(): Attribute
    {
        return Attribute::make(get: static fn (string $value) => Crypt::decryptString($value), set: fn (string $value): array => ['entry' => Crypt::encryptString($value)]);
    }
}
