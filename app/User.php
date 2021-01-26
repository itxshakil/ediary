<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * @method static where(string $string, $username)
 * @method static select(string $string, string $string1)
 * @method static search(array|string|null $query)
 * @method static create(array $array)
 * @property mixed profile
 * @property mixed email
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, VerifiesEmails, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['profile'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.username' => 10,
            'profiles.name' => 10,
            'profiles.bio' => 4,
        ],
        'joins' => [
            'profiles' => ['users.id', 'profiles.user_id'],
        ],
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $user->profile()->create(['name' => $user->username]);
        });
    }

    public function diaries(): HasMany
    {
        return $this->hasMany(Diary::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class)->withCount('follower')->withDefault();
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class);
    }

    public static function isUsernameTaken($username)
    {
        return static::where('username', $username)->exists();
    }
}
