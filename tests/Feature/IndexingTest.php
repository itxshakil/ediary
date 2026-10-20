<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\Privacy;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class IndexingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return iterable<string, array{string}>
     */
    public static function privacies(): iterable
    {
        yield 'public' => [Privacy::Public->value];
        yield 'unlisted' => [Privacy::Unlisted->value];
    }

    #[Test]
    #[DataProvider(methodName: 'privacies')]
    public function shared_entries_are_kept_out_of_search_results(string $privacy): void
    {
        $diary = Diary::factory()->create(['user_id' => User::factory()->create()->id, 'privacy' => $privacy]);

        $this->get(route('diary.public', $diary))
            ->assertOk()
            ->assertSeeHtml('<meta name="robots" content="noindex, nofollow" />');
    }

    #[Test]
    public function search_results_are_not_indexed_and_do_not_echo_the_query_into_the_head(): void
    {
        $head = str($this->get('/search?q=cheap-pills')->assertOk()->getContent())->before('</head>')->toString();

        $this->assertStringContainsString('<meta name="robots" content="noindex, follow" />', $head);
        $this->assertStringContainsString('<link rel="canonical" href="' . url('/search') . '" />', $head);
        $this->assertStringNotContainsString('cheap-pills', $head);
    }

    #[Test]
    public function utility_pages_are_not_indexed(): void
    {
        foreach (['/success', '/password/reset', '/password/reset/some-token'] as $path) {
            $this->get($path)->assertOk()->assertSeeHtml('<meta name="robots" content="noindex, nofollow" />');
        }
    }

    #[Test]
    public function content_pages_stay_indexable(): void
    {
        foreach (['/', '/about', '/blog', route('blogs.how-to-keep-a-study-journal')] as $path) {
            $this->get($path)->assertOk()->assertDontSeeHtml('name="robots"');
        }
    }

    #[Test]
    public function the_homepage_describes_the_site_and_the_app(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('"@type":"WebSite"', escape: false)
            ->assertSee('"name":"Ediary","alternateName":["E-diary","Ediary App"]', escape: false)
            ->assertSee('"@type":"WebApplication"', escape: false)
            ->assertSee('"applicationCategory":"LifestyleApplication"', escape: false);
    }

    #[Test]
    public function only_the_homepage_carries_the_app_markup_and_none_offers_a_search_box(): void
    {
        $this->get('/about')->assertDontSee('WebApplication')->assertDontSee('MobileApplication');
        $this->get('/')->assertDontSee('SearchAction')->assertDontSee('MobileApplication');
    }

    #[Test]
    public function open_graph_tags_use_the_property_attribute(): void
    {
        foreach (['/', '/faq', '/blog', '/login', route('blogs.these-8-good-things')] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertDontSeeHtml('name="og:')
                ->assertSeeHtml('<meta property="og:site_name" content="Ediary" />')
                ->assertDontSeeHtml('og:email');
        }
    }

    #[Test]
    public function responses_carry_baseline_security_headers(): void
    {
        $this->get('/about')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), geolocation=(), microphone=(self)');
    }

    #[Test]
    public function every_page_gets_one_set_of_share_tags_from_the_layout(): void
    {
        foreach (['/', '/faq', '/blog', '/register', route('blogs.how-to-start-writing-a-diary')] as $path) {
            $head = str($this->get($path)->assertOk()->getContent())->before('</head>')->toString();

            foreach (['name="description"', 'rel="canonical"', 'property="og:title"', 'property="og:image"', 'name="twitter:card"'] as $tag) {
                $this->assertSame(1, mb_substr_count($head, $tag), "{$path} should have exactly one {$tag}");
            }

            $this->assertStringContainsString('content="' . asset('images/og/ediary.png') . '"', $head);
            $this->assertStringNotContainsString('name="keywords"', $head);
        }
    }

    #[Test]
    public function titles_name_the_brand_once(): void
    {
        $this->get('/faq')->assertSeeHtml('<title>Ediary FAQ: Privacy, Offline Writing and Your Entries</title>');
        $this->get('/for-students')->assertSeeHtml('<title>Private Study Journal for Students | Ediary</title>');
    }

    #[Test]
    public function the_homepage_leads_with_its_main_keyword_and_newest_posts(): void
    {
        $this->get('/')
            ->assertSeeInOrder(['<h1', 'A private online diary', 'that works offline', '</h1>'], escape: false)
            ->assertSee('How to Keep a Study Journal')
            ->assertDontSee('Cancel anytime');
    }

    #[Test]
    public function every_structured_data_block_is_valid_schema_org_json(): void
    {
        $pages = ['/', '/about', '/faq', '/for-students', '/blog', '/journal-prompts', '/journal-prompts/gratitude', '/mood-journal', route('blogs.how-to-start-writing-a-diary')];

        foreach ($pages as $page) {
            preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', (string) $this->get($page)->getContent(), $blocks);

            foreach ($blocks[1] as $json) {
                $data = json_decode($json, associative: true, flags: JSON_THROW_ON_ERROR);
                // Blade compiles a bare '@context' in templates as a directive, dropping the key.
                $this->assertMatchesRegularExpression('#^https://schema\.org/?$#', (string) ($data['@context'] ?? ''), "{$page} structured data needs @context");
            }
        }
    }
}
