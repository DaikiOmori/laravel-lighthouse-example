<?php

namespace App\Http\GraphQL\Mutations;

use App\User;

class DeleteUsersByEmail
{
    public function handle($root, array $args, $context, $info)
    {
        $email = $args['email'];
        User::where('email', 'like', $email)
            ->delete();

        $res = 'ok';

        return compact('res');
    }
}
