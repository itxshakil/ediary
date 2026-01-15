<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\Diary;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class DiaryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    #[Test]
    
    
    public function authenticated_user_can_add_entry_to_diary(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/diaries', ['entry' => $this->faker->text(300)])->assertStatus(302);

        $this->assertCount(1, Diary::all());
    }

    #[Test]
    
    
    public function unauthenticated_user_can_not_add_entry_to_diary(): void
    {
        $this->json('POST', '/diaries', ['entry' => $this->faker->text(300)])->assertStatus(401);
        $this->post('/diaries', ['entry' => $this->faker->text(300)])->assertRedirect('/login');

        $this->assertCount(0, Diary::all());
    }

    #[Test]
    
    
    public function diary_requires_entry(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/diaries', ['entry' => ' '])->assertSessionHasErrors('entry');

        $this->assertCount(0, Diary::all());
    }

    #[Test]
    public function an_authenticated_user_can_search_their_diaries(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Diary::factory()->create([
            'user_id' => $user->id,
            'title' => 'Searching for this',
            'entry' => 'Found it',
        ]);

        Diary::factory()->create([
            'user_id' => $user->id,
            'title' => 'Something else',
            'entry' => 'Not this',
        ]);

        $response = $this->get(route('diary.search', ['q' => 'Searching']));

        $response->assertStatus(200);
        $response->assertSee('Searching for this');
        $response->assertDontSee('Something else');
    }

    #[Test]
    public function an_authenticated_user_can_access_diaries_list(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/diaries');

        $response->assertStatus(200);
    }
}
