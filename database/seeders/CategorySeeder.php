<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['category_name' => '電化製品'],
            ['category_name' => '家具'],
            ['category_name' => '農機具'],
            ['category_name' => '衣類'],
            ['category_name' => '書類'],
            ['category_name' => '本'],
            ['category_name' => 'CD・DVD'],
            ['category_name' => '貴金属'],
            ['category_name' => '創作物'],
            ['category_name' => '雑貨'],
            ['category_name' => 'その他'],
        ]);
    }
}
