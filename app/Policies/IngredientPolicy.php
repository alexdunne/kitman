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
     * @return boolean
     */
    public function view(User $user, Ingredient $ingredient)
    {
        return $user->company->id === $ingredient->company->id;
    }

    /**
     * Determine whether the user can update the ingredient
     *
     * @param User $user
     * @param Ingredient $ingredient
     * @return boolean
     */
    public function update(User $user, Ingredient $ingredient)
    {
        return $user->company->id === $ingredient->company->id;
    }

    /**
     * Determine whether the user can delete the ingredient
     *
     * @param User $user
     * @param Ingredient $ingredient
     * @return boolean
     */
    public function delete(User $user, Ingredient $ingredient)
    {
        return $user->company->id === $ingredient->company->id;
    }
}
