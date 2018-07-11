<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Marketing;

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


}
