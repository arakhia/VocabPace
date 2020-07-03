<?php

namespace App\Http\Controllers;

use App\Game;
use App\GameResults;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function getUserVocabulary()
    {
        $userVocabulary = Auth::user()->vocabulary()->withCount('results')->get()->unique("id");
        $userChallenges = Auth::user()->games()->groupBy(function (Game $vocab){
            return Carbon::parse($vocab->created_at)->format('M Y');
        });

        return [
            'vocabulary' => json_decode($userVocabulary),
            'challenges' => json_decode($userChallenges)
        ];
    }
}
