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
        $page = $request->input("page", '');
        $user = User::with(["admin"])
            ->where("name", "like", "%$name%")
            ->orderBy("id", "desc")
            ->paginate($limit);
        $serial = 1;
        if(!empty($page) && $page != 1){
            $serial = $page * $limit - $limit + 1;
        }
        $line_num = $user -> total();
        return view("admin.shopuser.index", [
            "serial" => $serial,
            "line_num" => $line_num,
            "user" => $user,
            'name' => $name,
            'limit' => $limit
        ]);
    }
}
