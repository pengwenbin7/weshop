<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Express;

class ExpressController extends Controller
{
    /**
     * 根据订单号查询快递信息
     */
    public function fetch(Request $request)
    {
        $url = "https://mp.weixin.qq.com/bizmall/expresslogistics?appid=wx0d9aa0e894066e87&orderid={$request->no}";
        return redirect($url);
    }
}
