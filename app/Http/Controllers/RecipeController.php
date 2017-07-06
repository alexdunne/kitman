<?php

namespace App\Http\Controllers;

use App\Recipe;
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

        return view('recipes.show', [
            'recipe' => $recipe
        ]);
    }
}
