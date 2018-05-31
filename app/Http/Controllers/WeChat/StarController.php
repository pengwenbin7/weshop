<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductStar as Star;
use App\Models\Product;

class StarController extends Controller
{
    public function all(Request $request)
    {
        $limit = $request->input("limit", 15);
        $stars = Star::where("user_id", "=", auth()->user()->id)
               ->paginate($limit);
        return $stars;
    }
    
    public function star($id)
    {
        return Star::firstOrCreate([
            "user_id" => auth()->user()->id,
            "product_id" => $id,
        ]);
    }

    public function unstar($id)
    {
        $star = Star::where("product_id", "=", $id)
              ->where("user_id", "=", auth()->user()->id)
              ->get();
        if ($star->isNotEmpty()) {
            return ["unstar" => $star->first()->delete()];
        } else {
            return ["unstar" => null];
        }
    }
}
