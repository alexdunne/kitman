<?php

namespace App\Http\Controllers;

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
}
