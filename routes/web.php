<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/recipes', 'RecipeController@index')->name('recipes.index');
    Route::post('/recipes', 'RecipeController@store')->name('recipes.store');
    Route::get('/recipes/{recipe}', 'RecipeController@show')->name('recipes.show');

    Route::get('/ingredients', 'IngredientController@index')->name('ingredients.index');
    Route::get('/ingredients/create', 'IngredientController@create')->name('ingredients.create');
    Route::post('/ingredients', 'IngredientController@store')->name('ingredients.store');
    Route::get('/ingredients/{ingredient}', 'IngredientController@show')->name('ingredients.show');
    Route::put('/ingredients/{ingredient}', 'IngredientController@update')->name('ingredients.update');
});