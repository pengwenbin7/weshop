@extends("layouts.wechat2")

@section("content")
    <div class="container">
  <div class="order-list" id="app">
    
      <div class="taps">
        <div class="item">
          <a class="on">全部订单</a>
        </div>
        <div class="item">
          <a>待付款</a>
        </div>
        <div class="item">
          <a>待收货</a>
        </div>
      </div>
      <div class="orders">
      @foreach ($orders as $order)
        <div class="order">
          <a href="{{ route("wechat.order.show", $order->id) }}">
          <div class="order-header">
            
            <div class="order-number">
              <span class="icon-order">
                  <i class="iconfont icon-dingdan1"></i>
              </span>
              {{ $order->no }}</div>
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
          </a>
          <div class="order-content">
            <div class="order-product">
            @foreach ($order->orderItems as $orderItem)
              <div class="item">
                <div class="pro">
                  <a href="order.html">
                  <span>{{ $orderItem->brand_name }}</span><span>{{ $orderItem->product_name }}</span>
                  <span>{{ $orderItem->model }}</span><span>x{{ $orderItem->number }}</span>
                  <span>{{ $orderItem->price }}</span>
                  </a>
                </div>
                <div class="show-express"><a href="" class="black">查看物流</a></div>
              </div>
              @endforeach
              
            </div>
            
          </div>
          </a>
          <div class="order-footer">
            <div class="order-price">
              <span>金额：￥{{ $order->payment->pay }}</span>
            </div>
            <div class="order-edit">
              <span>生成合同</span>
              @if($order->status === 0)
              <span class="gopay">去付款</span>
              @elseif ($order->status === 2)
              <span class="gopay">确认收货</span>
              @elseif ($order->status === 3)
              <span class="green">确认收货</span>
              @endif
              
            </div>
          </div>
        </div>
        @endforeach
        
      </div>
    </div>
    
  </div>
@endsection("content")
