<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, HasFactory;

    public function test_to_see_product_by_slug()
    {
        Category::factory()->create();
        $product = Product::factory()->create();

        $this->getJson(route('products.show', 'abcf'))
            ->assertNotFound()
            ->assertJson(["message" => "Resource not found"]);

        $this->getJson(route('products.show', $product->slug))
            ->assertOk();
    }

    public function test_to_see_list_of_products()
    {
        Category::factory()->create();
        Product::factory(30)->create();

        $this->postJson(route('products.index'))
            ->assertOk()
            ->assertJsonCount(30, 'data');
    }

    public function test_to_filter_products_by_category()
    {
        Category::factory(2)->create();

        Product::factory(15)->create([
            'category_id' => 1
        ]);
        Product::factory(10)->create([
            'category_id' => 2

        ]);
        $this->postJson(route('products.index'), [
            'categories' => [2]
        ])
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }

    public function test_to_filter_products_by_price()
    {
        Category::factory()->create();

        Product::factory(10)->create([
            'price' => 500
        ]);

        Product::factory(3)->create([
            'price' => 600
        ]);

        Product::factory(2)->create([
            'price' => 700
        ]);

        Product::factory(5)->create([
            'price' => 850
        ]);

        $this->postJson(route('products.index'), [
            'priceFrom' => "asda"
        ])->assertUnprocessable();

        $this->postJson(route('products.index'), [
            'priceFrom' => 600
        ])
            ->assertOk()
            ->assertJsonCount(10, 'data');

        $this->postJson(route('products.index'), [
            'priceFrom' => 600,
            'priceTo' => 800
        ])
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }
}
