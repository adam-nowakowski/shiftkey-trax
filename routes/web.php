<?php

Route::get('/', 'AppController@welcomeView')->name('welcome');

Auth::routes();

Route::middleware('auth')
    ->group(function () {
        Route::get('/home', 'AppController@homeView')->name('home');
    });


