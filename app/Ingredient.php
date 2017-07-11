<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name'
    ];

    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }

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
