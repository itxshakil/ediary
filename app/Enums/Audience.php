<?php

declare(strict_types=1);

namespace App\Enums;

enum Audience: string
{
    case Owner = 'owner';
    case Followers = 'followers';
    case Guests = 'guests';
}
