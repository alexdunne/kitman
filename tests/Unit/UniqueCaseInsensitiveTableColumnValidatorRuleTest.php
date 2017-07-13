<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UniqueCaseInsensitiveTableColumnValidatorRuleTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testValidatingAUniqueCaseInsentivieTableColumnErrors()
    {
        $this->withExceptionHandling();

        factory(User::class)->create(['username' => 'ironman']);

        $requestData = ['username' => 'ironman'];

        $validator = Validator::make($requestData, [
            'username' => 'iunique:users,username',
        ]);

        $this->assertTrue($validator->fails());
    }
}
