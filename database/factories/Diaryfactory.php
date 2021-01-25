<?php

namespace Database\Factories;

use App\Diary;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class DiaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Diary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['entry' => "string"])]
    public function definition(): array
    {
        return [
            'entry' => $this->faker->realText(),
        ];
    }
}
