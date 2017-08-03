<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = factory(\App\Company::class)->create(['name' => 'Legoland',]);

        factory(\App\User::class)->create([
            'username' => 'legohead',
            'password' => bcrypt('test'),
            'company_id' => $company->id,
        ]);
    }
}
