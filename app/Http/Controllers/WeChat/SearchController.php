<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SearchController extends Controller
{
    public function search($key)
    {
        $products = Product::where("name", "like", "%$key%");
        return $products;
    }
}
