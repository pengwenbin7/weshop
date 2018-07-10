<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\System;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $system = System::first();
        return view("admin.system.index",['system' => $system]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data["limit"] = $request->input("limit", '');
        $data["name"] = $request->input("name", '');
        $data["categories"] = Category::all();
        $data["brands"] = Brand::all();
        $data["commonStorages"] = Storage::select("id", "name")
            ->where("is_common", "=", 1)->get();
        return view("admin.product.create", $data);
    }


}
