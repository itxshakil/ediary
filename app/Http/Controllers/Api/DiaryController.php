<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Diary\StoreDiaryAction;
use App\Diary;
use App\Http\Requests\StoreSyncedDiaryRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class DiaryController
{
    public function __construct(
        private readonly StoreDiaryAction $storeDiary,
    ) {}

    /**
     * @return LengthAwarePaginator<int, Diary>
     */
    public function index(Request $request): LengthAwarePaginator
    {
        /** @var User $user */
        $user = $request->user();

        return $user->diaries()->latest()->paginate(12);
    }

    public function store(StoreSyncedDiaryRequest $request): JsonResponse
    {
        $diary = $this->storeDiary->execute($request->user(), $request->validated());

        return response()->json($diary, 201);
    }
}
