<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use App\RecipeIngredient;
use App\RecipeInstruction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Auth::user()->company->recipes()->latest()->get();

        return view('recipes.index', [
            'recipes' => $recipes,
        ]);
    }

    public function show(Recipe $recipe)
    {
        if (Auth::user()->cant('view', $recipe)) {
            abort(404);
        }

        $recipe->load(['instructions', 'recipeIngredients', 'recipeIngredients.ingredient']);

        return view('recipes.show', [
            'recipe' => $recipe
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:225',
            'ingredients.*.name' => 'required|string|max:225',
            'ingredients.*.quantity' => 'required|integer|min:1',
            'ingredients.*.unitOfMeasurement' => 'required|string|max:225',
            'instruction.*.description' => 'required|string',
        ]);

        $recipe = new Recipe(['name' => $request->name]);
        Auth::user()->company->addRecipe($recipe);

        collect($request->ingredients)->each(function ($ingredientData) use ($recipe) {
            $ingredient = Ingredient::findByName($ingredientData['name']);

            if (!$ingredient) {
                $ingredient = new Ingredient(['name' => $ingredientData['name']]);
                Auth::user()->company->addIngredient($ingredient);
            }

            $recipeIngredient = new RecipeIngredient([
                'quantity' => $ingredientData['quantity'],
                'unitOfMeasurement' => $ingredientData['unitOfMeasurement'],
            ]);

            $recipeIngredient->ingredient()->associate($ingredient);
            $recipe->addRecipeIngredient($recipeIngredient);
        });

        collect($request->instructions)->each(function ($instructionData, $key) use ($recipe) {
            $recipe->addInstruction(new RecipeInstruction([
                'description' => $instructionData['description'],
                'order' => $key,
            ]));
        });

        return redirect()
            ->route('recipes')
            ->with('success', "{$recipe->name} recipe created successfully");
    }
}