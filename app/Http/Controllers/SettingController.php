<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class SettingController
{
    public function __invoke(): Factory|View|Application
    {
        return view('settings.index');
    }
}
