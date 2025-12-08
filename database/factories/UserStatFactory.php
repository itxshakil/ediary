<?php

declare(strict_types=1);

namespace Database\Factories;

use App\User;
use App\UserStat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserStat>
 */
final class UserStatFactory extends Factory
{
    protected $model = UserStat::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'current_streak' => fake()->numberBetween(0, 30),
            'longest_streak' => fake()->numberBetween(0, 100),
            'last_entry_date' => fake()->optional()->date(),
            'total_entries' => fake()->numberBetween(0, 500),
            'total_words' => fake()->numberBetween(0, 100_000),
            'freeze_cards' => fake()->numberBetween(0, 5),
        ];
    }
}
