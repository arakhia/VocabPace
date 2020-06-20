<?php

namespace App\Http\Controllers;

use App\Events\UpdateBoardEvent;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('game.board');
    }

    public function update(Request $request)
    {
        //broadcast(new UpdateBoardEvent('updating'));
    }
}
