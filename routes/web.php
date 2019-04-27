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

Route::get('/', 'HomeController@index');
Route::resource('/league', 'LeagueController');

Route::get('/league/{id}/results', 'FixtureController@results');
Route::get('/fixture/{id}/results/edit', 'FixtureController@editResult');
Route::post('/fixture/{id}/results/update', 'FixtureController@updateResult');
Route::post('/playNextFixture/{id}', 'FixtureController@playNextFixture');
Route::post('/playAllFixture/{id}', 'FixtureController@playAllFixture');
