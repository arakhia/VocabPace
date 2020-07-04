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

    public function player()
    {
        return $this->hasMany('App\GameUser', 'game_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'App\GameUser');
    }
}
