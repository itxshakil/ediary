<?php

declare(strict_types=1);

namespace App\Support\Traits;

use App\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

/**
 * Trait HasTags.
 *
 * Adds polymorphic tagging support to a model.
 *
 * @property-read Collection<int, Tag> $tags
 * @property-read string $tag_list
 *
 * @mixin Model
 */
trait HasTags
{
    /**
     * Polymorphic many-to-many relationship with tags.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Determine if the model has a specific tag.
     */
    public function hasTag(Tag $tag): bool
    {
        return $this->tags()
            ->whereKey($tag->getKey())
            ->exists();
    }

    /**
     * Attach or detach a tag from the model.
     */
    public function toggleTag(Tag $tag): void
    {
        $this->tags()->toggle($tag->getKey());
    }

    /**
     * Get a comma-separated list of tag names.
     */
    public function getTagListAttribute(): string
    {
        return $this->tags
            ->pluck('name')
            ->implode(', ');
    }

    /**
     * Sync tags to the model.
     *
     * Accepts tag IDs, Tag models, or tag names.
     * Missing tags will be created automatically.
     *
     * @param array<int, int|string|Tag> $tags
     */
    public function syncTags(array $tags): void
    {
        $tagIds = $this->normalizeTags($tags);

        $this->tags()->sync($tagIds);
    }

    public function scopeWhereTag(Builder $query, string $tag): void
    {
        $tags = explode(',', $tag);

        $query->whereHas('tags', function (Builder $query) use ($tags): void {
            $query->whereIn('name', $tags);
        });
    }

    /**
     * Normalize tags into an array of tag IDs.
     *
     * Supported inputs:
     * - Tag model
     * - Numeric ID
     * - Tag name (string)
     *
     * @param  array<int, int|string|Tag> $tags
     * @return array<int, int>
     */
    protected function normalizeTags(array $tags): array
    {
        return collect($tags)
            ->map(function ($tag): ?int {
                if ($tag instanceof Tag) {
                    return $tag->getKey();
                }

                if (is_numeric($tag)) {
                    return (int) $tag;
                }

                return Tag::firstOrCreate([
                    'name' => mb_trim($tag),
                ])->getKey();
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
