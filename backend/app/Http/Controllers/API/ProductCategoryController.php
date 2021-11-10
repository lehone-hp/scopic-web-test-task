<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function fetchAll() {
        return ProductCategoryResource::collection(ProductCategory::orderBy('name', 'ASC')->get());
    }
}
