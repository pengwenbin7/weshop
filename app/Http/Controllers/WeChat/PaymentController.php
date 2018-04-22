<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;
use Log;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $order = Order::find($request->order_id);
        $payment = EasyWeChat::payment();
        $result = $payment->order->unify([
            'body' => '微信支付测试订单',
            'out_trade_no' => $order->no,
            'total_fee' => 1,
            'trade_type' => 'JSAPI',
            'openid' => 'obOoJwQa8TO57HLd8WHtuXP91CE8',
        ]);
        $jssdk = $payment->jssdk;
        $json = $jssdk->bridgeConfig($result["prepay_id"]);
        return view("wechat.pay.wait", [
            "json" => $json,
        ]);
    }

    public function callback(Request $request)
    {
        Log::info("callback");
        Log::info($request);
    }
    
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
        //
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        return $payment->delete();
    }
}
