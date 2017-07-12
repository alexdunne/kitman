<?php

namespace Tests\Feature;

use App\Company;
use App\Ingredient;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ViewAListOfIngredientsTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testAUserCanSeeAListOfIngredientsTheirCompanyOwns()
    {
        $company = factory(Company::class)->create();
        $user = factory(User::class)->make();
        $ingredientOne = factory(Ingredient::class)->make();
        $ingredientTwo = factory(Ingredient::class)->make();
        $ingredientThree = factory(Ingredient::class)->make();

        $company->addUser($user);
        $company->addIngredient($ingredientOne);
        $company->addIngredient($ingredientTwo);
        $company->addIngredient($ingredientThree);

        $response = $this
            ->actingAs($user)
            ->get("/ingredients");

        $response->assertSee($ingredientOne->name);
        $response->assertSee($ingredientTwo->name);
        $response->assertSee($ingredientThree->name);
    }

    public function testAGuestCannotSeeAListOfIngredients()
    {
        $this->withExceptionHandling();

        $response = $this->get("/ingredients");
        $response->assertStatus(302);
        $response->assertRedirect("/login");
    }

    public function testAUserCannotSeeAListOfIngredientsAnotherCompanyOwns()
    {
        $companyOne = factory(Company::class)->create();
        $userOne = factory(User::class)->make();

        $companyTwo = factory(Company::class)->create();
        $userTwo = factory(User::class)->make();

        $ingredientOne = factory(Ingredient::class)->make();
        $ingredientTwo = factory(Ingredient::class)->make();
        $ingredientThree = factory(Ingredient::class)->make();

        $companyOne->addUser($userOne);
        $companyTwo->addUser($userTwo);
        $companyOne->addIngredient($ingredientOne);
        $companyTwo->addIngredient($ingredientTwo);
        $companyOne->addIngredient($ingredientThree);

        $response = $this
            ->actingAs($userTwo)
            ->get("/ingredients");

        $response->assertDontSee($ingredientOne->name);
        $response->assertDontSee($ingredientThree->name);
        $response->assertSee($ingredientTwo->name);
    }
}
