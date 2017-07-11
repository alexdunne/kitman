<?php

namespace Tests\Unit;

use App\Company;
use App\Ingredient;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FindIngredientByNameTest extends TestCase
{
    use DatabaseMigrations;

    public function testCanFindAnIngredientByName()
    {
        $company = factory(Company::class)->create();
        $ingredient = factory(Ingredient::class)->create();
        $company->addIngredient($ingredient);
        
        $foundIngredient = Ingredient::findByName($ingredient->name);

        $this->assertSame($ingredient->id, $foundIngredient->id);
    }
}
