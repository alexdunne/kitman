<?php

namespace Tests\Feature;

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

        $response = $this
            ->actingAs($user)
            ->post('/recipes', $recipesData);

        $response->assertRedirect(route('recipes'));
        $response->assertSessionHas('success', 'Fajitas recipe created successfully');
    }
}
