<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
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
         User::factory(10)->create();
         $this->call(CategoriesSeeder::class);
         Post::factory(100)->create();
         $this->call(RoleSeeder::class);
         $this->call(UserSeeder::class);
    }
}
