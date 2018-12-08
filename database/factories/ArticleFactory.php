<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Article::class, function (Faker $faker) {

    $users = \App\User::all();

    return [
        'user_id' => $users->random(1)->first()->id,
        'title' => $faker->word,
        'body' => $faker->text,
    ];
});
