<?php

namespace Tests\Feature;

use App\Recipe;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ViewRecipesTest extends TestCase
{
  use DatabaseMigrations;

  public function testUserCanSeeAListOfTheirRecipes()
  {
    $user = factory(User::class)->create(['username' => 'legohead']);

    $recipe1 = factory(Recipe::class)->make(['name' => 'Chicken Tikka Masala']);
    $recipe2 = factory(Recipe::class)->make(['name' => 'Pizza']);
    $recipe3 = factory(Recipe::class)->make(['name' => 'Fajitas']);

    $user->recipes()->saveMany([
      $recipe1,
      $recipe2,
      $recipe3,
    ]);

    $response = $this->get("/users/{$user->username}/recipes");

    $response->assertStatus(200);
    $response->assertSee('Chicken Tikka Masala');
    $response->assertSee('Pizza');
    $response->assertSee('Fajitas');
  }
}
