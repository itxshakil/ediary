<?php

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

Route::get('/password/change', 'Auth\ChangePasswordController@showForm')->middleware('auth');
Route::post('/password/change', 'Auth\ChangePasswordController@change')->name('password.change')->middleware('auth');

Route::view('/home', 'home')->name('home')->middleware('auth');
Route::post('/contact', 'PageController@send')->name('contact.send');
Route::post('/checkusername', 'UsernameController@checkUsernameAvailibility')->name('checkusername');

Route::get('/search', 'SearchController@show');

Route::get('/user/{user:username}', 'ProfileController@show');
Route::post('/profile/{user:username}', 'ProfileController@update');

Route::post('/profile/{user:username}/follow', 'FollowController@store')->middleware('auth');

Route::post('/api/users/{user:username}/avatar', 'Api\UserAvatarController@store')->middleware('auth');

Route::view('/about', 'pages.about');
Route::view('/faq', 'pages.faq');
Route::view('/contact', 'pages.contact');
Route::view('/success', 'pages.success');
Route::view('/request-data', 'pages.request-data')->middleware('password.confirm');
Route::post('/request-data', 'UserDataController@send')->middleware('password.confirm')->name('request.data');

Route::middleware(['auth'])->group(function () {
  Route::get('/diaries', 'DiaryController@index');
  Route::get('/diaries/create', 'DiaryController@create')->name('diary.create');
  Route::post('/diaries', 'DiaryController@store')->name('diary.store');
});

/* Sitemap Route*/
Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap.xml');
Route::get('/sitemap.xml/users', 'SitemapController@users');

Route::get('/settings', 'SettingController')->middleware('verified');
Route::put('/username', 'UsernameController@update')->middleware('verified');

Route::view('/blog','blogs.index');
Route::view('/blogs/how-to-write-diary','blogs.howtowrite');
Route::view('/blogs/these-8-good-things-will-happen-when-you-start-writing-diary','blogs.these8goodthings');
Route::view('/blogs/how-to-start-writing-a-diary','blogs.howtostartwritingadiary');