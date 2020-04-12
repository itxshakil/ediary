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


Route::view('/','welcome');

Auth::routes(['verify' => true]);

Route::get('/password/change','Auth\ChangePasswordController@showForm');
Route::post('/password/change','Auth\ChangePasswordController@change')->name('password.change');

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/about', 'PageController@about');
Route::get('/faq', 'PageController@faq');
Route::get('/contact', 'PageController@contact');
Route::get('/success', 'PageController@success');
Route::post('/contact', 'PageController@send')->name('contact.send');
Route::get('/request-data', 'PageController@requestData');
Route::post('/checkusername', 'HomeController@checkusername')->name('checkusername');

Route::middleware(['auth'])->group(function () {
    Route::get('/diaries', 'DiaryController@index');
    Route::get('/diaries/create', 'DiaryController@create')->name('diary.create');
    Route::post('/diaries', 'DiaryController@store')->name('diary.store');
});
