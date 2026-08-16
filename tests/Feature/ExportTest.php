<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Diary;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ExportTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function authenticated_user_can_export_their_entries_as_json(): void
    {
        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'entry' => 'Decrypted content']);

        $this->actingAs($user);

        $response = $this->get(route('diary.export'));

        $response->assertStatus(200);
        $response->assertSee('Decrypted content');
    }

    #[Test]
    public function authenticated_user_can_export_their_entries_as_csv(): void
    {
        $user = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'entry' => 'CSV content']);

        $this->actingAs($user);

        $response = $this->get(route('diary.export', ['format' => 'csv']));

        $response->assertStatus(200);
        $response->assertSee('CSV content');
    }

    #[Test]
    public function export_only_contains_the_authenticated_users_own_entries(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Diary::factory()->create(['user_id' => $user->id, 'entry' => 'Mine']);
        Diary::factory()->create(['user_id' => $other->id, 'entry' => 'Not mine']);

        $this->actingAs($user);

        $response = $this->get(route('diary.export'));

        $response->assertSee('Mine');
        $response->assertDontSee('Not mine');
    }

    #[Test]
    public function export_requires_authentication(): void
    {
        $this->get(route('diary.export'))->assertRedirect('/login');
    }
}
