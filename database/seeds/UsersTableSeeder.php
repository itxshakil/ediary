<?php

use App\Diary;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->create()->each(function ($user) {
            $user->diaries()->saveMany(factory(Diary::class,25)->make());
            $user->profile()->create([
                'name' => $user->username,
            ]);
        });
    }
}
