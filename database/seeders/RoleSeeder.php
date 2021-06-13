<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
               'role_name' => 'Админ'
           ],

           [
               'role_name' => 'Модератор'
           ],
        ];
    }
}
