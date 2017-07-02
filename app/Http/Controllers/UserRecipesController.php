<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRecipesController extends Controller
{
    public function index(User $user, UserRepository $repo)
    {
        $recipes = Auth::user()->id === $user->id
            ? $user->recipes
            : $repo->getPublicRecipesForUser($user);

        return view('users.recipes.show', ['recipes' => $recipes]);
    }
}
