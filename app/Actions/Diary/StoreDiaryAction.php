<?php

declare(strict_types=1);

namespace App\Actions\Diary;

use App\Diary;
use App\Enums\Privacy;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

final class StoreDiaryAction
{
    /**
     * @param array<string, mixed> $attributes
     *
     * @throws Throwable
     */
    public function execute(User $user, array $attributes): Diary
    {
        /** @var Diary $diary */
        $diary = DB::transaction(function () use ($user, $attributes): Diary {
            /** @var Diary $diary */
            $diary = $user->diaries()->create([
                'title' => $attributes['title'] ?? null,
                'entry' => $attributes['entry'],
                'mood' => $attributes['mood'] ?? null,
                'privacy' => $attributes['privacy'] ?? Privacy::Private->value,
                'is_featured' => (bool) ($attributes['is_featured'] ?? false),
                'allow_comments' => (bool) ($attributes['allow_comments'] ?? true),
            ]);

            $tags = $this->parseTags($attributes['tags'] ?? null);
            if ($tags !== []) {
                $diary->syncTags($tags);
            }

            $createdAt = Arr::get($attributes, 'created_at');
            if ($createdAt !== null) {
                $diary->forceFill(['created_at' => $createdAt])->save();
            }

            return $diary->fresh(['tags']) ?? $diary;
        });

        return $diary;
    }

    /**
     * @return array<int, string>
     */
    private function parseTags(mixed $rawTags): array
    {
        if (! is_string($rawTags) || mb_trim($rawTags) === '') {
            return [];
        }

        return array_values(array_filter(
            array_map(static fn (string $tag): string => mb_trim($tag), explode(',', $rawTags)),
            static fn (string $tag): bool => $tag !== '',
        ));
    }
}
