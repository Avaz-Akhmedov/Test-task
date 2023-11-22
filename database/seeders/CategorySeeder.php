<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parentCategories = Category::factory(6)->create();

        $parentCategories->each(function ($parentCategory) {
            Category::factory(2)->create([
                'parent_id' => $parentCategory->id,
            ]);
        });
    }

}
