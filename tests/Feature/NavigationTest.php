<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class NavigationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function signed_in_pages_have_a_tab_bar_marking_the_current_page(): void
    {
        $this->actingAs(User::factory()->create(['email_verified_at' => now()]))
            ->get('/diaries')
            ->assertOk()->assertSeeHtml('<nav class="tab-bar" aria-label="Primary">')->assertSeeHtmlInOrder(['href="' . url('/diaries') . '"', 'aria-current="page"'])
            ->assertSeeHtml('href="' . route('diary.create') . '"')
            ->assertSeeHtml('href="' . route('diary.stats') . '"');
    }

    #[Test]
    public function the_tab_bar_marks_tag_and_mood_pages_as_entries(): void
    {
        $this->actingAs(User::factory()->create())->get(route('diary.tag', 'study'))->assertSeeHtmlInOrder(['class="tab-bar-item"', 'href="' . url('/diaries') . '"', 'aria-current="page"']);
    }

    #[Test]
    public function guests_get_no_tab_bar(): void
    {
        $this->get('/about')->assertOk()->assertDontSeeHtml('class="tab-bar"');
    }

    #[Test]
    public function the_navbar_marks_the_current_page_for_guests(): void
    {
        $this->get('/faq')->assertOk()->assertSeeHtmlInOrder(['href="' . url('/faq') . '"', 'aria-current="page"']);
    }
}
