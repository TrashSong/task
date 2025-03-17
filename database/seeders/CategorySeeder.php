<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Політика', 'Економіка', 'Спорт', 'Технології', 'Наука'];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
