<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateAnIngredientTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testAUserCanCreateAnIngredient()
    {
        $user = factory(User::class)->create();

        $ingredientData = [
            'name' => 'Chicken',
        ];

        $response = $this
            ->actingAs($user)
            ->post("/ingredients", $ingredientData);

        $response->assertRedirect(route('ingredients.index'));
        $response->assertSessionHas('success', 'Chicken created successfully');
    }

    public function testAUserCannotCreateAnIngredientWithoutAName()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $ingredientData = [];

        $response = $this
            ->actingAs($user)
            ->post("/ingredients", $ingredientData);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
    }

    public function testAGuestCannotCreateAnIngredient()
    {
        $this->withExceptionHandling();
        
        $ingredientData = [
            'name' => 'Chicken',
        ];

        $response = $this
            ->post("/ingredients", $ingredientData);

        $response->assertRedirect(route('login'));
    }
}
