<?php

declare(strict_types=1);

namespace App\Services\Diary;

use App\Diary;
use Illuminate\Pagination\LengthAwarePaginator;

final class DiaryExploreService
{
    public function feed(int $perPage = 12): LengthAwarePaginator
    {
        return Diary::query()
            ->public()
            ->with(['owner.profile', 'tags'])
            ->latest()
            ->paginate($perPage);
    }
}
