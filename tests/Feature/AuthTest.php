<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\Enums\Privacy;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function signing_up_needs_only_an_email_and_a_password(): void
    {
        $this->post('/register', ['email' => 'asha@example.com', 'password' => 'secret-password'])
            ->assertRedirect('/home');

        $user = User::sole();
        $this->assertAuthenticatedAs($user);
        $this->assertSame('asha@example.com', $user->email);
        $this->assertMatchesRegularExpression('/^[a-z]+-[a-z]+-\d{4}$/', $user->username);
    }

    #[Test]
    public function the_assigned_username_never_reveals_the_email(): void
    {
        $this->post('/register', ['email' => 'asha.verma@example.com', 'password' => 'secret-password']);

        $this->assertStringNotContainsString('asha', User::sole()->username);
    }

    #[Test]
    public function new_users_are_told_their_username_and_where_to_change_it(): void
    {
        $this->followingRedirects()
            ->post('/register', ['email' => 'asha@example.com', 'password' => 'secret-password'])
            ->assertSee('@' . User::sole()->username)
            ->assertSee('Settings');
    }

    #[Test]
    public function every_new_user_gets_a_different_username(): void
    {
        foreach (range(1, 5) as $i) {
            $this->post('/register', ['email' => "writer{$i}@example.com", 'password' => 'secret-password']);
            $this->post('/logout');
        }

        $this->assertCount(5, User::query()->pluck('username')->unique());
    }

    #[Test]
    public function signup_rejects_a_taken_email_and_a_short_password(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->post('/register', ['email' => 'taken@example.com', 'password' => 'short'])
            ->assertSessionHasErrors(['email', 'password']);
    }

    #[Test]
    public function signup_forms_ask_for_email_and_password_only(): void
    {
        foreach (['/', '/register'] as $page) {
            $this->get($page)
                ->assertOk()
                ->assertSeeHtml('name="email"')
                ->assertSeeHtml('name="password"')
                ->assertDontSeeHtml('name="username"')
                ->assertDontSeeHtml('name="password_confirmation"')
                ->assertSeeHtml('data-password-toggle');
        }
    }

    #[Test]
    public function people_can_log_in_with_their_email(): void
    {
        $user = User::factory()->create(['email' => 'asha@example.com']);

        $this->post('/login', ['login' => 'Asha@Example.com', 'password' => 'password'])->assertRedirect('/home');

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function people_can_log_in_with_their_username(): void
    {
        $user = User::factory()->create(['username' => 'quiet-river-4821']);

        $this->post('/login', ['login' => 'quiet-river-4821', 'password' => 'password'])->assertRedirect('/home');

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function a_wrong_password_keeps_people_signed_out(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['login' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('login');

        $this->assertGuest();
    }

    #[Test]
    public function signed_in_people_opening_the_site_go_straight_to_their_diary(): void
    {
        $this->actingAs(User::factory()->create())->get('/')->assertRedirect('/home');
        $this->actingAs(User::factory()->create())->get('/?utm_source=homescreen')->assertRedirect('/home');
    }

    #[Test]
    public function guests_see_sign_up_on_every_screen_size(): void
    {
        preg_match('#<a[^>]*href="' . preg_quote(route('register'), '#') . '"[^>]*>\s*Sign up#', (string) $this->get('/about')->getContent(), $signUp);

        $this->assertNotEmpty($signUp, 'The navbar should link to sign up.');
        $this->assertStringNotContainsString('hidden', $signUp[0]);
    }

    #[Test]
    public function verifying_an_email_shows_a_confirmation(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $link = URL::temporarySignedRoute('verification.verify', now()->addHour(), [
            'id' => $user->id,
            'hash' => sha1((string) $user->email),
        ]);

        $this->actingAs($user)->followingRedirects()->get($link)->assertSee('Your email is verified');
    }

    #[Test]
    public function guests_reading_shared_pages_are_invited_to_start_a_diary(): void
    {
        $author = User::factory()->create(['username' => 'shared-author']);
        $diary = Diary::factory()->create(['user_id' => $author->id, 'privacy' => Privacy::Public]);

        $this->get(route('diary.public', $diary))->assertSee('create a free diary')->assertSee('Start writing for free');
        $this->get('/user/shared-author')->assertSee('Start writing for free');
        $this->actingAs($author)->get(route('diary.public', $diary))->assertDontSee('Start writing for free');
    }

    #[Test]
    public function the_installed_app_opens_on_the_diary_with_writing_shortcuts(): void
    {
        $manifest = json_decode((string) file_get_contents(public_path('manifest.webmanifest')), associative: true);

        $this->assertSame('/home?utm_source=homescreen', $manifest['start_url']);
        $this->assertSame(['Write an entry', 'My entries', 'Writing stats'], array_column($manifest['shortcuts'], 'name'));
    }

    #[Test]
    public function signup_records_the_browsers_timezone(): void
    {
        $this->post('/register', ['email' => 'asha@example.com', 'password' => 'secret-password', 'timezone' => 'Asia/Kolkata']);

        $this->assertSame('Asia/Kolkata', User::sole()->timezone);
    }

    #[Test]
    public function a_bogus_timezone_never_blocks_signup(): void
    {
        $this->post('/register', ['email' => 'asha@example.com', 'password' => 'secret-password', 'timezone' => 'Mars/Olympus'])
            ->assertRedirect('/home');

        $this->assertNull(User::sole()->timezone);
        $this->assertSame(config('app.user_timezone'), User::sole()->localTimezone());
    }

    #[Test]
    public function signing_in_follows_the_writer_to_a_new_timezone(): void
    {
        $user = User::factory()->create(['timezone' => 'Asia/Kolkata']);

        $this->post('/login', ['login' => $user->username, 'password' => 'password', 'timezone' => 'Europe/London']);

        $this->assertSame('Europe/London', $user->fresh()->timezone);
    }

    #[Test]
    public function every_signup_and_login_form_reports_the_timezone(): void
    {
        foreach (['/', '/register', '/login'] as $page) {
            $this->get($page)->assertSeeHtml('<input type="hidden" name="timezone" data-timezone />');
        }
    }
}
