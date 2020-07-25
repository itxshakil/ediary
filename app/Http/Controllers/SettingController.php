<?php

namespace App\Http\Controllers;

class SettingController
{
    public function __invoke()
    {
        return view('settings.index');
    }
}
