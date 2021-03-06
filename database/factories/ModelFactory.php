<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'company_id' => function () {
            return factory(\App\Company::class)->create()->id;
        }
    ];
});

$factory->define(App\Company::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(App\Recipe::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'company_id' => function () {
            return factory(\App\Company::class)->create()->id;
        },
    ];
});

$factory->define(App\Ingredient::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'unitOfMeasurement' => $faker->word,
        'company_id' => function () {
            return factory(\App\Company::class)->create()->id;
        },
    ];
});

$factory->define(App\RecipeIngredient::class, function (Faker\Generator $faker) {
    return [
        'quantity' => $faker->numberBetween(),
        'recipe_id' => function () {
            return factory(\App\Recipe::class)->create()->id;
        },
        'ingredient_id' => function () {
            return factory(\App\Ingredient::class)->create()->id;
        },
    ];
});

$factory->define(App\RecipeInstruction::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->sentence(),
        'order' => $faker->numberBetween(),
        'recipe_id' => function () {
            return factory(\App\Recipe::class)->create()->id;
        },
    ];
});