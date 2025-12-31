<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Bookmark;
use App\Diary;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bookmark>
 */
final class BookmarkFactory extends Factory
{
    protected $model = Bookmark::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'diary_id' => Diary::factory(),
        ];
    }
}
