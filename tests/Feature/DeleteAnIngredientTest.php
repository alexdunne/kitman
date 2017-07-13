<?php

namespace Tests\Feature;

use App\Company;
use App\Ingredient;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteAnIngredientTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testAUserCanDeleteAnIngredientTheirCompanyOwns()
    {
        $company = factory(Company::class)->create();
        $user = factory(User::class)->make();
        $ingredient = factory(Ingredient::class)->make();

        $company->addUser($user);
        $company->addIngredient($ingredient);

        $response = $this
            ->actingAs($user)
            ->delete(route('ingredients.delete', [
                'ingredient' => $ingredient->id
            ]));

        $response->assertRedirect(route('ingredients.index'));
        $response->assertSessionHas('success', "{$ingredient->name} successfully deleted");
    }

    public function testAGuestCannotDeleteAnIngredientTheirCompanyOwns()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $ingredient = factory(Ingredient::class)->make();

        $company->addIngredient($ingredient);

        $response = $this
            ->delete(route('ingredients.delete', [
                'ingredient' => $ingredient->id
            ]));

        $response->assertRedirect('/login');
    }

    public function testAUserCannotDeleteAnIngredientAnotherCompanyOwns()
    {
        $this->withExceptionHandling();

        $companyOne = factory(Company::class)->create();
        $companyTwo = factory(Company::class)->create();
        $userOne = factory(User::class)->make();
        $userTwo = factory(User::class)->make();
        $ingredient = factory(Ingredient::class)->make();

        $companyOne->addUser($userOne);
        $companyTwo->addUser($userTwo);
        $companyOne->addIngredient($ingredient);

        $response = $this
            ->actingAs($userTwo)
            ->delete(route('ingredients.delete', [
                'ingredient' => $ingredient->id
            ]));

        $response->assertStatus(403);
    }
}
