<?php
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/commands/all', 'ReplyController@commands');

Route::get('/replies/all', 'ReplyController@all');
Route::post('/replies', 'ReplyController@store');
Route::put('/replies/{id}', 'ReplyController@update');
Route::delete('/replies/{id}', 'ReplyController@destroy');
