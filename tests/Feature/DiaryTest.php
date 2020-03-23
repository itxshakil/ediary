<?php

namespace Tests\Feature;

use App\Diary;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DiaryTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /**
    * @test
    */
    public function authenticated_user_can_add_entry_to_diary()
    {
        $this->actingAs(factory(User::class)->create());

        $this->post('/diaries', ['entry' => $this->faker->text(300)])->assertCreated();

        $this->assertCount(1, Diary::all());
    }

    /**
    * @test
    */
    public function unauthenticated_user_can_not_add_entry_to_diary()
    {
        $this->json('POST', '/diaries', ['entry' => $this->faker->text(300)])->assertStatus(401);
        $this->post('/diaries', ['entry' => $this->faker->text(300)])->assertRedirect('/login');

        $this->assertCount(0, Diary::all());
    }

    /**
    * @test
    */
    public function diary_requires_entry()
    {
        $this->actingAs(factory(User::class)->create());

        $this->post('/diaries', ['entry' => ' '])->assertSessionHasErrors('entry');

        $this->assertCount(0, Diary::all());
    }
}
