<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
