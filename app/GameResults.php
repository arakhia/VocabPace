<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameResults extends Model
{
    protected $fillable = [
        'game_id', 'vocabulary_id', 'player_id', 'answer', 'status'
    ];
    
    public function game()
    {
        return $this->belongsTo('App\Game', 'game_id', 'id');
    }

    public function vocabulary()
    {
        return $this->belongsTo('App\VocabularyBase', 'vocabulary_id', 'id');
    }

    public function player()
    {
        return $this->belongsTo('App\User', 'player_id', 'id');
    }
}
