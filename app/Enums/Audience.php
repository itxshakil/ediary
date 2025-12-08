<?php

namespace App\Enums;

enum Audience: string
{
    case Owner = 'owner';
    case Followers = 'followers';
    case Guests = 'guests';
}

