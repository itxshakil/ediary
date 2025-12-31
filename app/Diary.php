<?php

declare(strict_types=1);

namespace App;

use App\Enums\Mood;
use App\Enums\Privacy;
use App\Support\Traits\HasTags;
use Carbon\Carbon;
use Database\Factories\DiaryFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

/**
 * @property Carbon $created_at
 */
final class Diary extends Model
{
    /** @use HasFactory<DiaryFactory> */
    use HasFactory;
    use HasTags;

    protected $fillable = ['entry',
        'title',
        'mood',
        'privacy',
        'is_featured',
        'allow_comments',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    protected function casts(): array
    {
        return [
            'mood' => Mood::class,
            'privacy' => Privacy::class,
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
        ];
    }

    /**
     * @return Attribute<string, string>
     */
    protected function entry(): Attribute
    {
        return Attribute::make(get: static fn (string $value) => Crypt::decryptString($value), set: fn (string $value): array => ['entry' => Crypt::encryptString($value)]);
    }

    /**
     * @param Builder<Diary> $query
     */
    #[Scope]
    protected function search(Builder $query, ?string $search = null): void
    {
        if ($search === null || mb_trim($search) === '') {
            return;
        }

        $query->where(function (Builder $query) use ($search): void {
            $keywords = explode(' ', $search);
            foreach ($keywords as $keyword) {
                $query->where('title', 'like', sprintf('%%%s%%', $keyword))
                    ->orWhere(function (Builder $query) use ($keyword): void {
                        $query->whereTag($keyword);
                    });
            }
        });

    }
}
