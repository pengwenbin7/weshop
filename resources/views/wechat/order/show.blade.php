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
      <div class="product-info">
        <div class="p-title">
          <span class = "title">商品信息</span>
          <span class = "express green">查看物流</span>
        </div>
        @foreach ($order->orderItems as $item)
          <div class="product-detail clearfix">
            <div class="item"><span>品名：{{ $item->product_name }}</span></div>
            <div class="item"><span>型号：{{ $item->model }}</span></div>
            <div class="item"> <span>厂家：{{ $item->brand_name }}</span></div>

            <div class="item"><span>数量：{{ $item->number }}{{ $item->packing_unit }}</span></div>
            <div class="item"><span>金额： <i class="y">￥{{ $item->price *$item->number }}</i>   </span></div>
          </div>
        @endforeach
      </div>
      <div class="contracts">
        <div class="invoice">
          <span>
	    <i>发票信息</i>
	  </span>
	  <span class="btn-click right">
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
	  </span>
        </div>
        <div class="contract">
          <span><i>合同信息</i></span><span class="btn-click right">
	    @if (auth()->user()->company)
	      <a onclick="downloadContract()">
		下载合同
	      </a>
	    @else
	      <a href="{{ route("wechat.company.create") }}">
		下载合同
	      </a>
	    @endif
	  </span>
        </div>
      </div>
      <div class="order-info">
        <div class="order-number">订单编号：{{ $order->no }}</div>
        <div class="order-times">
          <p><span><i>创建时间：</i>{{ $order->created_at }}</span></p>
          <p><span><i>付款时间：</i>{{ $order->payment->pay_name }}</span></p>
          <p><span><i>支付方式：</i>{{ $order->payment->channel_id }}</span></p>
          <p><span><i>发货时间：</i></span></p>
          <p><span><i>收货时间：</i>2018-01-31 09:21</span></p>
        </div>
      </div>
      <div class="footer">
        <div class="item price y"><span>实付金额：{{ $order->payment->pay }}</span></div>
        <div class="item">
          @if($order->status === 0)
            <span  class="btn-click">去付款</span>
          @elseif ($order->status === 2)
            <span class="green">待收货</span>
          @elseif ($order->status === 3)
            <span class="green">货到付款</span>
          @endif

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
