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
Route::get('/about', 'HomeController@about');


Route::get('/list', 'ListController@getAnimeList');
Route::get('/watch/{anime_id}/{episode}', 'EpisodeController@getEpisode');
Route::get('/anime/{anime_id}', 'AnimeController@getEpisodeList');

Route::get('/encode', 'EncodeController@getEncodingPage');
Route::get('/download/{anime}', 'AnimeController@insertAnime');

Auth::routes();
