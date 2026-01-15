<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class BlogTest extends TestCase
{
    #[Test]
    public function it_displays_the_blog_index_page(): void
    {
        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee('Latest Blog Article');
        $response->assertSee('How to Write a Diary');
        $response->assertSee('8 Good Things That Happen When You Start Journaling');
        $response->assertSee('How to Start Writing a Diary');
    }

    #[Test]
    public function it_displays_the_how_to_write_blog_post(): void
    {
        $response = $this->get(route('blogs.how-to-write'));

        $response->assertStatus(200);
        $response->assertSee('How to Write a Diary');
        $response->assertSee('blog-content');
    }

    #[Test]
    public function it_displays_the_eight_good_things_blog_post(): void
    {
        $response = $this->get(route('blogs.these-8-good-things'));

        $response->assertStatus(200);
        $response->assertSee('8 Good Things Will Happen When You Start Writing Diaries');
        $response->assertSee('blog-content');
    }

    #[Test]
    public function it_displays_the_how_to_start_writing_a_diary_blog_post(): void
    {
        $response = $this->get(route('blogs.how-to-start-writing-a-diary'));

        $response->assertStatus(200);
        $response->assertSee('How to Start Writing a Diary');
        $response->assertSee('blog-content');
    }

    #[Test]
    public function it_displays_the_goal_setting_for_success_blog_post(): void
    {
        $response = $this->get(route('blogs.goal-setting-for-success'));

        $response->assertStatus(200);
        $response->assertSee('Goal Setting for Success');
        $response->assertSee('blog-content');
    }
}
