<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{

    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->with('children.children')
            ->get();


        return CategoryResource::collection($categories);
    }
}
