<?php

namespace App\Http\Controllers;

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
        return view('recipes.create');
    }

    public function store(Request $request, RecipeService $recipeService)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:225',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.name' => 'required|string|max:225',
            'ingredients.*.quantity' => 'required|integer|min:1',
            'ingredients.*.unitOfMeasurement' => 'required|string|max:225',
            'instructions' => 'required|array|min:1',
            'instructions.*.description' => 'required|string|min:5',
        ]);

        $recipe = $recipeService->createRecipe($request->all());

        return redirect()
            ->route('recipes.index')
            ->with('success', "{$recipe->name} recipe created successfully");
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