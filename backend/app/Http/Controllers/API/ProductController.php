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
            'category' => $request->get('category'),
            'limit' => $request->get('limit') ?: 10
        ];

        $products = new Product();

        if ($filter['min_bid']) {
            $products = $products->where('min_bid', '<=', $filter['min_bid']);
        }
        if ($filter['category']) {
            $products = $products->where('category_id', $filter['category']);
        }

        if ($filter['sort']) {
            switch ($filter['sort']) {
                case 'date_asc':
                    $products = $products->orderBy('close_date', 'ASC');
                    break;
                case 'date_desc':
                    $products = $products->orderBy('close_date', 'DESC');
                    break;
                case 'min_bid':
                    $products = $products->orderBy('min_bid', 'ASC');
                    break;
            }
        }

        $products = $products->paginate($filter['limit']);
        return ProductResource::collection($products);
    }
}
