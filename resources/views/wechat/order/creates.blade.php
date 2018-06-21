@extends( "layouts.wechat2")
<style media="screen">
  .hidden{
    display: none;
  }
</style>
@section( "content")
<div class="container" id="app">
  <div class="order">
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
      <div class="item" onclick="show('coupon')" >
      <span> 优惠券</span>
      <span class="value y">
        @if ($coupons->count())
          <i id="coupon">选择优惠券</i>
        @else
          <i>暂无可用</i>
        @endif
        <i class="iconfont icon-zhankai"></i></span>
    </div>
    <div class="item">
    <span> 零售附加</span>
    <span class="value"><i>+{{ $freight }}</i> </span>
  </div>
    <div class="item">
      <span> 实付金额</span>
      <span class="value y" id="total">{{ $freight+$totalPrice }}</span>
    </div>
  </div>
</div>
<div class="flexbox hidden">
  <div class="mask" onclick="hideBox()"></div>
  <div class="coupon-list">
    <div class="tit">优惠券(<small >{{ $coupons->count() }}</small>张)</div>
    <div class="coupons">
      @foreach ($coupons as $coupon)
      <div class="item" onclick="selectCoupon(this)" data-prop="{'id':'{{$coupon->id}}', 'discount':'{{$coupon->discount}}','amount':'{{ $coupon->amount }}'}">
        <div class="c-h">
          <div class="ch-price">
            <span >￥{{ intval($coupon->discount) }}</span>
          </div>
          <div class="ch-info">
            <p class="title" >{{  $coupon->description ?? "默认红包" }}
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
              {{ intval($coupon->amount) }}元可用</p>
          </div>
        </div>
      </div>
       @endforeach
    </div>
    <div class="no-use" onclick="nochoose()">
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
  var total = document.querySelector("#total");
  var coupon = document.querySelector("#coupon");
  var flexbox = document.querySelector(".flexbox");
  var totalPrice = {{ $totalPrice + $freight }};
  var coupon_id = null;
  var fee = {{ $freight }};
  function show(){
    var len = {{ count($coupons) }};
    if(len){
      flexbox.style.display="block";
    }
  }
  function hideBox(){
    flexbox.style.display="none";
  }
  function selectCoupon(dom){
    console.log(dom.dataset.prop);
    var prop = eval('(' + dom.dataset.prop + ')');
    console.log(prop.id);
    if(prop.amount<totalPrice){
      coupon_id = prop.id;
      discount = prop.discount;
      coupon.innerText="-￥"+discount;
      total.innerText = totalPrice - discount;
      hideBox();
    }else{
      alert("优惠券不可用");
      hideBox();
    }
    console.log(prop);
  }
  function nochoose(){
    coupon_id = null;
    coupon.innerText="选择优惠券";
    total.innerText = totalPrice;
    hideBox();
  }
  function pay() {
    var data = {
      address_id: {{ $cart->address->id }},
      coupon_id: coupon_id,
      products: {!! $varia !!}
    };
    axios.post("{{ route("wechat.order.store") }}", data)
      .then(function(res) {
        location.assign("{{ route("wechat.pay") }}" +
          "/?order_id=" + res.data.store);
      });
  }
</script>
@endsection
