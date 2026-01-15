<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;

use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

final class PageTest extends TestCase
{
    #[Test]
    public function it_displays_static_pages(): void
    {
        $this->get('/about')->assertStatus(200);
        $this->get('/faq')->assertStatus(200);
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
        Mail::assertSent(ContactUs::class, function ($mail) {
            return $mail->hasTo('itxshakil@gmail.com');
        });
    }
}
