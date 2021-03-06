<?php

namespace App\Http\Controllers\WeChat;

use App\Models\Payment;
use App\Models\Order;
use App\Models\PayChannel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat;
use App\Events\OrderPaidEvent;
use Auth;
use Carbon\Carbon;
use Log;

class PaymentController extends Controller
{
    protected $payment;
    public function __construct()
    {
        $this->payment = EasyWeChat::payment();
    }
    public function pay(Request $request)
    {
        $order = Order::find($request->order_id);
        $payment = $order->payment;
        $now = Carbon::now();
        if ($payment->prepay_id && $payment->expire->gt($now)) {
            $prepayId = $order->payment->prepay_id;
        } else {
            $start = $now->format("YmdHis");
            $expire = $now->addHour(2)->format("YmdHis");
            $result = $this->payment->order->unify([
                'body' => '微信支付订单',
                'out_trade_no' => $order->no,
                'total_fee' => intval($order->payment->pay) * 100,
                //'total_fee' => 1,
                'trade_type' => 'JSAPI',
                'openid' => auth()->user()->openid,
                'time_start' => $start,
                'time_expire' => $expire,
            ]);
            $prepayId = $result["prepay_id"];
            $payment->prepay_id = $prepayId;
            $payment->start = $start;
            $payment->expire = $expire;
            $payment->save();
        }
        $jssdk = $this->payment->jssdk;
        $json = $jssdk->bridgeConfig($prepayId);
        $pay_channel = PayChannel::all();
        $product = $order->orderItems->first()->product;
        $name = $product->brand->name ." ". $product->model ." ". $product->name;
        if($product->is_ton){
            $price = $product->variable->unit_price * 1000 / $product->content . "元/吨";
        }else{
            $price = $product->variable->unit_price . "元/" . $product->packing_unit;
        }

        $share_title = "我在太好买采购的" . $name . "只要" .$price . "，你也来看看吧。";
        return view("wechat.pay.wait", [
            "json" => $json,
            "share_title" => $share_title,
            "order" => $order,

            "pay_channel" => $pay_channel,
        ]);
    }

    public function callback(Request $request)
    {
        // Log::info($request->getContent());
        $response = $this->payment->handlePaidNotify(function($message, $fail){
            /**
             * 如果订单不存在 或者订单已经支付过了
             * 告诉微信，我已经处理完了，订单没找到，别再通知我了
             */
            $order = Order::where("no", "=", $message["out_trade_no"])
                   ->get();
            if ($order->isEmpty()) {
                return true;
            }

            $order = $order->first();
            if ($order->payment_status == Order::PAY_STATUS_DONE) {
                return true;
            }

            // return_code 表示通信状态，不代表支付状态
            if ($message['return_code'] === 'SUCCESS') {
                // 调用微信的【订单查询】接口查一下该笔订单的情况,确认是已经支付
                do {
                    $query = $this->payment
                           ->order
                           ->queryByOutTradeNumber($message["out_trade_no"]);
                } while ("SUCCESS" != $query["return_code"]);
                $order->payment->paid = $query["total_fee"] / 100;
                if ($order->payment->pay == $order->payment->paid) {
                    $order->payment_status = Order::PAY_STATUS_DONE;
                } elseif ($order->payment->pay < $order->payment->paid) {
                    $order->payment_status = Order::PAY_STATUS_ERROR;
                } else {
                    $order->payment_status = Order::PAY_STATUS_PART;
                }

                // 20180507115726
                $order->payment->pay_time = $query["time_end"];
                $order->payment->save();
                $order->save(); // 保存订单
                event(new OrderPaidEvent($order)); // 触发监听事件
            } else {
                return $fail("Notice error, call me later.");
            }

            return true; // 返回处理完成
        });

        return $response;
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
    
    public function payOffline(Request $request)
    {
        $order = Order::find($request->order_id);
        $payment = $order->payment;
        $payment->channel_id = $request->channel_id;
        $payment->save();
        $type  = $request->type;
        $user = auth()->user();
        return view("wechat.pay.offline",["order" => $order,"user" => $user, "type" => $type, "title" => "付款方式" ]);
    }

    public function test()
    {
        $result = $this->payment->order->unify([
            'body' => '微信支付测试',
            'out_trade_no' => time(),
            'total_fee' => 1,
            'trade_type' => 'JSAPI',
            'openid' => auth()->user()->openid,
        ]);
        $jssdk = $this->payment->jssdk;
        $json = $jssdk->bridgeConfig($result["prepay_id"]);
        return view("wechat.pay.test", [
            "json" => $json,
        ]);
    }
}
