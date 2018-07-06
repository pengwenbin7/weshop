<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class ShopuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input("limit", 25);
        $name = $request->input("name", '');
        $user = User::with(["admin"])
            ->where("name", "like", "%$name%")
            ->orderBy("id", "desc")
            ->paginate($limit);
        $line_num = $user -> total();
        return view("admin.shopuser.index", [
            "line_num" => $line_num,
            "user" => $user,
            'name' => $name,
            'limit' => $limit
        ]);
    }
}
