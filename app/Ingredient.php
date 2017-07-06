<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name'
    ];

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function addRecipeIngredient($recipeIngredient)
    {
        return $this->recipeIngredients()->save($recipeIngredient);
    }
}
