<?php

Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'AppController@getUser');

    Route::prefix('cars')
        ->as('cars.')
        ->group(function () {
            Route::get('/{all?}', 'CarController@index')->name('index');
            Route::get('/show/{car_id}', 'CarController@show')->name('show');
            Route::post('/store', 'CarController@store')->name('store');
            Route::delete('/destroy/{car}', 'CarController@destroy')->name('destroy');
        });

    Route::prefix('trips')
        ->as('trips.')
        ->group(function () {
            Route::get('/', 'TripController@index')->name('index');
            Route::get('/show/{car}', 'TripController@show')->name('show');
            Route::post('/store', 'TripController@store')->name('store');
        });
});
