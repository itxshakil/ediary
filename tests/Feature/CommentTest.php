<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Comment;
use App\Diary;
use App\Enums\Privacy;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class CommentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function authenticated_user_can_comment_on_a_public_entry(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Public,
            'allow_comments' => true,
        ]);

        $this->actingAs(User::factory()->create());

        $this->post(route('diary.comment', $diary), ['comment' => 'Nice entry!'])
            ->assertStatus(302);

        $this->assertCount(1, Comment::all());
        $this->assertSame(1, $diary->fresh()->comments_count);
    }

    #[Test]
    public function commenting_requires_authentication(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Public,
        ]);

        $this->post(route('diary.comment', $diary), ['comment' => 'Nice!'])
            ->assertRedirect('/login');

        $this->assertCount(0, Comment::all());
    }

    #[Test]
    public function commenting_is_forbidden_when_the_entry_disables_comments(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Public,
            'allow_comments' => false,
        ]);

        $this->actingAs(User::factory()->create());

        $this->post(route('diary.comment', $diary), ['comment' => 'Nice!'])
            ->assertStatus(403);

        $this->assertCount(0, Comment::all());
    }

    #[Test]
    public function commenting_is_forbidden_on_an_inaccessible_private_entry(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Private,
        ]);

        $this->actingAs(User::factory()->create());

        $this->post(route('diary.comment', $diary), ['comment' => 'Nice!'])
            ->assertStatus(403);
    }

    #[Test]
    public function comment_requires_text(): void
    {
        $diary = Diary::factory()->create([
            'user_id' => User::factory()->create()->id,
            'privacy' => Privacy::Public,
        ]);

        $this->actingAs(User::factory()->create());

        $this->post(route('diary.comment', $diary), ['comment' => ''])
            ->assertSessionHasErrors('comment');
    }
}
