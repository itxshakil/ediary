<?php

declare(strict_types=1);

use App\Http\Controllers\Api\UserAvatarController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\UsernameController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome');

Auth::routes(['verify' => true]);

Route::get('/password/change', [ChangePasswordController::class, 'showForm'])->middleware('auth');
Route::post('/password/change', [ChangePasswordController::class, 'change'])->name('password.change')->middleware('auth');

Route::view('/home', 'home')->name('home')->middleware('auth');
Route::post('/contact', [PageController::class, 'send'])->name('contact.send');

Route::get('/search', [SearchController::class, 'show']);

Route::get('/user/{user:username}', [ProfileController::class, 'show']);
Route::post('/profile/{user:username}', [ProfileController::class, 'update']);

Route::post('/profile/{user:username}/follow', [FollowController::class, 'store'])->middleware('auth');

Route::post('/api/users/{user:username}/avatar', [UserAvatarController::class, 'store'])->middleware('auth');

Route::view('/about', 'pages.about');
Route::view('/faq', 'pages.faq');
Route::view('/contact', 'pages.contact');
Route::view('/success', 'pages.success');
Route::view('/request-data', 'pages.request-data')->middleware('password.confirm');
Route::post('/request-data', [UserDataController::class, 'send'])->middleware('password.confirm')->name('request.data');

Route::middleware(['auth'])->group(function (): void {
    Route::get('/diaries', [DiaryController::class, 'index']);
    Route::get('/diaries/create', [DiaryController::class, 'create'])->name('diary.create');
    Route::post('/diaries', [DiaryController::class, 'store'])->name('diary.store');
});

/* Sitemap Route */
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('/sitemap.xml/users', [SitemapController::class, 'users']);

Route::get('/settings', SettingController::class)->middleware('verified');
Route::put('/username', [UsernameController::class, 'update'])->middleware('verified');

Route::view('/blog', 'blogs.index');
Route::view('/blogs/how-to-write-diary', 'blogs.how-to-write')->name('blogs.how-to-write');
Route::view('/blogs/these-8-good-things-will-happen-when-you-start-writing-diary', 'blogs.these-8-good-things')->name('blogs.these-8-good-things');
Route::view('/blogs/how-to-start-writing-a-diary', 'blogs.how-to-start-writing-a-diary')->name('blogs.how-to-start-writing-a-diary');
Route::view('/blogs/goal-setting-for-success', 'blogs.goal-setting-for-success')->name('blogs.goal-setting-for-success');
