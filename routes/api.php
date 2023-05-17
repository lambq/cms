<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::resource('article', 'Web\ReadController');
Route::resource('index', 'Api\IndexController');
Route::resource('search', 'Api\SearchController');
Route::resource('list', 'Api\ListController');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
