<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Diary;
use Illuminate\Database\Seeder;

final class DiaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Diary::factory()->count(100)->create();
    }
}
