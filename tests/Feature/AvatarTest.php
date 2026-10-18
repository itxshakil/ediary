<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class AvatarTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function profiles_without_a_photo_get_a_local_initials_avatar(): void
    {
        $user = User::factory()->create(['username' => 'janedoe']);
        $user->profile->update(['name' => 'Jane Doe']);

        $image = $user->fresh()->profile->image;

        $this->assertStringStartsWith('data:image/svg+xml,', $image);
        $this->assertStringNotContainsString('ui-avatars', $image);
        $this->assertStringContainsString('JD', rawurldecode($image));
    }

    #[Test]
    public function initials_avatars_are_stable_and_escape_names(): void
    {
        $user = User::factory()->create();
        $user->profile->update(['name' => '<script>x</script> Smith']);

        $first = $user->fresh()->profile->image;

        $this->assertSame($first, $user->fresh()->profile->image);
        $this->assertStringNotContainsString('<script', rawurldecode($first));
    }

    #[Test]
    public function pages_do_not_load_third_party_avatars(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user)->get('/home')->assertOk()->assertDontSee('ui-avatars.com');
    }
}
