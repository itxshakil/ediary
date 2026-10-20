<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function signing_up_reports_sign_up_on_the_next_page(): void
    {
        $this->followingRedirects()
            ->post('/register', [
                'email' => 'new@example.com',
                'password' => 'secret-password',
            ])
            ->assertOk()
            ->assertSeeHtml('gtag(\'event\', "sign_up", {"method":"email"});');
    }

    #[Test]
    public function a_json_signup_reports_sign_up_once_the_redirect_target_renders(): void
    {
        $this->postJson('/register', [
            'email' => 'json@example.com',
            'password' => 'secret-password',
        ])->assertCreated();

        $this->get('/home')->assertSeeHtml('"sign_up", {"method":"email"}');
        $this->get('/home')->assertDontSeeHtml('"sign_up", {"method":"email"}');
    }

    #[Test]
    public function logging_in_reports_login(): void
    {
        $user = User::factory()->create();

        $this->followingRedirects()
            ->post('/login', ['login' => $user->username, 'password' => 'password'])
            ->assertOk()
            ->assertSeeHtml('gtag(\'event\', "login", {"method":"password"});');
    }

    #[Test]
    public function verifying_an_email_reports_email_verified_only_the_first_time(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $link = URL::temporarySignedRoute('verification.verify', now()->addHour(), [
            'id' => $user->id,
            'hash' => sha1((string) $user->email),
        ]);

        $this->actingAs($user)->followingRedirects()->get($link)->assertSeeHtml('gtag(\'event\', "email_verified", {});');
        $this->assertTrue($user->fresh()->hasVerifiedEmail());

        $this->followingRedirects()->get($link)->assertDontSeeHtml('"email_verified"');
    }

    #[Test]
    public function only_the_first_entry_is_flagged_as_first(): void
    {
        $this->actingAs(User::factory()->create());

        $this->followingRedirects()->post('/diaries', ['entry' => 'Day one.'])
            ->assertSeeHtml('gtag(\'event\', "entry_created", {"source":"web","first_entry":true});');

        $this->followingRedirects()->post('/diaries', ['entry' => 'Day two.'])
            ->assertSeeHtml('gtag(\'event\', "entry_created", {"source":"web","first_entry":false});');
    }

    #[Test]
    public function an_offline_entry_is_reported_on_the_next_page(): void
    {
        $this->actingAs(User::factory()->create());

        $this->postJson(route('diary.sync'), ['entry' => 'Written offline.'])->assertCreated();

        $this->get('/home')->assertSeeHtml('"entry_created", {"source":"offline_sync","first_entry":true}');
    }

    #[Test]
    public function the_signed_in_users_details_are_not_exposed_to_page_scripts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/home')->assertOk()->assertDontSee('window.User', escape: false)->assertDontSee($user->email);
    }

    #[Test]
    public function the_write_button_reports_its_clicks(): void
    {
        $this->actingAs(User::factory()->create())->get('/home')->assertSeeHtml('data-track="floating_add_clicked"');
    }

    #[Test]
    public function google_analytics_loads_directly_in_production_only(): void
    {
        $this->get('/about')
            ->assertSeeHtml("gtag('config', \"G-LZJVVY21NY\")")
            ->assertDontSee('googletagmanager.com/gtag/js', escape: false)
            ->assertDontSee('GTM-5KBQKGS', escape: false);

        $this->app['env'] = 'production';

        $this->get('/about')->assertSeeHtml('https://www.googletagmanager.com/gtag/js?id=G-LZJVVY21NY');
    }

    #[Test]
    public function events_queued_in_the_old_format_are_dropped_instead_of_breaking_the_page(): void
    {
        $this->withSession(['analytics.events' => [['event' => 'sign_up', 'method' => 'email']]])
            ->get('/about')
            ->assertOk()
            ->assertDontSeeHtml('"sign_up"');
    }
}
