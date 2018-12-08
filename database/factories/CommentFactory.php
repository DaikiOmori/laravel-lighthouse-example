<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Comment::class, function (Faker $faker) {

    /** @var \Illuminate\Database\Eloquent\Collection $articles */
    $articles = \App\Models\Article::all();
    /** @var \Illuminate\Database\Eloquent\Collection $users */
    $users = \App\User::all();

    /** @var array $foreign_keys */
    $foreign_keys = getForeignKeysByCommentFactory($articles, $users);

    return [
        'article_id' => $foreign_keys['article_id'],
        'user_id' =>   $foreign_keys['user_id'],
        'body' => $faker->text,
    ];
});

/**
 * @param \Illuminate\Database\Eloquent\Collection $articles
 * @param \Illuminate\Database\Eloquent\Collection $users
 * @return array
 */
function getForeignKeysByCommentFactory(
    \Illuminate\Database\Eloquent\Collection $articles,
    \Illuminate\Database\Eloquent\Collection $users
): array
{
    $article_id = $articles->random(1)->first()->id;
    $user_id = $users->random(1)->first()->id;

    $is_exists = \App\Models\Comment::where('article_id', $article_id)
        ->where('user_id', $user_id)
        ->exists();

    if ($is_exists) {
        getForeignKeysByCommentFactory($articles, $users);
    } else {
        return [
            'article_id' => $article_id,
            'user_id' => $user_id
        ];
    }
}
