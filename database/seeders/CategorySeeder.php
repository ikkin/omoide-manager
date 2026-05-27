<?php

namespace Database\Seeders;

use App\Models\Category;
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
        $categories = [
            '電化製品',
            '家具',
            '農機具',
            '衣類',
            '書類',
            '本',
            'CD・DVD',
            '貴金属',
            '創作物',
            '雑貨',
            'その他',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['category_name' => $name]
            );
        }
    }
}
