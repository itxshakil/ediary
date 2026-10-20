<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class HomeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function an_authenticated_user_can_access_home_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/home');

        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    #[Test]
    public function it_calculates_correct_streak(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create entries for today and yesterday
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()]);
        Diary::factory()->create(['user_id' => $user->id, 'created_at' => now()->subDay()]);

        $response = $this->get('/home');

        $response->assertStatus(200);
        $response->assertViewHas('streak', 2);
    }

    #[Test]
    public function new_writers_get_a_prompt_and_a_private_first_entry_note(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 20));
        $prompts = config('prompts.daily');
        $todays = $prompts[now('Asia/Kolkata')->dayOfYear % count($prompts)];

        $this->actingAs(User::factory()->create(['timezone' => 'Asia/Kolkata']))
            ->get('/home')
            ->assertSee('Need an idea?')
            ->assertSee($todays)
            ->assertSee('Your first entry is just for you')
            ->assertDontSee('Search your diary');
    }

    #[Test]
    public function writers_with_entries_see_them_instead_of_the_first_entry_note(): void
    {
        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'title' => 'Monday notes']);

        $this->actingAs($user)->get('/home')->assertSee('Monday notes')->assertDontSee('Your first entry is just for you');
    }

    #[Test]
    public function the_new_entry_page_offers_a_prompt_too(): void
    {
        $this->actingAs(User::factory()->create())->get(route('diary.create'))->assertSee('Need an idea?')->assertSeeHtml('data-prompt-use');
    }
}
