<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
        'name'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function addRecipeIngredient($recipeIngredient)
    {
        return $this->recipeIngredients()->save($recipeIngredient);
    }
}
