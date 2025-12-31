<?php

declare(strict_types=1);

namespace App;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Notifications\Notifiable;
use Override;

/**
 * @property Profile|null $profile
 * @property string       $email
 * @property string       $password
 * @property string       $username
 */
final class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;
    use VerifiesEmails;

    protected $fillable = [
        'username', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['profile'];

    public static function isUsernameTaken(string $username): bool
    {
        return self::where('username', $username)->exists();
    }

    /**
     * @return HasMany<Diary, $this>
     */
    public function diaries(): HasMany
    {
        return $this->hasMany(Diary::class);
    }

    /**
     * @return HasOne<Profile, $this>
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class)->withCount('follower')->withDefault();
    }

    /**
     * @return BelongsToMany<Profile, $this, Pivot>
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class);
    }

    #[Override]
    protected static function booted(): void
    {
        self::created(static function (self $user): void {
            $user->profile()->create(['name' => $user->username]);
        });
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * @param Builder<User> $query
     */
    #[Scope]
    protected function search(Builder $query, string $term): void
    {
        $query->where('username', 'like', sprintf('%%%s%%', $term))
            ->orWhere('email', 'like', sprintf('%%%s%%', $term));
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }
}
