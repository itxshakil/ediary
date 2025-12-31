<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Comment;
use App\Diary;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
final class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'diary_id' => Diary::factory(),
            'user_id' => User::factory(),
            'comment' => fake()->word(),
        ];
    }
}
