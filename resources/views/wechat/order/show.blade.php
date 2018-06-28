@extends( "layouts.wechat2")
@section( "content")
  <div class="container">
    <div class="order-detail" id="app" v-cloak>
      <div class="order-header">
	<div class="order-number">
          <span>订单号： {{ $order->no }}</span>
	</div>
	<div class="order-status">
	  @if ($order->userStatus()["active"]["status"] == 1)
	    @if ($order->userStatus()["pay"]["status"] == 0)
	      <span class="green">{{  $order->userStatus()["pay"]["detail"] }}</span>
	    @else
              @if ($order->userStatus()["ship"]["status"] == 0)
		<span class="green">{{  $order->userStatus()["ship"]["detail"] }}</span>
              @else
		<span class="green">{{  $order->userStatus()["ship"]["detail"] }}</span>
              @endif
	    @endif
	  @else
	    <span class="green">{{  $order->userStatus()["active"]["detail"] }}</span>
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

      @if ($order->shipments->count())
	@foreach ($order->shipments as $shipment)
	  <div class="product-info">
	    <div class="p-title">
              <div class="item title">
		<span>商品信息</span>
              </div>
              <div class="item express">
		<span class="btn" @click='express'  data-express="{'name':'{{ $shipment->name }}','tel':'{{ $shipment->contact_phone }}','licence_plate':'{{ $shipment->licence_plate }}'}">查看物流</span>
              </div>
	    </div>
	    @foreach ($shipment->shipmentItems as $item)
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
      @else
	@foreach ($products as $pss)
	  <div class="product-info">
	    <div class="p-title">
              <div class="item title">
		<span>商品信息</span>
              </div>

              <div class="item express">
		<span>待发货</span>
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
      @endif
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


      @if ($order->userStatus()["active"]["status"] == 1)
        @if ($order->userStatus()["pay"]["status"] == 0)
          <div class="contracts">
            <div class="contract">
              <span><i>合同信息</i></span>
              <div class="btn-click right">
                @if (auth()->user()->company)
                  <a onclick="downloadContract()">
                    下载合同
                  </a>
                @else
                  <a href="{{ route("wechat.company.create") }}">
                    下载合同
                  </a>
                @endif
              </div>
            </div>
	         </div>
        @else
          @if ($order->userStatus()["ship"]["status"] == 0)
            <div class="contracts">
                <div class="contract">
                  <span><i>合同信息</i></span>
                  <div class="btn-click right">
                    @if (auth()->user()->company)
                      <a onclick="downloadContract()">
                        下载合同
                      </a>
                    @else
                      <a href="{{ route("wechat.company.create") }}">
                        下载合同
                      </a>
                    @endif
                  </div>
                </div>
              <div class="invoice">
                <span>
                  <i>发票信息</i>
                </span>
                <div class="btn-click right">
                  @if ($order->invoice)
                    @if ($order->invoice->status == 2)
                      <a href="#">已开票</a>
                    @elseif ($order->invoice->status == 3)
                      <a href="http://ucmp.sf-express.com/service/weixin/activity/wx_b2sf_order?p1={{ $order->invoice->ship_no }}">
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

	    </div>

          @else
            <div class="contracts">
              <div class="contract">
                <span><i>合同信息</i></span>
                <div class="btn-click right">
                  @if (auth()->user()->company)
                    <a onclick="downloadContract()">
                      下载合同
                    </a>
                  @else
                    <a href="{{ route("wechat.company.create") }}">
                      下载合同
                    </a>
                  @endif
		</div>
              </div>
              <div class="invoice">
                <span>
                  <i>发票信息</i>
                </span>
                <div class="btn-click right">
                  @if ($order->invoice)
                    @if ($order->invoice->status == 2)
                      <a href="#">已开票</a>
                    @elseif ($order->invoice->status == 3)
                      <a href="http://ucmp.sf-express.com/service/weixin/activity/wx_b2sf_order?p1={{ $order->invoice->ship_no }}">
			发票物流
                      </a>
                    @endif
                  @else
                    <a href="{{ route("wechat.invoice.create", ["order_id " => $order->id]) }}">
                      申请开票
                    </a>
                  @endif
                </div>
              </div>

            </div>

          @endif
        @endif
      @else

      @endif

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
            {{ $order->payment->pay_time }}
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
            {{ $order->shipments->first()->updated_at ?? "" }}
          </div>
	</div>
      </div>
      <div class="footer">
	<div class="item price y"><span>实付金额：{{ $order->payment->pay }}</span></div>
	<div class="item">
	  @if ($order->userStatus()["active"]["status"] == 1)
	    @if ($order->userStatus()["pay"]["status"] == 0)
	      <a class="btn-click" href="{{ route("wechat.pay", ["order_id" => $order->id]) }}">去付款</a>
	    @else
              @if ($order->userStatus()["ship"]["status"] == 0)
		<a class="green">待发货</a>
              @else
		<a class="green">已发货</a>
              @endif
	    @endif
	  @else
	    <a class="gray">{{  $order->userStatus()["active"]["detail"] }}</a>
	  @endif
	</div>
      </div>



      <div class="express-box" v-if="express_box" v-cloak>
	<div class="mask" @click="express_box=false">
	</div>
	<div class="express">
          <div class="e-title">
            <p class="green">货物已出库</p>
          </div>
          <div class="e-info">
            <div class="txt">
              <p>司机：
		@{{ name }}</p>
              <p>电话：
		@{{ tel }}</p>
              <p>车牌：
		@{{ licence_plate }}</p>
            </div>
             @if (auth()->user()->admin)
            <p>有疑问请联系销售专员</p>
            <p class="green"> {{ auth()->user()->admin->name }}： <a href="tel:{{ auth()->user()->admin->mobile }}"></a> {{ auth()->user()->admin->mobile }}</p>
             @endif
          </div>
	</div>
      </div>

    </div>
  </div>
@endsection

@section( "script")
  <script>
  var downloadContract = function() {
    var url = "{{ route('wechat.contract', $order) }}";
    axios.get(url)
      .then(function(res) {
        alert("合同已通过微信消息发送，如果长时间未收到，请重试");
      });
  };

  var app = new Vue({
    el: "#app",
    data: {
      express_box: false,
      name: '',
      tel: '',
      licence_plate: '',
    },
    methods: {
      express: function(e) {
        var el = e.target
        var info = eval("(" + el.getAttribute("data-express") + ")");
        this.name = info.name;
        this.tel = info.tel;
        this.licence_plate = info.licence_plate;
        this.express_box = true;
      }
    }
  })
  </script>
@endsection
