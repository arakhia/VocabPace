<?php

namespace App\Http\Controllers;

use App\GameResults;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function getUserVocabulary()
    {
        $userVocabulary = Auth::user()->vocabulary()->withCount('results')->get()->unique("id");
        return [
            'vocabulary' => json_decode($userVocabulary)
        ];
    }
}
