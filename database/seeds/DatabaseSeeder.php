<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*
         *  When adding new seeder classes they have to be refreshed by using
         *  "composer dump-autoload"
         *  before "php artisan migrate:refresh --seed" can be run again.
         *  
         *  One seeder can be run induvidually by using "php artisan db:seed --class=classname"
         *  ^ example classname: UsersTableSeeder
         */
        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
