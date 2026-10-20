<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class BlogTest extends TestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function studentClusterPosts(): array
    {
        return [
            'study journal' => ['blogs.how-to-keep-a-study-journal', 'How to Keep a Study Journal'],
            'research journal' => ['blogs.how-to-keep-a-research-journal', 'How to Keep a Research Journal'],
            'student prompts' => ['blogs.journaling-prompts-for-students', '40 Journaling Prompts for Students'],
            'private journal app' => ['blogs.how-to-choose-a-private-journal-app', 'How to Choose a Private Journal App'],
        ];
    }

    #[Test]
    public function it_displays_the_blog_index_page(): void
    {
        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSeeHtml('<title>Journaling Guides, Prompts and Diary Tips | Ediary</title>');
        $response->assertSee('8 Good Things That Happen When You Start Journaling');
        $response->assertSee('How to Start Writing a Diary');
        $response->assertSee('"dateModified":"2026-10-18"', escape: false);
        // Unlisted posts stay reachable but are left out of the cards and the structured data.
        $response->assertDontSee('How to Write a Diary');
    }

    #[Test]
    public function blogs_without_a_slug_redirects_to_the_blog_index(): void
    {
        $this->get('/blogs')->assertMovedPermanently()->assertRedirect(url('/blog'));
    }

    #[Test]
    public function a_post_is_marked_up_as_an_article_with_its_dates(): void
    {
        $this->get(route('blogs.how-to-keep-a-study-journal'))
            ->assertOk()
            ->assertSeeHtml('<meta property="og:type" content="article" />')
            ->assertSee('"datePublished":"2026-10-18","dateModified":"2026-10-18"', escape: false);
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
        $response->assertSeeHtml('<title>8 Good Things That Happen When You Start Journaling | Ediary</title>');
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
        $response->assertSeeHtml('<title>Goal Setting: 5 Steps to Design the Life You Want | Ediary</title>');
        $response->assertSee('blog-content');
    }

    #[Test]
    #[DataProvider(methodName: 'studentClusterPosts')]
    public function it_displays_and_lists_the_student_cluster_posts(string $route, string $title): void
    {
        $this->get(route($route))
            ->assertStatus(200)
            ->assertSee($title)
            ->assertSee('blog-content');

        $this->get('/blog')->assertSee($title);
    }
}
