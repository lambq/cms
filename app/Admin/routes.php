<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('links', LinksController::class);
    $router->resource('articles', ArticleController::class);
    $router->resource('columns', ColumnController::class);
    $router->resource('sys-setups', SysSetupController::class);
    $router->resource('pages', PageController::class);
    
    $router->post('upload', 'UploadController@upImage');
});
