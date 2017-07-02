<?php

namespace Tests\Unit;

use App\Recipe;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testAUsersPublicRecipesCanBeFound()
    {
        $user = factory(User::class)->create();

        $recipe1 = factory(Recipe::class)->make([
            'name' => 'Chicken Tikka Masala', 
            'public' => true
        ]);

        $recipe2 = factory(Recipe::class)->make([
            'name' => 'Pizza', 
            'public' => false
        ]);

        $recipe3 = factory(Recipe::class)->make([
            'name' => 'Fajitas', 
            'public' => true
        ]);

        $user->recipes()->saveMany([
            $recipe1,
            $recipe2,
            $recipe3,
        ]);

        $repo = new UserRepository();
        $foundRecipes = $repo->getPublicRecipesForUser($user);

        $this->assertSame($foundRecipes->count(), 2);
        $this->assertTrue($foundRecipes->contains($recipe1->id));
        $this->assertTrue($foundRecipes->contains($recipe3->id));
        $this->assertFalse($foundRecipes->contains($recipe2->id));
    } 
}
