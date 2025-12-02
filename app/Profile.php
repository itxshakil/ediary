<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Storage;

/**
 * @property string $image
 */
final class Profile extends Model
{
    protected $fillable = ['name', 'bio', 'image'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'username'])->withCount('following');
    }

    /**
     * @return BelongsToMany<User, $this, Pivot>
     */
    public function follower(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    protected function image(): Attribute
    {
        return Attribute::get(get: function ($value) {
            if ($value) {
                return Storage::disk('s3')->url($value);
            }

            return sprintf('https://ui-avatars.com/api/?name=%s&background=0D8ABC&color=fff', $this->name);
        });
    }
}
