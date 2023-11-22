<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\Order\UserOrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $orders = auth()->user()->orders()->with('items.product')->get();

        return UserOrderResource::collection($orders);

    }

    public function store(StoreOrderRequest $request, OrderService $orderService): JsonResponse
    {
        $orderService->storeOrder(
            $request->validated('products'),
            auth()->user()
        );

        return response()->json([
            'message' => 'Order placed successfully'
        ], Response::HTTP_CREATED);
    }


}
