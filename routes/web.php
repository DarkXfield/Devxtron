<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/admin', 'HomeController@admin')->name('admin');
Route::get('/contact', 'HomeController@fetchContacts');
Route::get('/contact/{id}', 'HomeController@contacts');
Route::get('/message', 'MessageController@fetchMessages');
Route::post('/message', 'MessageController@sendMessages');
Route::post('/new', 'MessageController@sendNewMessages');
Route::get('/message/{id}', 'MessageController@messages');
Route::get('/current', 'MessageController@user');
Route::post('/profiles', 'HomeController@avatar');
Route::get('{path}','HomeController@admin')->where( 'path', '([A-z\d\-/_.]+)?' );