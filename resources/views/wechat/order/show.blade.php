@extends("layouts.wechat2")

@section("content")
  <div class="container">
    <div class="order-detail" id="app" >

      <div class="order-header">
        <div class="order-number">
          <span>订单号： {{ $order->no }}</span>
        </div>
        <div class="order-status">
          @if($order->status === 0)
            <span class="green">待付款</span>
          @elseif ($order->status === 2)
            <span class="green">待收货</span>
          @elseif ($order->status === 3)
            <span class="green">货到付款</span>
          @endif

        </div>
      </div>
      <div class="order-address">
        <div class="loc">
          <span><i class="iconfont icon-dizhi"></i></span>
        </div>
        <div class="address-detail">
          <p><span>收货人：{{ $order->address->contact_name }}</span><span class="tel">{{ $order->address->contact_tel }}</span></p>
          <p class="p-list">{{ $order->address->getText() }}</p>
        </div>
      </div>

       @foreach ($products as $pss)
      <div class="product-info">
        <div class="p-title">
          <div class="item title">
            <span >商品信息</span>
          </div>
          <div class="item express">
            <span class="btn">查看物流</span>
          </div>
        </div>
        @foreach ($pss as $item)
          <div class="product-detail clearfix">
            <div class="item">
              <span class="label">品名：</span>
              <div class="info-r">
               {{ $item->product_name }}
              </div>
            </div>
            <div class="item">
              <span class="label">型号：</span>
              <div class="info-r">
               {{ $item->model }}
              </div>
            </div>
            <div class="item">
              <span class="label">厂家：</span>
              <div class="info-r">
               {{ $item->brand_name }}
              </div>
            </div>
            <div class="item">
              <span class="label">数量：</span>
              <div class="info-r">
               {{ $item->number }}{{ $item->packing_unit }}
              </div>
            </div>
            <div class="item">
              <span class="label">金额：</span>
              <div class="info-r">
               ￥{{ $item->price *$item->number }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
      <div class="pay-info">
        <div class="item">
          <span class="label">商品总价：</span>
          <div class="info-r">
            ￥{{ $order->payment->total }}
          </div>
        </div>
        @if ($order->payment->freight>0)
        <div class="item">
          <span class="label">额外附加：</span>
          <div class="info-r">
            +￥{{ $order->payment->freight }}
          </div>
        </div>
        @endif
        @if ($order->payment->coupon_discount>0)
        <div class="item">
          <span class="label">优惠券：</span>
          <div class="info-r">
            -￥{{ $order->payment->coupon_discount }}
          </div>
        </div>
        @endif
        @if ($order->payment->share_discount>0)
        <div class="item">
          <span class="label">分享减免：</span>
          <div class="info-r">
            -￥{{ $order->payment->share_discount }}
          </div>
        </div>
        @endif

        <div class="item pay">
          <span class="label">实付金额：</span>
          <div class="info-r">
            ￥{{ $order->payment->pay }}
          </div>
        </div>
      </div>
      <div class="contracts">
        <div class="invoice">
          <span>
	           <i>发票信息</i>
      	  </span>
      	  <div class="btn-click right">
      	    @if ($order->invoice)
              @if ($order->invoice->status=2)
                <a href="#">已开票</a>
              @else
                <a >
        		        发票物流
        	      </a>
              @endif
      	    @else
      	      <a href="{{ route("wechat.invoice.create", ["order_id" => $order->id]) }}">
      		         申请开票
      	      </a>
      	    @endif
      	  </div>
        </div>
        <div class="contract">
          <span><i>合同信息</i></span><div class="btn-click right">
    	    @if (auth()->user()->company)
    	      <a onclick="downloadContract()">
    		       下载合同
    	      </a>
    	    @else
    	      <a href="{{ route("wechat.company.create") }}">
        		下载合同	      </a>
    	    @endif
	       </div>
        </div>
      </div>
      <div class="order-info">
        <div class="item no clearfix">
          <span class="label">订单编号：</span>
          <div class="info-r">
           {{ $order->no }}
          </div>
        </div>
          <div class="item clearfix">
            <span class="label">创建时间：</span>
            <div class="info-r">
             {{ $order->created_at }}
            </div>
          </div>
          <div class="item clearfix">
            <span class="label">付款时间：</span>
            <div class="info-r">
             {{ $order->payment->pay_name }}
            </div>
          </div>
          <div class="item clearfix">
            <span class="label">支付方式：</span>
            <div class="info-r">
             {{ $order->payment->channel->name }}
            </div>
          </div>
          <div class="item clearfix">
            <span class="label">发货时间：</span>
            <div class="info-r">
             {{ $order->created_at }}
            </div>
          </div>
          <div class="item clearfix">
            <span class="label">收货时间：</span>
            <div class="info-r">
             {{ $order->created_at }}
            </div>
          </div>

      </div>
      <div class="footer">
        <div class="item price y"><span>实付金额：{{ $order->payment->pay }}</span></div>
        <div class="item">
          @if($order->status === 0)
            <a  class="btn-click" href="{{ route("wechat.pay") }}/?order_id={{ $order->id }}">去付款</a>
          @elseif ($order->status === 2)
            <a class="green">待收货</a>
          @elseif ($order->status === 3)
            <a class="green">货到付款</a>
          @endif

        </div>
      </div>
      <div class="express-box">
        <div class="mask">
        </div>
        <div class="express">
          <div class="e-title">
            <p class="green">物流运输中</p>
            <p class="no">运单号：12347129479823941239084</p>
          </div>
          <div class="e-info">
            <div class="item">
              <div class="itxt">
                <div class="i-status">
                  <i class="top"></i>
                  <i class="middle"></i>
                  <i class="bottom"></i>
                </div>
                <div class="text">
                  <span>运输中。。。。</span>
                </div>
              </div>
              <div class="itxt">
                运输中.....
              </div>
              <div class="itxt">
                运输中.....
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section("script")
  <script>
  var downloadContract = function () {
    var url = "{{ route('wechat.contract', $order) }}";
    axios.get(url)
      .then(function (res) {
	alert("合同已通过微信消息发送，如果长时间未收到，请重试");
      });
  };
  </script>
@endsection
