<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function fetchBySlug($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return response()->json('Product Not Found', 404);
        }

        return new ProductResource($product);
    }

    public function fetchAll(Request $request)
    {
        $filter = [
            'sort' => $request->get('sort'),
            'min_bid' => $request->get('min_bid'),
            'categories' => $request->get('categories'),
            'limit' => $request->get('limit') ?: 10
        ];

        $products = new Product();

        $products = $products->paginate($filter['limit']);
        return ProductResource::collection($products);
    }
}
