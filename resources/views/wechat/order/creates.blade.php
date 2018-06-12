@extends( "layouts.wechat2")
<style media="screen">
  .hidden{
    display: none;
  }
</style>
@section( "content")
<div class="container" id="app">
  <div class="order"  v-lock>
    <div class="address">
      <div class="a-info">
        <div class="name">
          <span class="user-name">{{ $cart->address->contact_name }}</span>
          <span>{{ $cart->address->contact_tel }}</span>
        </div>
        <div class="a-dist">
          <span class="p-dist">{{ $cart->address->province }}{{ $cart->address->city }}{{ $cart->address->district }}{{ $cart->address->detail }}</span>
        </div>
      </div>

    </div>
    <div class="products">
      @foreach ($products as $productsto)
        @foreach ($productsto as $product)
        <div class="product" >
          <div class="p-info">
            <div class="num clearfix">
              <span>品名：<i class="black"> {{ $product->name }}</i></span>
            </div>
            <div class="num clearfix">
              <span>型号：<i class="black"> {{ $product->model }}</i></span>
            </div>
            <div class="num clearfix">
              <span>厂商：<i class="black"> {{ $product->brand_name }}</i></span>
            </div>
            <div class="pirce">
              @if ($product->is_ton)
                <span>单价：<i class="black">￥{{ $product->price }}/吨</i></span>
              @else
                <span>单价：<i class="black">￥{{ $product->price }}/{{ $product->packing_unit }}</i></span>
              @endif
            </div>
            <div class="num clearfix">
              <span>数量：<i class="black">{{ $product->number }}{{ $product->packing_unit }}</i><i class="black">{{ $product->number * $product->content }}KG</i></span>
            </div>
          </div>
        </div>
        @endforeach
      @endforeach
    </div>
    <div class="grid">
      <div class="item" @click="show('coupon')" >
      <span> 优惠券</span>
      <span class="value y"><i>暂无可用</i> <i class="iconfont icon-zhankai"></i></span>
    </div>
    <div class="item">
    <span> 零售附加</span>
    <span class="value"><i>{{ $freight }}</i> </span>
  </div>
    <div class="item">
      <span> 实付金额</span>
      <span class="value y">{{ $freight+$totalPrice }}</span>
    </div>
  </div>
</div>
<div class="flexbox hidden">
  <div class="mask" @click="hideBox()"></div>
  <div class="coupon-list">
    <div class="tit">优惠券(<small >{{ count($coupons) }}</small>张)</div>
    <div class="coupons">
      @foreach ($coupons as $coupon)
      <div class="item" >
        <div class="c-h">
          <div class="ch-price">
            <span >￥{{ $coupon->discount }}</span>
          </div>
          <div class="ch-info">
            <p class="title" >{{ $coupon->description }}
             </p>
            <p>有效期至： <span >{{ $coupon->expire_time }} </span>
              </p>
          </div>
        </div>
        <div class="c-f">
          <div class="circle"></div>
          <div class="circle-r"></div>
          <div class="cf-desc">
            <p>满
              {{ $coupon->amount }}元可用</p>
          </div>
        </div>
      </div>
       @endforeach
    </div>
    <div class="no-use" @click="hideBox('coupon')">
      <span>不使用优惠券</span>
    </div>
  </div>
</div>
</div>
<div class="footer order-footer" onclick="pay()">
  <div class="item" v-on:click="pay">
    <span>提交订单</span>
  </div>
</div>

@endsection

@section( "script")

<script>

  function pay() {
    // var data = {
    //   address_id: app.address_id,
    //   channel_id: app.channel_id,
    //   coupon_id: app.coupon_id,
    //   products: {!! $varia !!}
    // };
    axios.post("{{ route("wechat.order.store") }}", data)
      .then(function(res) {
        location.assign("{{ route("wechat.pay") }}" +
          "/?order_id=" + res.data.store);
      });
  }
</script>
@endsection
