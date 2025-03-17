<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{   
    public function run()
    {
        $faker = Faker::create();
        $categories = Category::all();

        foreach (range(1, 20) as $index) {
            Article::create([
                'category_id' => $categories->random()->id,
                'image_path' => 'images/test.jpg',
                'title' => $faker->sentence(6),
                'published_at' => $faker->dateTimeBetween('-1 years', 'now'),
                'short_description' => $faker->text(100),
                'likes' => $faker->numberBetween(0, 2000000),
                'created_at' => $faker->dateTimeBetween('-1 years', 'now')
            ]);
        }
    }
}