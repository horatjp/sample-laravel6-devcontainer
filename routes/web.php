<?php

Route::group(['prefix' => 'backend', 'namespace' => 'Backend', 'as' => 'backend.'], function() {


    Route::get('login', 'AuthController@getLogin')->name('login');
    Route::post('login', 'AuthController@postLogin')->name('login');

    Route::group(['middleware' => 'backend.auth'], function() {

        Route::get('/', 'DashboardController@index')->name('index');

        Route::get('logout', 'AuthController@getLogout')->name('logout');

        // 記事
        Route::group(['prefix' => 'article', 'as' => 'article.'], function() {

            Route::get('/',                 'ArticleController@index')->name('index');
            Route::any('list',              'ArticleController@list')->name('list');
            Route::get('edit/{id?}',        'ArticleController@edit')->name('edit')->middleware('permission:edit article');
            Route::post('update/{id?}',     'ArticleController@update')->name('update')->middleware('permission:edit article');
            Route::get('show/{id}',         'ArticleController@show')->name('show');
            Route::get('changeActive/{id}', 'ArticleController@changeActive')->name('changeActive');
            Route::get('destroy/{id}',      'ArticleController@destroy')->name('destroy')->middleware('permission:edit article');

        });


        // 画像アップロード
        Route::group(['prefix' => 'uploadImage', 'as' => 'uploadImage.'], function() {

            Route::post('store', 'UploadImageControler@store')->name('store');
        });
    });

});



Route::group(['namespace' => 'Frontend'], function() {


    // インデックス
    Route::get('/', 'MainController@index');

});

Route::pattern('id', '[0-9]+');
