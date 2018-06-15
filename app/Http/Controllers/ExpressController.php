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
        $e = new Express();
        return $e->fetch($request->no);
    }
}
