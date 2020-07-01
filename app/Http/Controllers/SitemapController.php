<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index()
    {
        $routeCollection = Route::getRoutes();
        $routes = $routeCollection->get('GET');

        return response()->view('sitemap.index', compact('routes'))->header('Content-Type', 'text/xml');
    }

    public function users()
    {
        $users = User::select('username', 'updated_at')->get();

        return response()->view('sitemap.users', compact('users'))->header('Content-Type', 'text/xml');
    }
}
