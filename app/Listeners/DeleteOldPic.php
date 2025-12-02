<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ProfilePicChanged;
use Illuminate\Support\Facades\Storage;

final class DeleteOldPic
{
    /**
     * Handle the event.
     */
    public function handle(ProfilePicChanged $event): void
    {
        Storage::disk('s3')->delete($event->path);
    }
}
