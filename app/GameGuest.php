<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameGuest extends Model
{
    protected $fillable = [
        'username', 'email', 'game_id', 'join_time', 'leave_time'
    ];

    public function game()
    {
        return $this->belongsTo('App\Game', 'game_id', 'id');
    }
}
