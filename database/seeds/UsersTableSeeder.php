<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = max((int) $this->command->ask('How many users would you like to create?', 20), 1);

        factory(App\User::class)->states('john-doe')->create();
        factory(App\User::class, $userCount)->create();
    }
}
