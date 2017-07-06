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

    public function instructions()
    {
        return $this->hasMany(RecipeInstruction::class);
    }

    public function addRecipeIngredient(RecipeIngredient $recipeIngredient)
    {
        return $this->recipeIngredients()->save($recipeIngredient);
    }

    public function addInstruction(RecipeInstruction $recipeInstruction)
    {
        return $this->instructions()->save($recipeInstruction);
    }
}
