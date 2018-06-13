<?php

namespace App\Http\Controllers\WeChat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use App\Models\Company;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        return view("wechat.home", ["user" => $user, "title" => "用户中心"]);
    }
    public function waiter()
    {
        $user = auth()->user();
        return view("wechat.home.waiter", ["user" => $user, "title" => "客服"]);
    }

    public function coupon()
    {
      $coupons = auth()->user()->coupons;
      return view("wechat.home.coupon", ["coupons" => $coupons, "title" => "优惠券"]);
    }
    public function company()
    {
      $user = auth()->user();
      $company = $user->company;
      return view("wechat.home.company",["user" => $user, "company" => $company, "title" => "我的公司"]);
    }
    public function companyList(Request $request)
    {
      $data ='{
      	"Result": [{
      			"KeyNo": "4659626b1e5e43f1bcad8c268753216e",
      			"Name": "北京小桔科技有限公司",
      			"OperName": "程维",
      			"StartDate": "2012-07-10T00:00:00",
      			"Status": "存续（在营、开业、在册）",
      			"No": "110108015068911",
      			"CreditCode": "9111010859963405XW",
            "Address" : "上海市嘉定区",
            "Tel" : "69000038"
      		},
      		{
      			"KeyNo": "4178fc374c59a79743c59ecaf098d4dd",
      			"Name": "深圳市小桔科技有限公司",
      			"OperName": "王举",
      			"StartDate": "2015-04-22T00:00:00",
      			"Status": "存续",
      			"No": "440301112653267",
      			"CreditCode": "91440300334945450M",
            "Address" : "上海市嘉定区",
            "Tel" : "69000038"
      		},
      		{
      			"KeyNo": "e53a833a0267614103e0a20114db89b0",
      			"Name": "广州小桔科技有限公司",
      			"OperName": "潘仁礼",
      			"StartDate": "2017-06-27T00:00:00",
      			"Status": "存续",
      			"No": "",
      			"CreditCode": "91440101MA59PRRKXX",
            "Address" : "上海市嘉定区",
            "Tel" : "69000038"
      		}
      	]
      }';
      return $data;
    }
    public function invoice(Request $request)
    {
      $user = auth()->user();
      $id = $request->id;
      return view("wechat.home.invoice",["user" => $user, "id" => $id, "title" => "我的发票"]);
    }
    public function companyStore(Request $request)
    {
      $user = auth()->user();
        $company = new Company();
        $company->fill([
                "name" => $request->Name,
                "contact_name	" => $request->OperName,
                "creator" => $request->CreditCode,
        ]);
        $res2 = $company->save();
        if ($res2){
          return ["company_id" => $company->id];
        }


      //插入公司

      //更新
    }
}
