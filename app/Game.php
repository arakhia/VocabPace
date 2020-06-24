<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function result()
    {
        return $this->hasMany('App\GameResults', 'game_id', 'id');
    }

    public function vocabulary()
    {
        return $this->belongsToMany('App\VocabularyBase', 'App\GameResults', 'game_id', 'vocabulary_id');
    }
}
