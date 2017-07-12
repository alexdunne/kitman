<?php

namespace App\Http\Controllers;

use App\Ingredient;
use Illuminate\Support\Facades\Auth;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Auth::user()->company->ingredients()->get();

        return view('ingredients.index', [
            'ingredients' => $ingredients
        ]);
    }

    public function show(Ingredient $ingredient)
    {
        if (Auth::user()->cant('view', $ingredient)) {
            abort(403);
        }

        return view('ingredients.show', [
            'ingredient' => $ingredient,
        ]);
    }
}
