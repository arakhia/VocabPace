<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\VocabularyBase::class, function (Faker $faker) {
    return [
        'value' => $faker->word(10),
    ];
});
