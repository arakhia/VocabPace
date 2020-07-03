<?php

namespace App;

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

    public function games()
    {
        return $this->firstPlayer->merge($this->secondPlayer);
    }

    public function firstPlayer()
    {
        return $this->hasMany('App\Game', 'player_01_id', 'id');
    }

    public function secondPlayer()
    {
        return $this->hasMany('App\Game', 'player_02_id', 'id');
    }

    public function game_result()
    {
        return $this->hasMany('App\GameResults', 'player_id', 'id');
    }

    public function vocabulary()
    {
        return $this->belongsToMany('App\VocabularyBase', 'App\GameResults', 'player_id', 'vocabulary_id');
    }
}
