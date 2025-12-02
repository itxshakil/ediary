<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Diary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Diary>
 */
final class DiaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Diary::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'entry' => $this->faker->realText(),
        ];
    }
}
