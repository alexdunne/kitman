<?php

namespace App\Providers;

use App\Services\RecipeService;
use Illuminate\Support\ServiceProvider;

class RecipeServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RecipeService::class, function ($app) {
            return new RecipeService();
        });
    }
}
