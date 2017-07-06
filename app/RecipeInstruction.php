<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeInstruction extends Model
{
    protected $fillable = [
        'description', 'order',
    ];
}
