<?php

declare(strict_types=1);

namespace Database\Factories;

use App\User;
use App\UserAchievement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserAchievement>
 */
final class UserAchievementFactory extends Factory
{
    protected $model = UserAchievement::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'achievement_key' => fake()->word(),
            'unlocked_at' => fake()->dateTime(),
        ];
    }
}
