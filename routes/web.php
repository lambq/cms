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
    \Menu::make('MyNavBar', function ($menu) {
        $menu->add('Home');
        $menu->add('About', 'about');
        $menu->add('Services', 'services');
        $menu->add('Contact', 'contact');
    });
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
