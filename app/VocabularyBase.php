<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VocabularyBase extends Model
{
    protected $table = "vocabulary_base";
    protected $fillable = [
        'value',
    ];

    public function results()
    {
        return $this->hasMany('App\GameResults', 'vocabulary_id', 'id');
    }
}
