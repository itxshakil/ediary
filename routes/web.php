<?php

declare(strict_types=1);

use App\Http\Controllers\Api\UserAvatarController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\UserDataController;
use App\Http\Controllers\UsernameController;
use Illuminate\Http\Request;
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

Route::get('/home', HomeController::class)->name('home')->middleware('auth');
Route::post('/contact', [PageController::class, 'send'])->name('contact.send');

Route::get('/search', [SearchController::class, 'show'])->name('search');

Route::get('/user/{user:username}', [ProfileController::class, 'show'])->name('profile.show');
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

    Route::post('/follow/{user:username}', [FollowController::class, 'store'])->name('follow.store');
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

//use App\Http\Controllers\DiaryController;
//use Illuminate\Support\Facades\Route;
// Diary CRUD
Route::post('/diary/store', [DiaryController::class, 'store'])
    ->name('diary.store')
    ->middleware('auth');

// Search & Filters
Route::get('/diary/search', \App\Http\Controllers\Diary\SearchController::class)
    ->name('diary.search')
    ->middleware('auth');

Route::get('/diary/tag/{tag}', [DiaryController::class, 'byTag'])
    ->name('diary.tag')
    ->middleware('auth');

Route::get('/diary/mood/{mood}', [DiaryController::class, 'byMood'])
    ->name('diary.mood')
    ->middleware('auth');

// Analytics & Stats
Route::get('/diary/stats', [DiaryController::class, 'stats'])
    ->name('diary.stats')
    ->middleware('auth');

// Engagement
Route::post('/diary/{diary}/like', [DiaryController::class, 'like'])
    ->name('diary.like')
    ->middleware('auth');

Route::post('/diary/{diary}/comment', [DiaryController::class, 'comment'])
    ->name('diary.comment')
    ->middleware('auth');

// Export
Route::get('/diary/export', [DiaryController::class, 'export'])
    ->name('diary.export')
    ->middleware('auth');

// Public views
Route::get('/diary/public/{diary}', [DiaryController::class, 'showPublic'])
    ->name('diary.public');

Route::get('/explore', [DiaryController::class, 'explore'])
    ->name('diary.explore')
    ->middleware('auth');
