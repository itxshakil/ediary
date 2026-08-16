<?php

declare(strict_types=1);

namespace App\Services\Diary;

use App\Diary;
use App\Enums\Privacy;
use Illuminate\Pagination\LengthAwarePaginator;

final class DiaryExploreService
{
    public function feed(int $perPage = 12): LengthAwarePaginator
    {
        return Diary::query()
            ->where('privacy', Privacy::Public->value)
            ->with(['owner.profile', 'tags'])
            ->latest()
            ->paginate($perPage);
    }
}
