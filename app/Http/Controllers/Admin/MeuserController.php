<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;

class MeuserController extends Controller
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
        $company = $request->input("company", 1);
        $page = $request->input("page", '');
        //获取业务员id
        $admin_user = auth("admin")->user()->id;
        $user = '';
        if ($company == 1) {
            $user = User::with(["admin","lastAddress"])
                ->where("name", "like", "%$name%")
                ->where("admin_id", "=", $admin_user)
                ->orderBy("id", "desc")
                ->paginate($limit);
        } else {
            $user = User::with(["admin","lastAddress"])
                ->where("name", "like", "%$name%")
                ->where("admin_id", "=", $admin_user)
                ->whereNotNull("company_id")
                ->orderBy("id", "desc")
                ->paginate($limit);
        }
        $serial = 1;
        if(!empty($page) && $page != 1){
            $serial = $page * $limit - $limit + 1;
        }
        $line_num = $user -> total();
        return view("admin.meuser.index", [
            "company" => $company,
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
        $user = User::find($request->id);
        $user->is_vip = $request->status == 1 ? 1:0;
        if ($user->save()) {
            return ['status' => 'ok'];
        }else{
            return ['status' => 'error'];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
