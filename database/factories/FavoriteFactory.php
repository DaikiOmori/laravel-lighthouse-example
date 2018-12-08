<?php

$factory->define(\App\Models\Favorite::class, function () {

    /** @var \Illuminate\Database\Eloquent\Collection $comments */
    $comments = \App\Models\Comment::all();
    /** @var \Illuminate\Database\Eloquent\Collection $users */
    $users = \App\User::all();

    /** @var array $foreign_keys */
    $foreign_keys = getForeignKeysForFavoriteFactory($comments, $users);

    return [
        'comment_id' => $foreign_keys['comment_id'],
        'user_id' => $foreign_keys['user_id'],
    ];
});

/**
 * @param \Illuminate\Database\Eloquent\Collection $comments
 * @param \Illuminate\Database\Eloquent\Collection $users
 * @return array
 */
function getForeignKeysForFavoriteFactory(
    \Illuminate\Database\Eloquent\Collection $comments,
    \Illuminate\Database\Eloquent\Collection $users
): array
{
    $comment_id = $comments->random(1)->first()->id;
    $user_id = $users->random(1)->first()->id;

    $is_exists = \App\Models\Favorite::where('id', $comment_id)
        ->where('user_id', $user_id)
        ->exists();

    if ($is_exists) {
        getForeignKeysForFavoriteFactory($comments, $users);
    } else {
        return [
            'comment_id' => $comment_id,
            'user_id' => $user_id
        ];
    }
}
