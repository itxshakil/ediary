<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class JournalPromptsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function the_hub_lists_every_prompt_page(): void
    {
        $response = $this->get('/journal-prompts')->assertOk();

        foreach (config('journal-prompts.pages') as $slug => $page) {
            $response->assertSee($page['title'])->assertSeeHtml('href="' . url("journal-prompts/{$slug}") . '"');
        }
    }

    #[Test]
    public function each_page_shows_its_prompts_with_a_write_link(): void
    {
        $prompt = config('journal-prompts.pages.gratitude.sections')['Everyday moments'][0];

        $this->get('/journal-prompts/gratitude')
            ->assertOk()
            ->assertSeeHtml('<title>40 Gratitude Journal Prompts for Every Day | Ediary</title>')
            ->assertSee($prompt)
            ->assertSeeHtml('href="' . e(route('register', ['next' => route('diary.create', ['prompt' => $prompt], absolute: false)])) . '"')
            ->assertSee('"@type":"BreadcrumbList"', escape: false);
    }

    #[Test]
    public function headline_counts_match_the_prompts_and_no_prompt_is_repeated(): void
    {
        $all = [];

        foreach (config('journal-prompts.pages') as $slug => $page) {
            $prompts = collect($page['sections'])->flatten();
            $this->assertStringStartsWith((string) $prompts->count(), $page['headline'], "{$slug} headline count");
            $this->assertLessThanOrEqual(51, mb_strlen($page['headline']), "{$slug} headline fits 60 chars with the brand");
            $this->assertLessThanOrEqual(155, mb_strlen($page['meta_description']), "{$slug} description length");
            $all = [...$all, ...$prompts];
        }

        $this->assertSame(count($all), count(array_unique($all)), 'A prompt appears on more than one page');
    }

    #[Test]
    public function unknown_prompt_pages_are_not_found(): void
    {
        $this->get('/journal-prompts/nope')->assertNotFound();
    }

    #[Test]
    public function signed_in_writers_go_straight_to_a_prefilled_entry(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/journal-prompts/morning')->assertSeeHtml('href="' . e(route('diary.create', ['prompt' => 'What is the one thing that would make today a good day?'])) . '"');
        $this->get(route('diary.create', ['prompt' => 'What surprised me today?']))->assertSeeHtml('value="What surprised me today?"');
    }

    #[Test]
    public function guests_who_sign_up_from_a_prompt_land_on_that_prompt(): void
    {
        $create = route('diary.create', ['prompt' => 'What surprised me today?'], absolute: false);

        $this->get(route('register', ['next' => $create]))->assertOk();
        $this->post('/register', ['email' => 'asha@example.com', 'password' => 'secret-password'])->assertRedirect(url($create));
    }

    #[Test]
    public function the_next_parameter_cannot_send_people_elsewhere(): void
    {
        $this->get(route('register', ['next' => 'https://evil.example/phish']));
        $this->post('/register', ['email' => 'asha@example.com', 'password' => 'secret-password'])->assertRedirect('/home');
    }

    #[Test]
    public function prompt_pages_are_in_the_sitemap_and_the_footer(): void
    {
        $this->get('/sitemap.xml')
            ->assertSeeHtml('<loc>' . url('journal-prompts') . '</loc>')
            ->assertSeeInOrder(['<loc>' . url('journal-prompts/gratitude') . '</loc>', '<lastmod>2026-10-20</lastmod>'], escape: false);

        $this->get('/about')->assertSeeHtml('href="/journal-prompts"');
    }
}
