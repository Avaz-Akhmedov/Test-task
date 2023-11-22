<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase, HasFactory;

    public function test_to_create_order_and_see_orders()
    {
        Category::factory()->create();
        Product::factory(10)->create([
            'price' => 500
        ]);
        $user = User::factory()->create();

        $this->postJson(route('orders.store'))
            ->assertUnauthorized();

        $this->actingAs($user)->postJson(route('orders.store'), [
            'products' => []
        ])->assertUnprocessable();

        $data = [
            'products' => [
                [
                    'product_id' => 1,
                    'quantity' => 2
                ],
                [
                    'product_id' => 2,
                    'quantity' => 1
                ]
            ]
        ];

        $this->actingAs($user)
            ->postJson(route('orders.store'), $data)
            ->assertCreated()
            ->assertJson(['message' => 'Order placed successfully']);

        $orderCheck = Order::query()
            ->where('user_id', $user->id)
            ->where('total_price',1500)
            ->exists();

        $this->assertTrue($orderCheck);


        $this->actingAs($user)
            ->getJson(route('orders.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data');

    }


}
