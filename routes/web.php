<?php

Auth::routes();

Route::middleware('auth')
    ->group(function () {
        Route::get('/', 'AppController@welcomeView')->name('welcome');
        Route::get('/home', 'AppController@homeView')->name('home');
    });


