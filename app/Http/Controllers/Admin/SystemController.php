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
        $system_id = $request->input("system_id", '');
        $status = $request->input("status", '');
        $system = System::find(1);;
        if (!empty($system_id)) {
            $system->setup_id = $system_id;
        } else if (!empty($status)) {
            $system->status = $status;
        }
        if ($system->save()) {
            return ['status' => 'ok'];
        }else{
            return ['status' => 'error'];
        }
    }


}
