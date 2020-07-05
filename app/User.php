<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function game_result()
    {
        return $this->hasMany('App\GameResults', 'player_id', 'id');
    }

    public function vocabulary()
    {
        return $this->belongsToMany('App\VocabularyBase', 'App\GameResults', 'player_id', 'vocabulary_id');
    }

    public function games()
    {
        return $this->belongsToMany('App\Game', 'App\GameUser');
    }

    public function oldGames()
    {
        return $this->games()->get()->groupBy(function (Game $game){
            return Carbon::parse($game->created_at)->format('M Y');
        });
    }

    public function oldVocabulary()
    {
        return $this->vocabulary()->withCount('results')->get()->unique("id");
    }

}
