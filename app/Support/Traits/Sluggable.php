<?php

declare(strict_types=1);

namespace App\Support\Traits;

use App\Support\Contracts\IsSluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @mixin Model
 */
trait Sluggable
{
    public static function bootSluggable(): void
    {
        static::creating(static function (Model&IsSluggable $model): void {
            $model->{$model->getSlugColumn()} = $model->generateSlug();
        });

        static::updating(static function (Model&IsSluggable $model): void {
            if ($model->shouldUpdateSlug()) {
                $model->{$model->getSlugColumn()} = $model->generateSlugOnUpdate();
            }
        });
    }

    public function getSlugColumn(): string
    {
        return 'slug';
    }

    public function getSlugSourceColumn(): string
    {
        return 'name';
    }

    public function generateSlug(): string
    {
        return $this->buildSlug();
    }

    public function generateSlugOnUpdate(): string
    {
        return $this->buildSlug(excludeCurrent: true);
    }

    public function shouldUpdateSlug(): bool
    {
        return $this->isDirty($this->getSlugSourceColumn())
            && $this->shouldUpdateSlugOnUpdate();
    }

    protected function shouldUpdateSlugOnUpdate(): bool
    {
        return true;
    }

    protected function slugSeparator(): string
    {
        return '-';
    }

    protected function buildSlug(bool $excludeCurrent = false): string
    {
        $baseSlug = Str::slug(
            (string) $this->{$this->getSlugSourceColumn()},
            $this->slugSeparator(),
        );

        if (! $this->slugExists($baseSlug, $excludeCurrent)) {
            return $this->avoidRouteCollision($baseSlug);
        }

        for ($i = 1; $i < 100; $i++) {
            $candidate = sprintf('%s%s%d', $baseSlug, $this->slugSeparator(), $i);

            if (! $this->slugExists($candidate, $excludeCurrent)) {
                return $this->avoidRouteCollision($candidate);
            }
        }

        return $baseSlug . $this->slugSeparator() . Str::random(4);
    }

    protected function avoidRouteCollision(string $slug): string
    {
        if (! $this->isSlugCollidingWithRoute($slug)) {
            return $slug;
        }

        return $slug . $this->slugSeparator() . Str::random(3);
    }

    protected function isSlugCollidingWithRoute(string $slug): bool
    {
        try {
            return app('router')
                ->getRoutes()
                ->match(app('request')->create($slug)) !== null;
        } catch (NotFoundHttpException) {
            return false;
        }
    }

    protected function slugExists(string $slug, bool $excludeCurrent): bool
    {
        $query = static::query()
            ->where($this->getSlugColumn(), $slug);

        if ($excludeCurrent && $this->exists) {
            $query->whereKeyNot($this->getKey());
        }

        if ($this->usesSoftDeletes()) {
            $query->withTrashed();
        }

        return $query->exists();
    }

    private function usesSoftDeletes(): bool
    {
        return method_exists(static::class, 'bootSoftDeletes');
    }
}
