<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CanonicalHostTest extends TestCase
{
    use RefreshDatabase;

    /** How the host hands requests over: the site root is rewritten into public/. */
    private const array HOSTED = [
        'SCRIPT_NAME' => '/public/index.php',
        'PHP_SELF' => '/public/index.php',
        'SCRIPT_FILENAME' => '/home/site/public/index.php',
    ];

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function duplicates(): iterable
    {
        yield 'public folder' => ['/public/about', '/about'];
        yield 'public folder root' => ['/public', '/'];
        yield 'front controller' => ['/index.php', '/'];
        yield 'front controller path' => ['/index.php/faq', '/faq'];
        yield 'public front controller' => ['/public/index.php', '/'];
        yield 'trailing slash' => ['/about/', '/about'];
        yield 'public and trailing slash' => ['/public/blogs/how-to-keep-a-study-journal/', '/blogs/how-to-keep-a-study-journal'];
        yield 'query string is kept' => ['/public/search?q=asha&page=2', '/search?q=asha&page=2'];
    }

    #[Test]
    #[DataProvider(methodName: 'duplicates')]
    public function duplicate_urls_redirect_permanently_to_the_clean_url(string $requested, string $clean): void
    {
        $this->hostedGet($requested)
            ->assertMovedPermanently()
            ->assertRedirect(mb_rtrim((string) config('app.url'), '/') . $clean);
    }

    #[Test]
    public function the_clean_url_is_served_with_a_canonical_on_app_url(): void
    {
        $this->call('GET', '/about', server: self::HOSTED)
            ->assertOk()
            ->assertSeeHtml('rel="canonical" href="' . url('/about') . '"')
            ->assertDontSeeHtml('/public/about');
    }

    #[Test]
    public function the_sitemap_never_lists_the_public_folder(): void
    {
        $this->call('GET', '/sitemap.xml', server: self::HOSTED)->assertOk()->assertDontSee('/public/');
    }

    #[Test]
    public function form_posts_are_never_redirected(): void
    {
        $this->actingAs(User::factory()->create())
            ->call('POST', '/public/diaries', ['entry' => 'Posted through the rewrite.'], server: self::HOSTED)
            ->assertRedirect(route('home'));
    }

    /**
     * Sends the raw URL through the kernel: the test helpers would strip a trailing slash first.
     */
    private function hostedGet(string $uri): TestResponse
    {
        $request = Request::create(mb_rtrim((string) config('app.url'), '/') . $uri, 'GET', server: self::HOSTED);

        return TestResponse::fromBaseResponse($this->app->make(Kernel::class)->handle($request), $request);
    }
}
