<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = collect(Category::all()->modelKeys());
        $attributes = [
            'size' => $this->faker->randomElement(['L', 'M', 'XL']),
            'width' => rand(1, 10)
        ];
        return [
            'name' => $this->faker->domainWord(),
            'description' => $this->faker->realTextBetween(200, 1000),
            'category_id' => $categories->random(),
            'price' => rand(1000, 99999),
            'attributes' => json_encode($attributes)
        ];
    }
}
