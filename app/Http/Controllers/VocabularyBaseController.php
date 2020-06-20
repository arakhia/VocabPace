<?php

namespace App\Http\Controllers;

use App\VocabularyBase;
use Illuminate\Http\Request;

class VocabularyBaseController extends Controller
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

    public function getVocabularyJSON($count)
    {
        $vocabulary = VocabularyBase::all()->random($count);
        return json_decode($vocabulary);
    }

}
