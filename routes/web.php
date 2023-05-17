<?php


Route::group(['namespace'=>'Web'],function (){
    
    Route::get('/', 'PagesController@root')->name('root')->middleware('page-cache');

    Route::paginate('/search/{name}', 'SearchController@index')->name('search')->middleware('page-cache');

    Route::paginate('/baidu', 'ArticlesController@list')->name('baidu')->middleware('page-cache');

    Route::paginate('/weiruan', 'ArticlesController@list')->name('weiruan')->middleware('page-cache');

    Route::paginate('/ali', 'ArticlesController@list')->name('ali')->middleware('page-cache');

    Route::paginate('/huawei', 'ArticlesController@list')->name('huawei')->middleware('page-cache');
    
    Route::paginate('/update', 'ArticlesController@update')->name('update')->middleware('page-cache');

    Route::paginate('/top', 'ArticlesController@top')->name('top')->middleware('page-cache');

    Route::get('/show/{id}.html', 'ShowController@show')->name('show');
    Route::get('/show1/{id}.html', 'ArticlesController@show')->name('show');
    
    Route::get('/pages/{title}.html', 'PagesController@pages')->middleware('page-cache');
});