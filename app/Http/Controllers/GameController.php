<?php

namespace App\Http\Controllers;

use App\Events\UpdateBoardEvent;
use App\Game;
use App\GameResults;
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

    public function list()
    {
        return view('game.list');
    }

    public function game($id)
    {
        $game = Game::findOrFail($id);
        return [
            'gameId' => $game->id,
            'vocabulary'=> json_decode($game->vocabulary),
            'results' => json_decode($game->result)
        ];
    }

    public function create(Request $request)
    {
        $game = new Game();
        $game->player_01_id = Auth::user()->id;
        $game->player_02_id = Auth::user()->id;
        $game->save();
        
        $vocabulary = $this->vocabularyBaseController->getVocabularyJSON(15);
        foreach($vocabulary as $item){
            $game->result()->create([
                'game_id' => $game->id,
                'vocabulary_id' => $item->id,
            ]);
        }
    }

    public function update(Request $request)
    {
        $game = Game::findOrFail($request->get('gameId'));
        $result = GameResults::where('vocabulary_id', $request->get('vocabularyId'))->firstOrFail();
        $result->player_id = $request->get('playerId');
        $result->answer = $request->get('answer');
        $result->status = $request->get('status');
        $result->save();

        broadcast(new UpdateBoardEvent([
            'results' => json_decode($game->result),
        ]));
    }
}
