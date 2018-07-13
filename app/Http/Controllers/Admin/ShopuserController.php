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
        $user = User::with(["admin","lastAddress"])
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
        $id = explode(',',$id);
        $admin_id = $request->input("admin_id", '');  //业务员id
        \DB::beginTransaction();
        try{
            \DB::table('users')
                ->whereIn("id", $id)
                ->update(['admin_id' => $admin_id]);
            \DB::table('orders')
                ->whereIn("user_id", $id)
                ->update(['admin_id' => $admin_id]);
            \DB::commit();
            return ['status' => "ok"];
        } catch (\Exception $e){
            \DB::rollback();//事务回滚
            return ['status' => "error"];
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->id);
        $user->is_vip = $request->status == 1 ? 1:0;
        if ($user->save()) {
            return ['status' => 'ok'];
        }else{
            return ['status' => 'error'];
        }
    }



}
