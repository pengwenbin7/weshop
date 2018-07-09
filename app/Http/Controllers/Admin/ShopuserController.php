<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Adminuser;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
            $id = $request->input("id", '');
            $limit = $request->input("limit", 25);
            $name = $request->input("name", '');
            $page = $request->input("page", '');
            $user = Adminuser::where("name", "like", "%$name%")
                ->orderBy("id", "desc")
                ->paginate($limit);
            $serial = 1;
            if(!empty($page) && $page != 1){
                $serial = $page * $limit - $limit + 1;
            }
            $line_num = $user -> total();
            return view("admin.shopuser.create", [
                "serial" => $serial,
                "id" => $id,
                "line_num" => $line_num,
                "user" => $user,
                'name' => $name,
                'limit' => $limit
            ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function modifying(Request $request)
    {
        $id = $request->input("id", ''); //用户id
        $admin_id = $request->input("admin_id", '');  //业务员id
        $user = User::where('id', $id) ->first();
        $user->admin_id = $admin_id;
        $span = $user->save();
        if (!empty($span)) {
            return ['status' => "ok"];
        } else {
            return ['status' => "error"];
        }
    }



}
