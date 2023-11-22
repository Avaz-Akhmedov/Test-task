<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Product;

class OrderService
{
    public function storeOrder(array $items, $user): void
    {
        $order = $user->orders()->create([
            'total_price' => 0,
            'customer_phone' => $user->phone,
            'customer_email' => $user->email
        ]);

        $totalPrice = 0;

        foreach ($items as $item) {
            $product = Product::query()->find($item['product_id']);

            $orderItem = OrderItem::query()->create([
                'product_id' => $product->id,
                'unit_price' => $product->price,
                'quantity' => $item['quantity'],
                'order_id' => $order->id
            ]);

            $subtotal = $orderItem->unit_price * $orderItem->quantity;

            $totalPrice += $subtotal;
        }

        $order->update(['total_price' => $totalPrice]);
    }
}