<?php

use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = (array)DB::table('categories')->first();
        $categoryId = (string)$categories['_id'];

        DB::table('assets')->insert([
            'name' => 'PETR4',
            'category_id' => $categoryId,
            'price' => 1,
        ]);
    }
}
