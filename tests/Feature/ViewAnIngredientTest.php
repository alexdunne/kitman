<?php

namespace Tests\Feature;

use App\Company;
use App\Ingredient;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ViewAnIngredientTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testAUserCanSeeAnIngredientTheirCompanyOwns()
    {
        $company = factory(Company::class)->create();
        $user = factory(User::class)->make();
        $ingredient = factory(Ingredient::class)->make();

        $company->addUser($user);
        $company->addIngredient($ingredient);

        $response = $this
            ->actingAs($user)
            ->get("/ingredients/{$ingredient->id}");

        $response->assertSee($ingredient->name);
    }

    public function testAGuestCannotSeeAnIngredient()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $ingredient = factory(Ingredient::class)->make();

        $company->addIngredient($ingredient);

        $response = $this->get("/ingredients/{$ingredient->id}");

        $response->assertRedirect(route('login'));
    }

    public function testAUserCannotSeeAnIngredientThatBelongsToAnotherCompany()
    {
        $this->withExceptionHandling();

        $firstCompany = factory(Company::class)->create();
        $firstCompanyUser = factory(User::class)->make();

        $secondCompany = factory(Company::class)->create();
        $secondCompanyUser = factory(User::class)->make();

        $ingredient = factory(Ingredient::class)->make();

        $firstCompany->addUser($firstCompanyUser);
        $firstCompany->addIngredient($ingredient);

        $secondCompany->addUser($secondCompanyUser);

        $response = $this
            ->actingAs($secondCompanyUser)
            ->get("/ingredients/{$ingredient->id}");

        $response->assertStatus(403);
    }
}
