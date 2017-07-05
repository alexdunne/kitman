<?php

namespace Tests\Feature;

use App\Company;
use App\Recipe;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ViewAListOfRecipesTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testAUserCanSeeAListOfRecipesForTheirCompany()
    {
        $company = factory(Company::class)->create();
        $user = factory(User::class)->create([
            'company_id' => $company->id,
        ]);
        $recipe1 = factory(Recipe::class)->create(['name' => 'Pizza']);
        $recipe2 = factory(Recipe::class)->create(['name' => 'Curry']);
        $recipe3 = factory(Recipe::class)->create(['name' => 'Fajitas']);

        $company->addUser($user);
        $company->addRecipe($recipe1);
        $company->addRecipe($recipe2);
        $company->addRecipe($recipe3);

        $response = $this
            ->actingAs($user)
            ->get('/recipes');

        $response->assertSee('Curry');
        $response->assertSee('Fajitas');
        $response->assertSee('Pizza');
    }

    public function testAUserCannotSeeOtherCompaniesRecipes()
    {
        $firstCompany = factory(Company::class)->create();
        $secondCompany = factory(Company::class)->create();

        $firstUser = factory(User::class)->create(['company_id' => $firstCompany->id]);
        $secondUser = factory(User::class)->create(['company_id' => $secondCompany->id]);

        $firstRecipe = factory(Recipe::class)->create(['name' => 'Pizza']);
        $secondRecipe = factory(Recipe::class)->create(['name' => 'Curry']);
        $thirdRecipe = factory(Recipe::class)->create(['name' => 'Fajitas']);

        $firstCompany->addUser($firstUser);
        $secondCompany->addUser($secondUser);

        $firstCompany->addRecipe($firstRecipe);
        $firstCompany->addRecipe($thirdRecipe);
        $secondCompany->addRecipe($secondRecipe);

        $response = $this
            ->actingAs($secondUser)
            ->get('/recipes');

        $response->assertSee('Curry');
        $response->assertDontSee('Fajitas');
        $response->assertDontSee('Pizza');
    }

    public function testAUserIsInformedWhenThereAreNoRecipesForTheirCompany()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create();

        $company->addUser($user);

        $response = $this
            ->actingAs($user)
            ->get('/recipes');

        $response->assertSee('No recipes found.');
    }
}
