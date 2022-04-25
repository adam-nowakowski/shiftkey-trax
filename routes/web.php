<?php

Auth::routes();

Route::get('/', 'AppController@welcomeView')->name('welcome');
Route::get('/home', 'AppController@homeView')->name('home')->middleware('auth');
