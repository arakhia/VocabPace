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

    public function guests()
    {
        return $this->hasMany('App\GameGuest', 'game_id', 'id');
    }

    public function hasPlayer($playerId)
    {
        return ($this->where([['id', $this->id],['player_01_id', $playerId]])
                        ->OrWhere([['id', $this->id],['player_02_id', $playerId]])
                            ->count()>0);
    }
}
