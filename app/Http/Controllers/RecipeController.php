<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\Recipe;
use App\Services\RecipeService;
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

    public function create()
    {
        return view('recipes.create', [
            'ingredients' => Auth::user()->company->ingredients
        ]);
    }

    public function store(Request $request, RecipeService $recipeService)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:225',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|integer',
            'ingredients.*.quantity' => 'required|integer|min:1',
            'instructions' => 'required|array|min:1',
            'instructions.*.description' => 'required|string|min:5',
        ]);

        collect($request->ingredients)->every(function ($ingredientData) {
            $ingredient = Ingredient::find($ingredientData['id']);
            return $ingredient && $this->authorize('view', $ingredient);
        });

        $recipe = $recipeService->createRecipe($request->all());

        return response()->json(compact('recipe'));
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

}