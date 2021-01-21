<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    protected $fillable = ['name', 'bio', 'image'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'username'])->withCount('following');
    }

    public function getImageAttribute($value): string
    {
        if ($value) {
            return Storage::disk('s3')->url($value);
        }

        return 'https://source.unsplash.com/96x96/daily';
    }

    public function follower(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
