<?php

namespace App\Policies;

use App\Ingredient;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IngredientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ingredient.
     *
     * @param  \App\User $user
     * @param  \App\Ingredient $ingredient
     * @return mixed
     */
    public function view(User $user, Ingredient $ingredient)
    {
        return $user->company->id === $ingredient->company->id;
    }
}
