<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

final class Diary extends Model
{
    /** @use HasFactory<Diary> */
    use HasFactory;

    protected $fillable = ['entry'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function entry(): Attribute
    {
        return Attribute::make(get: fn ($value) => Crypt::decryptString($value), set: fn ($value): array => ['entry' => Crypt::encryptString($value)]);
    }
}
