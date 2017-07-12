<?php

namespace App\Http\Controllers;

use App\Ingredient;
use Illuminate\Http\Request;
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

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:225',
        ]);

        $ingredient = new Ingredient(['name' => $request->name]);
        Auth::user()->company->addIngredient($ingredient);

        return redirect()
            ->route('ingredients.index')
            ->with('success', "{$ingredient->name} created successfully");
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

    public function update(Request $request, Ingredient $ingredient)
    {
        if (Auth::user()->cant('update', $ingredient)) {
            abort(403);
        }

        $this->validate($request, [
            'name' => 'required|string|min:3|max:225',
        ]);

        $ingredient->name = $request->name;
        $ingredient->save();

        return redirect()
            ->route('ingredients.show', ['ingredient' => $ingredient])
            ->with('success', "{$ingredient->name} updated successfully");
    }
}
