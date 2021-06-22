<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'      => 'Admin',
                'email'     => 'Admin@gmail.com',
                'password'  => bcrypt('admin12345'),
                'role_id'   => 1,
                'email_verified_at' => now(),
            ],

        ];
        DB::table('users') -> insert($data);
    }
}
