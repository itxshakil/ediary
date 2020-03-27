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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/about', 'PageController@about');
Route::get('/faq', 'PageController@faq');
Route::get('/contact', 'PageController@contact');
Route::get('/request-data', 'PageController@requestData');
Route::post('/checkusername', 'HomeController@checkusername')->name('checkusername');

Route::middleware(['auth'])->group(function () {
    Route::get('/diaries', 'DiaryController@index')->name('home');
    Route::get('/diaries/create', 'DiaryController@create')->name('diary.create');
    Route::post('/diaries', 'DiaryController@store')->name('diary.store');
});
