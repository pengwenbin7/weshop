<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $user = auth()->user();
        if($user->company_id){
          return redirect()->route("wechat.home.index");
        }else{
          return view("wechat.company.create" , ["title" => "我的公司" ] );
        }
    }

    public function fetch(Request $request)
    {
        $url = "http://i.yjapi.com/ECIV4/Search?key=988eef9debf242ff97c69515a262327d&dtype=json&keyword={$request->keyword}";
        return file_get_contents($url);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = auth()->user();
      $company = Company::firstOrCreate([
          "name" => $request->Name,
          "oper_name" => $request->OperName,
          "code" => $request->CreditCode,
      ]);
      $user->company_id = $company->id;
      $user->save();
      return ["store" => $company->id];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view("wechat.company.show",[ "company" => $company, "title" => "我的公司" ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
        $user = auth()->user();
        $user->company_id = null;
        $user->save();
        return ["destroy" => $company->delete()];
    }
}
