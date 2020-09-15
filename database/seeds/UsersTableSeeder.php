<?php

namespace Database\Seeders;

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
        User::factory()->hasDiaries(25)->count(20)->create();
    }
}
