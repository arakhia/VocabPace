<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    //broadcast(new UpdateBoardEvent('some message'));
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/game/{id}', 'GameController@game')->name('game.view');
Route::get('/games/live', 'GameController@list')->name('game.list');
Route::get('/game', 'GameController@index')->name('game');
Route::post('/game/create', 'GameController@create')->name('game.create');
Route::post('/game/update', 'GameController@update')->name('game.update');

Route::get('/vocabulary/{count}', 'VocabularyBaseController@getVocabularyJSON')->name('vocabulary.get-vocabulary-json');
//json endpoints
Route::get('json/games/list', 'GameController@listJson')->name('game.list-json');