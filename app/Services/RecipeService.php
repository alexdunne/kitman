<?php

namespace App\Services;

use App\Ingredient;
use App\Recipe;
use App\RecipeIngredient;
use App\RecipeInstruction;
use Illuminate\Support\Facades\Auth;

class RecipeService
{
    /**
     * @param $data array
     * @return Recipe
     */
    public function createRecipe($data)
    {
        $recipe = new Recipe(['name' => $data['name']]);
        Auth::user()->company->addRecipe($recipe);

        collect($data['ingredients'])->each(function ($ingredientData) use ($recipe) {
            $ingredient = Ingredient::findOrFail($ingredientData['id']);

            $recipeIngredient = new RecipeIngredient([
                'quantity' => $ingredientData['quantity'],
            ]);

            $recipeIngredient->ingredient()->associate($ingredient);
            $recipe->addRecipeIngredient($recipeIngredient);
        });

        collect($data['instructions'])->each(function ($instructionData, $key) use ($recipe) {
            $recipe->addInstruction(new RecipeInstruction([
                'description' => $instructionData['description'],
                'order' => $key,
            ]));
        });

        return $recipe;
    }
}