<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('games/list', 'GameController@listJson');
Route::get('game/{id}', 'GameController@game');
Route::post('game/create', 'GameController@update');
Route::post('game/update', 'GameController@update');
Route::post('game/guest/join', 'GameController@joinGameAsGuest');
Route::get('game/{id}/guests', 'GameController@getGuestsList');
Route::post('game/create', 'GameController@create');
Route::post('game/join', 'GameController@joinGameAsPlayer');

# No Auth
Route::get('game/{id}/status', 'GameController@getGameStatus');