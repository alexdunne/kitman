<?php

namespace App\Policies;

use App\Recipe;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the recipe.
     *
     * @param  \App\User $user
     * @param  \App\Recipe $recipe
     * @return mixed
     */
    public function view(User $user, Recipe $recipe)
    {
        return $user->company->id === $recipe->company->id;
    }
}
