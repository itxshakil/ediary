<?php

declare(strict_types=1);

namespace App\Actions\Diary;

use App\Diary;
use App\User;

final class ExportDiariesAction
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function toArray(User $user): array
    {
        return $user->diaries()
            ->with('tags')
            ->get()
            ->map(fn (Diary $diary): array => [
                'title' => $diary->title,
                'entry' => $diary->entry,
                'mood' => $diary->mood?->value,
                'privacy' => $diary->privacy->value,
                'tags' => $diary->tags->pluck('name')->all(),
                'created_at' => $diary->created_at->toIso8601String(),
            ])
            ->all();
    }
}
