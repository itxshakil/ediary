<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

final class SitemapController extends Controller
{
    public function index(): Response
    {
        $routeCollection = Route::getRoutes();
        $routes = $routeCollection->get('GET');

        $users = User::select('username', 'updated_at')->get();

        return response()->view('sitemap.index', ['routes' => $routes, 'users' => $users])->header('Content-Type', 'text/xml');
    }

    public function users(): Response
    {
        $users = User::select('username', 'updated_at')->get();

        return response()->view('sitemap.users', ['users' => $users])->header('Content-Type', 'text/xml');
    }
}
