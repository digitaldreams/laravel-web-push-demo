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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('notifications/read-all', 'NotificationController@markAllRead')->name('notifications.markAllRead');
Route::get('notifications/read', 'NotificationController@read')->name('notifications.read');
Route::get('notifications', 'NotificationController@index')->name('notifications.index');
Route::get('notifications/push/subscribe', 'NotificationController@pushSubscribe')->name('notifications.pushSubscribe');
