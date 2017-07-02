<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    public function getPublicRecipesForUser(User $user)
    {
        return $user->recipes()->where('public', true)->get();
    }
}