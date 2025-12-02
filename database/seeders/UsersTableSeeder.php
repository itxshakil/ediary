<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

final class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->hasDiaries(25)->count(20)->create();
    }
}
