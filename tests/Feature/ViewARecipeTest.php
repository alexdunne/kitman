<?php

namespace Tests\Feature;

use App\Company;
use App\Ingredient;
use App\Recipe;
use App\RecipeIngredient;
use App\RecipeInstruction;
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

        $firstIngredient = factory(Ingredient::class)->create([
            'name' => 'Flour',
            'unitOfMeasurement' => 'g',
        ]);
        $secondIngredient = factory(Ingredient::class)->create([
            'name' => 'Yeast',
            'unitOfMeasurement' => 'g',
        ]);

        $company->addIngredient($firstIngredient);
        $company->addIngredient($secondIngredient);

        $firstRecipeIngredient = factory(RecipeIngredient::class)->create(['quantity' => 800,]);
        $secondRecipeIngredient = factory(RecipeIngredient::class)->create(['quantity' => 10,]);

        $firstIngredient->addRecipeIngredient($firstRecipeIngredient);
        $secondIngredient->addRecipeIngredient($secondRecipeIngredient);

        $recipe->addRecipeIngredient($firstRecipeIngredient);
        $recipe->addRecipeIngredient($secondRecipeIngredient);

        $firstRecipeInstruction = factory(RecipeInstruction::class)->create([
            'description' => 'Mix the flour and the yeast',
            'order' => 1,
        ]);

        $secondRecipeInstruction = factory(RecipeInstruction::class)->create([
            'description' => 'Place in the grease proof tin',
            'order' => 2,
        ]);

        $recipe->addInstruction($firstRecipeInstruction);
        $recipe->addInstruction($secondRecipeInstruction);

        $company->addUser($user);
        $company->addRecipe($recipe);

        $response = $this
            ->actingAs($user)
            ->get("/recipes/{$recipe->id}");

        $response->assertStatus(200);

        $response->assertSee($firstRecipeIngredient->ingredient->name);
        $response->assertSee((string)$firstRecipeIngredient->quantity);
        $response->assertSee($firstRecipeIngredient->ingredient->unitOfMeasurement);

        $response->assertSee($secondRecipeIngredient->ingredient->name);
        $response->assertSee((string)$secondRecipeIngredient->quantity);
        $response->assertSee($secondRecipeIngredient->ingredient->unitOfMeasurement);

        $response->assertSee($firstRecipeInstruction->description);
        $response->assertSee($secondRecipeInstruction->description);
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
