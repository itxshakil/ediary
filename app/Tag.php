<?php

declare(strict_types=1);

namespace App;

use App\Support\Contracts\IsSluggable;
use App\Support\Traits\Sluggable;
use Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Tag extends Model implements IsSluggable
{
    /** @use HasFactory<TagFactory> */
    use HasFactory;
    use Sluggable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function diaries(): MorphToMany
    {
        return $this->morphToMany(Diary::class, 'taggable')->withTimestamps();
    }
}
