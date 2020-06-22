<?php

namespace App\Http\Controllers;

use App\Events\UpdateBoardEvent;
use App\Game;
use App\VocabularyBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    private $vocabularyBaseController;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(VocabularyBaseController $vocabularyBaseController)
    {
        $this->middleware('auth');
        $this->vocabularyBaseController = $vocabularyBaseController;
    }

    public function index()
    {
        return view('game.board');
    }

    public function game($id)
    {
        $game = Game::findOrFail($id);
        return $result = [
            'gameId' => $game->id,
            'vocabulary'=> $this->vocabularyBaseController->getVocabularyJSON(15)
        ];
    }

    public function create(Request $request)
    {
        $game = new Game();
        $game->player_01_id = Auth::user()->id;
        $game->player_02_id = Auth::user()->id;
        $game->save();
        return $result = [
            'gameId' => $game->id,
            'vocabulary'=> $this->vocabularyBaseController->getVocabularyJSON($request->get('count'))
        ];
    }

    public function update(Request $request)
    {
        $game = Game::findOrFail($request->get('gameId'));
        $game->result()->create([
            'game_id' => $game->id,
            'vocabulary_id' => $request->get('vocabularyId'),
            'player_id' => $request->get('playerId'),
            'answer' => $request->get('answer'),
            'status' => $request->get('status'),
        ]);
    }
}
