<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Diary\DiaryAnalyticsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class HomeController
{
    public function __construct(
        private readonly DiaryAnalyticsService $analytics,
    ) {}

    public function __invoke(Request $request): Factory|View
    {
        $user = $request->user();
        $streak = $this->analytics->streak($user);

        return view('home', [
            'entries' => $user->diaries()->latest()->with('tags')->paginate(8),
            'streak' => $streak['current'],
            'longestStreak' => $streak['longest'],
            'todayWritten' => $streak['todayWritten'],
            'moodData' => $this->analytics->moodData($user),
        ]);
    }
}
