<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class HomeController
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        return view('home');
    }
}
