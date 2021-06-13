<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];

        $cName = 'Без категорії';
        $categories []  = [
            'title'		=> $cName,
            'slug'  	=> Str::slug($cName),
            'parent_id' => 0,
        ];

        for($i = 1; $i <= 10; $i++){

            $cName = "Категорія №" . $i;
            $parent_id = ($i > 4) ? rand(1, 4) : 1;

            $categories[] = [
                'title'		=> $cName,
                'slug'  	=> Str::slug($cName),
                'parent_id' => $parent_id,
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
