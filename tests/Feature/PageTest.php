<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\ContactUs;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class PageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_static_pages(): void
    {
        $this->get('/about')->assertStatus(200);
        $this->get('/faq')->assertStatus(200);
        $this->get('/security')->assertStatus(200);
        $this->get('/for-students')->assertStatus(200);
        $this->get('/contact')->assertStatus(200);
    }

    #[Test]
    public function it_can_send_contact_emails(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.send'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello, I have a question.',
        ]);

        $response->assertRedirect('/success');
        Mail::assertSent(ContactUs::class, fn ($mail) => $mail->hasTo('itxshakil@gmail.com'));
    }

    #[Test]
    public function the_contact_and_change_password_forms_have_a_submit_button(): void
    {
        $this->get('/contact')->assertSeeHtmlInOrder(['action="' . route('contact.send') . '"', 'type="submit"']);

        $this->actingAs(User::factory()->create())->get('/password/change')->assertSeeHtmlInOrder(['action="' . route('password.change') . '"', 'type="submit"']);
    }

    #[Test]
    public function the_login_and_register_pages_render(): void
    {
        $this->get('/login')->assertOk()->assertSeeHtml('name="password"');
        $this->get('/register')->assertOk()->assertSeeHtml('name="password_confirmation"');
    }
}
