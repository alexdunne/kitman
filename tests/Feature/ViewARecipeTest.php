<?php

namespace Tests\Feature;

use App\Company;
use App\Ingredient;
use App\Recipe;
use App\RecipeIngredient;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ViewARecipeTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testAUserCanSeeARecipe()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create();

        $recipe = factory(Recipe::class)->create(['name' => 'Pizza base']);

        $firstIngredient = factory(Ingredient::class)->create(['name' => 'Flour']);
        $secondIngredient = factory(Ingredient::class)->create(['name' => 'Yeast']);

        $firstRecipeIngredient = factory(RecipeIngredient::class)->create([
            'quantity' => 800,
            'unitOfMeasurement' => 'g',
        ]);

        $secondRecipeIngredient = factory(RecipeIngredient::class)->create([
            'quantity' => 10,
            'unitOfMeasurement' => 'g',
        ]);

        $firstIngredient->addRecipeIngredient($firstRecipeIngredient);
        $secondIngredient->addRecipeIngredient($secondRecipeIngredient);

        $recipe->addRecipeIngredient($firstRecipeIngredient);
        $recipe->addRecipeIngredient($secondRecipeIngredient);

        $company->addUser($user);
        $company->addRecipe($recipe);

        $response = $this
            ->actingAs($user)
            ->get("/recipes/{$recipe->id}");

        $response->assertStatus(200);

        $response->assertSee($firstRecipeIngredient->ingredient->name);
        $response->assertSee((string)$firstRecipeIngredient->quantity);
        $response->assertSee($firstRecipeIngredient->unitOfMeasurement);

        $response->assertSee($secondRecipeIngredient->ingredient->name);
        $response->assertSee((string)$secondRecipeIngredient->quantity);
        $response->assertSee($secondRecipeIngredient->unitOfMeasurement);
    }

    public function testAUserCannotSeeOtherCompaniesRecipe()
    {
        $this->withExceptionHandling();

        $firstCompany = factory(Company::class)->create();
        $firstUser = factory(User::class)->create();
        $recipe = factory(Recipe::class)->create(['name' => 'Pizza base']);
        $firstCompany->addUser($firstUser);
        $firstCompany->addRecipe($recipe);

        $secondCompany = factory(Company::class)->create();
        $secondUser = factory(User::class)->create();
        $secondCompany->addUser($secondUser);

        $response = $this
            ->actingAs($secondUser)
            ->get("/recipes/{$recipe->id}");

        $response->assertStatus(404);
    }
}
