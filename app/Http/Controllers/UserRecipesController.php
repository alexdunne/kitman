<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserRecipesController extends Controller
{
    public function index(User $user)
    {
        return view('users.recipes.show', ['user' => $user]);
    }
}
