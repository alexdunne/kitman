<?php

namespace Tests\Feature;

use App\Ingredient;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateARecipeTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testAUserCanCreateARecipe()
    {
        $user = factory(User::class)->create();
        $ingredientOne = factory(Ingredient::class)->create([
            'company_id' => $user->company->id
        ]);
        $ingredientTwo = factory(Ingredient::class)->create([
            'company_id' => $user->company->id
        ]);

        $recipesData = [
            'name' => 'Fajitas',
            'ingredients' => [
                [
                    'id' => $ingredientOne->id,
                    'quantity' => '500',
                ],
                [
                    'id' => $ingredientTwo->id,
                    'quantity' => '100',
                ],
            ],
            'instructions' => [
                [
                    'description' => 'Dice the chicken into squares',
                ],
                [
                    'description' => 'Slice the green pepper into even strips',
                ],
            ]
        ];

        $response = $this
            ->actingAs($user)
            ->post('/recipes', $recipesData);

        $response->assertRedirect(route('recipes.index'));
        $response->assertSessionHas('success', 'Fajitas recipe created successfully');
    }

    public function testAUserCannotCreateARecipeWithoutAName()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $ingredientOne = factory(Ingredient::class)->create([
            'company_id' => $user->company->id
        ]);

        $recipesData = [
            'ingredients' => [
                [
                    'id' => $ingredientOne->id,
                    'quantity' => '500',
                ],
            ],
            'instructions' => [
                [
                    'description' => 'Dice the chicken into squares',
                ],
            ]
        ];

        $response = $this
            ->actingAs($user)
            ->post('/recipes', $recipesData);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
    }

    public function testAUserCannotCreateARecipeWithoutAtLeastOneIngredient()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $recipesData = [
            'name' => 'Fajitas',
            'instructions' => [
                [
                    'description' => 'Dice the chicken into squares',
                ],
            ]
        ];

        $response = $this
            ->actingAs($user)
            ->post('/recipes', $recipesData);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
    }

    public function testAUserCannotCreateARecipeWithoutAtLeastOneInstruction()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $ingredientOne = factory(Ingredient::class)->create([
            'company_id' => $user->company->id
        ]);

        $recipesData = [
            'name' => 'Fajitas',
            'ingredients' => [
                [
                    'id' => $ingredientOne->id,
                    'quantity' => '500',
                ],
            ],
        ];

        $response = $this
            ->actingAs($user)
            ->post('/recipes', $recipesData);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
    }

    public function testGuestsCannotCreateRecipes()
    {
        $this->withExceptionHandling();

        $recipesData = [
            'name' => 'Fajitas',
            'ingredients' => [
                [
                    'name' => 'Chicken',
                    'quantity' => '500',
                    'unitOfMeasurement' => 'g',
                ],
                [
                    'name' => 'Green pepper',
                    'quantity' => '100',
                    'unitOfMeasurement' => 'g',
                ],
            ],
            'instructions' => [
                [
                    'description' => 'Dice the chicken into squares',
                ],
                [
                    'description' => 'Slice the green pepper into even strips',
                ],
            ]
        ];

        $response = $this->post('/recipes', $recipesData);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
