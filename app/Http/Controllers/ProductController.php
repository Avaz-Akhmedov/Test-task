<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(FilterProductRequest $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->with(['category.children.children'])
            ->filterByPrice(
                $request->validated('priceFrom'),
                $request->validated('priceTo'),
            )
            ->filterByCategory($request->validated('categories'))
            ->get();

        return ProductResource::collection($products);
    }


    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product);
    }
}
