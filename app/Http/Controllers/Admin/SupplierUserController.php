<?php

namespace App\Http\Controllers\Admin;

use App\Models\SupplierUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SupplierUser::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.supplier.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = new SupplierUser();
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->save();
        
        return redirect()->route("admin.supplier.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierUser  $supplierUser
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierUser $supplierUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierUser  $supplierUser
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierUser $supplierUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierUser  $supplierUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierUser $supplierUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierUser  $supplierUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierUser $supplierUser)
    {
        //
    }
}
