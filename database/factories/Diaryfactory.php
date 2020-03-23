<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Diary;
use App\User;
use Faker\Generator as Faker;

$factory->define(Diary::class, function (Faker $faker) {
    return [
        'entry' => $faker->text(300),
        'user_id' => factory(User::class)->create(),
    ];
});
