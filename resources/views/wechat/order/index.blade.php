@extends("layouts.wechat2")
@section("content")
  @if (count($orders)||(url()->full() !== route("wechat.order.index")))
    <div class="container">
      <div class="order-list" id="app">
        <div class="taps">
          <div class="item">
            <a class="{{ url()->full() == route("wechat.order.index")? "on":"" }}" href="{{ route("wechat.order.index") }}">全部订单</a>
          </div>
          <div class="item">
            <a class="{{ url()->full() == route("wechat.order.index","order_status=0")? "on":"" }}" href="{{ route("wechat.order.index","order_status=0") }}">待付款</a>
          </div>
          <div class="item">
            <a class="{{ url()->full() == route("wechat.order.index","order_status=1")? "on":"" }}" href="{{ route("wechat.order.index","order_status=1") }}">已发货</a>
          </div>
        </div>
          <div class="orders">
            @foreach ($orders as $order)
            <div class="order">
              <a href="{{ route("wechat.order.show", $order) }}">
                <div class="order-header">
                  <div class="order-number">
                    <span class="icon-order">
                                    <i class="iconfont icon-dingdan1"></i>
                    </span>
                    {{ $order->no }}
                  </div>
                  <div class="order-status">
                    <span class="green">{{ $order->userStatus()["detail"] }}</span>
                  </div>
                </div>
              </a>
              <div class="order-content">
                <div class="order-product">
                  @foreach ($order->orderItems as $orderItem)
                    <div class="item">
                      <a href="{{ route("wechat.order.show", $order) }}">
                        <div class="pro black">
                          <span>{{ $orderItem->product_name }} </span>
                          <span>{{ $orderItem->model }} </span>
                        </div>
                        <div class="pro">
                          <span>{{ $orderItem->brand_name }} </span><span>x{{ $orderItem->number }}</span>
                          <span>￥{{ $orderItem->price * $orderItem->number }}</span>
                        </div>
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            </a>
            <div class="order-footer">
              <div class="order-price">
                <span>附加:￥{{ intval($order->payment->freight) }}</span>
                <span>优惠:￥{{ intval($order->payment->coupon_discount + $order->payment->share_discount) }}</span>
                <span>金额:￥{{ intval($order->payment->pay) }}</span>
              </div>
              <div class="order-edit">
                @if ($order->userStatus()["status"] < 0)
                  <a class= "gray" >
                    失效
                  </a>
                @elseif($order->userStatus()["status"] == 0)
                  <a class="gopay btn-green" href="{{ route("wechat.pay", ["order_id" => $order->id]) }}">
                     去付款
                  </a>
                 @else
              		@if ($order->invoice)
              		  @if ($order->invoice->status == 2)
              		    <a href="#">已开票</a>
              		  @else
              		    <a href="http://ucmp.sf-express.com/service/weixin/activity/wx_b2sf_order?p1={{ $order->invoice->ship_no }}">
              		      发票物流
              		    </a>
              		  @endif
              		@else
              		  <a href="{{ route("wechat.invoice.create", ["order_id" => $order->id]) }}">
              		    申请开票
                                </a>
              		@endif
              		@if (auth()->user()->company)
              		  <a onclick="downloadContract('{{ route("wechat.contract", $order) }}')">
                  		    下载合同
                  		  </a>
              		@else
              		  <a href="{{ route("wechat.company.create") }}">
                      	    下载合同
              		  </a>
              		@endif
                  @endif
              </div>
            </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @else
    <div class="no-content">
      <span><i class="iconfont icon-dingdan1"></i></span>

      <br>
      <p><a class="gray" href="{{ route("wechat.product.index") }}">您还没有订单,去看看～</a></p>
    </div>
  @endif

@endsection("content")

@section("script")
  <script>
  var downloadContract = function (url) {
    axios.get(url)
      .then(function(res) {
        alert("合同已通过微信消息发送，如果长时间未收到，请重试");
      });
  };
  </script>
@endsection
