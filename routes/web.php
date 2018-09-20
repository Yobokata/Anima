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

Route::get('/', 'HomeController@home');
Route::get('/home', 'HomeController@home');
Route::get('/about', function() {
    return view('about');
});

Route::get('/list', 'AnimeController@getAnimeList');
Route::get('/anime/{anime_id}', 'AnimeController@getEpisodeList');
Route::get('/watch/{anime_id}/{episode}', 'AnimeController@getEpisode');

Route::get('/transcode', 'TranscodeController@getTranscodingPage');
Route::post('/transcode_anime', 'TranscodeController@transcode');

Auth::routes();
