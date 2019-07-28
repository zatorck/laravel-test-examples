<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\UserAttribute;
use Faker\Generator as Faker;

$factory->define(UserAttribute::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
