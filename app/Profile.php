<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Storage;

/**
 * @property string $image
 */
final class Profile extends Model
{
    protected $fillable = ['name', 'bio', 'image'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'username'])->withCount('following');
    }

    /**
     * @return BelongsToMany<User, $this, Pivot>
     */
    public function follower(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function image(): Attribute
    {
        return Attribute::get(fn ($value) => $value && Storage::disk('public')->exists($value)
            ? Storage::disk('public')->url($value)
            : $this->initialsAvatar());
    }

    /**
     * A locally generated initials avatar, so no name is sent to a third-party avatar service.
     */
    private function initialsAvatar(): string
    {
        $name = mb_trim((string) ($this->name ?: $this->user?->username));
        $words = preg_split('/[^\p{L}\p{N}]+/u', $name, -1, PREG_SPLIT_NO_EMPTY) ?: ['?'];
        $initials = mb_strtoupper(mb_substr($words[0], 0, 1) . (count($words) > 1 ? mb_substr(end($words), 0, 1) : ''));
        $hue = crc32($name) % 360;

        $svg = sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect width="64" height="64" fill="hsl(%d 55%% 45%%)"/>'
            . '<text x="50%%" y="50%%" dy=".35em" text-anchor="middle" fill="#fff" font-family="system-ui,sans-serif" font-size="26" font-weight="600">%s</text></svg>',
            $hue,
            htmlspecialchars($initials, ENT_XML1),
        );

        return 'data:image/svg+xml,' . rawurlencode($svg);
    }
}
