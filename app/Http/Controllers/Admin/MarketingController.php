<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Marketing;
use App\Jobs\NewsController;
use Log;

class MarketingController extends Controller
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
        $active = $request->input("active", '');
        $Marketing = Marketing::orderBy("id", "desc")
            ->paginate($limit);
        $serial = 1;
        if(!empty($page) && $page != 1){
            $serial = $page * $limit - $limit + 1;
        }
        $line_num = $Marketing -> total();
        return view("admin.marketing.index", [
            "serial" => $serial,
            "line_num" => $line_num,
            "Marketing" => $Marketing,
            'active' => $active,
            'name' => $name,
            'limit' => $limit
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.marketing.create");
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $marketing = new Marketing();
        $marketing->title = $request->title;
        $marketing->text_type = $request->text_type;
        $marketing->result = $request->result;
        $marketing->ending = $request->ending;
        $marketing->link = $request->link;
        $marketing->user_type = $request->user_type;
        if (!$marketing->save()) {
            return ["err" => "save product error"];
        }
        return redirect()->route("admin.marketing.index");
    }
    //修改
    public function edit(Marketing $marketing)
    {
        return view("admin.marketing.edit", ["marketing" => $marketing]);
    }
    //模板推送
    public function show(Request $request)
    {
        $span = Marketing::find($request->id);
        NewsController::dispatch($span);
        Log::info(auth("admin")->user()->name."进行--".$span->title."--消息推送！");
        return ['status' => "ok"];
    }

    public function update(Request $request)
    {
        $marketing = Marketing::find($request->id);
        $marketing->title = $request->title;
        $marketing->text_type = $request->text_type;
        $marketing->result = $request->result;
        $marketing->ending = $request->ending;
        $marketing->link = $request->link;
        $marketing->user_type = $request->user_type;
        if (!$marketing->save()) {
            return ["err" => "save product error"];
        }
        return redirect()->route("admin.marketing.index");
    }
    public function delete(Request $request)
    {
        $span = Marketing::where("id", '=', $request->id)->delete();
        if (!$span) {
            return ["status" => "error"];
        }else{
            return ["status" => "ok"];
        }
        return redirect()->route("admin.marketing.index");
    }
}
