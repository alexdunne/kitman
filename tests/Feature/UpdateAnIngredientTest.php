<?php

namespace Tests\Feature;

use App\Company;
use App\Ingredient;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateAnIngredientTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function testAUserCanUpdateAnIngredient()
    {
        $company = factory(Company::class)->create();
        $user = factory(User::class)->make();
        $ingredient = factory(Ingredient::class)->make([
            'name' => 'Chicken',
        ]);

        $company->addUser($user);
        $company->addIngredient($ingredient);

        $ingredientData = [
            'name' => 'Pork',
            'unitOfMeasurement' => 'g',
        ];

        $response = $this
            ->actingAs($user)
            ->put("/ingredients/{$ingredient->id}", $ingredientData);

        $response->assertRedirect(route('ingredients.show', $ingredient->id));
        $response->assertSessionHas('success', 'Pork updated successfully');
    }

    public function testAGuestCannotUpdateAnIngredient()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $ingredient = factory(Ingredient::class)->make([
            'name' => 'Chicken',
        ]);

        $company->addIngredient($ingredient);

        $ingredientData = [
            'name' => 'Pork',
        ];

        $response = $this->put("/ingredients/{$ingredient->id}", $ingredientData);
        $response->assertRedirect('/login');
    }

    public function testAUserCannotUpdateAnIngredientBeloningToAnotherCompany()
    {
        $this->withExceptionHandling();

        $companyOne = factory(Company::class)->create();
        $companyTwo = factory(Company::class)->create();
        $userOne = factory(User::class)->make();
        $userTwo = factory(User::class)->make();
        $ingredient = factory(Ingredient::class)->make([
            'name' => 'Chicken',
        ]);

        $companyOne->addUser($userOne);
        $companyTwo->addUser($userTwo);
        $companyOne->addIngredient($ingredient);

        $ingredientData = [
            'name' => 'Pork',
        ];

        $response = $this
            ->actingAs($userTwo)
            ->put("/ingredients/{$ingredient->id}", $ingredientData);

        $response->assertStatus(403);
    }
}
