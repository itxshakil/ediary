<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Diary\DiaryAnalyticsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final readonly class HomeController
{
    public function __construct(
        private DiaryAnalyticsService $diaryAnalyticsService,
    ) {}

    public function __invoke(Request $request): Factory|View
    {
        $user = $request->user();
        $streak = $this->diaryAnalyticsService->streak($user);

        return view('home', [
            'entries' => $user->diaries()->latest()->with('tags')->paginate(8),
            'streak' => $streak['current'],
            'longestStreak' => $streak['longest'],
            'todayWritten' => $streak['todayWritten'],
            'moodData' => $this->diaryAnalyticsService->moodData($user),
        ]);
    }
}
