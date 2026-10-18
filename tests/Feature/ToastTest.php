<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ToastTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function saving_an_entry_shows_a_success_toast(): void
    {
        $this->actingAs(User::factory()->create());

        $this->followingRedirects()
            ->post('/diaries', ['entry' => 'A quiet day.'])->assertOk()->assertSeeHtml('id="toasts"')->assertSeeHtml('data-toast-type="success"')
            ->assertSee('Entry saved successfully!');
    }

    #[Test]
    public function flash_status_and_error_messages_become_toasts(): void
    {
        $this->withSession(['flash' => 'Flash message', 'status' => 'Status message', 'error' => 'Error message'])
            ->get('/about')
            ->assertOk()
            ->assertSee('Flash message')->assertSee('Status message')->assertSeeHtml('data-toast-type="error"')
            ->assertSee('Error message');
    }

    #[Test]
    public function the_toast_region_is_always_present_for_client_side_toasts(): void
    {
        $this->get('/about')->assertOk()->assertSeeHtml('id="toasts"')->assertSeeHtml('id="toast-template"');
    }
}
