<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class HomeController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $streak = $this->calculateStreak($user);

        return view('home', [
            'entries' => $user->diaries()->latest()->with('tags')->paginate(8),
            'streak' => $streak['current'],
            'longestStreak' => $streak['longest'],
            'todayWritten' => $streak['todayWritten'],
        ]);
    }

    private function calculateStreak(User $user): array
    {
        $entries = $user->diaries()
            ->select(DB::raw('DATE(created_at) as date'))
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('date')
            ->map(fn ($date) => Carbon::parse($date));

        $currentStreak = 0;
        $longestStreak = 0;
        $tempStreak = 0;
        $todayWritten = false;

        if ($entries->isEmpty()) {
            return ['current' => 0, 'longest' => 0, 'todayWritten' => false];
        }

        $todayWritten = $entries->first()->isToday();
        $checkDate = $todayWritten ? today() : today()->subDay();

        foreach ($entries as $entryDate) {
            if ($entryDate->isSameDay($checkDate)) {
                $currentStreak++;
                $tempStreak++;
                $checkDate = $checkDate->subDay();
            } else {
                break;
            }
        }

        $checkDate = $entries->first();
        foreach ($entries as $entryDate) {
            if ($entryDate->isSameDay($checkDate) || $entryDate->isSameDay($checkDate->subDay())) {
                $tempStreak++;
                $longestStreak = max($longestStreak, $tempStreak);
            } else {
                $tempStreak = 1;
            }
            $checkDate = $entryDate->subDay();
        }

        return [
            'current' => $currentStreak,
            'longest' => max($longestStreak, $currentStreak),
            'todayWritten' => $todayWritten,
        ];
    }
}
