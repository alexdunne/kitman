<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function addUser(User $user)
    {
        $this->users()->save($user);
    }

    public function addRecipe(Recipe $recipe)
    {
        $this->recipes()->save($recipe);
    }

    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients()->save($ingredient);
    }
}
