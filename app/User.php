<?php

declare(strict_types=1);

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Notifications\Notifiable;

/**
 * @method static where(string $string, $username)
 * @method static select(string $string, string $string1)
 * @method static search(array|string|null $query)
 * @method static create(array $array)
 *
 * @property mixed profile
 * @property mixed email
 */
final class User extends Authenticatable implements MustVerifyEmail
{
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

    public static function isUsernameTaken($username)
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

    protected static function booted()
    {
        self::created(function ($user): void {
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
}
