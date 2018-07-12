@extends( "layouts.wechat2")
@section( "content")
<div class="container create"   v-cloak>
    <div class="address">
      <div class="cart-addr">
          <div class="cart-user-info">
            <span>收货人：{{ $cart->address->contact_name }}</span>
            <span class="tel">{{ $cart->address->contact_tel }}</span>
          </div>
          <div class="cart-desc">
            <p>收货地址: {{ $cart->address->province }} {{ $cart->address->city }} {{ $cart->address->district }}{{ $cart->address->detail }}</p>
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
      <div class="item" @click="coupon_box=true" >
      <span> 优惠券</span>
      <span class="value y">
        @if ($coupons->count())
          <i id="coupon" v-if="!coupon_id">选择优惠券</i>
          <i id="coupon" v-if="coupon_id">-￥@{{ coupon_discount }}</i>
        @else
          <i>暂无可用</i>
        @endif
        <i class="iconfont icon-zhankai"></i></span>
    </div>
    <div class="item" v-if="share">
      <span> 分享减免</span>
      <span class="value"  >-￥<i id="fee">@{{ share_discount }}</i></span>
    </div>
    <div class="item">
    <span> 零售附加</span>
    <span class="value"><i>+￥@{{ fee }}</i> </span>
  </div>
    <div class="item">
      <span> 实付金额</span>
      <span class="value y" id="total">@{{ product_total+fee-coupon_discount-share_discount }}</span>
    </div>
  </div>
  <div class="gird"  v-if="!share">
    <div class="item  share-item" @click="share_box = true">
      <span >分享至朋友圈：此单立减@{{ (product_total+fee)<20000?50:100 }}元</span>
    </div>
  </div>
<div class="flexbox" v-if="coupon_box"   v-cloak>
  <div class="mask" @click="coupon_box=false"></div>
  <div class="coupon-list">
    <div class="tit">优惠券(<small >{{ $coupons->count() }}</small>张)</div>
    <div class="coupons">
      @foreach ($coupons as $coupon)
      <div class="item" @click="selectCoupon" data-prop="{'id':'{{$coupon->id}}', 'discount':'{{$coupon->discount}}','amount':'{{ $coupon->amount }}'}">
        <div class="c-h">
          <div class="ch-price">
            <span >￥{{ intval($coupon->discount) }}</span><br >
            <span class="small">优惠券</span>
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
    <div class="no-use" @click="nochoose">
      <span>不使用优惠券</span>
    </div>
  </div>
</div>
</div>
<div class="share"  v-show="share_box"  v-cloak>
  <div class="mask" @click="share_box = false">
  </div>
  <div class="s-info">
    <i class="iconfont icon-shouzhi"></i><br/>
     <span>点击此处分享</span>
  </div>
  <div class="close"  @click="share_box = false"><i class="iconfont icon-tianjia"></i></div>
</div>
<div class="footer order-footer" >
  <div class="item" @click="pay">
    <span>提交订单</span>
  </div>
</div>

@endsection

@section( "script")
<script>
  var app = new Vue({
    el: "#app",
    data: {
      fee:{{ $freight }},
      product_total:{{ $totalPrice }},
      share_discount:0,
      coupon_discount:0,
      coupon_id:null,
      share:false,
      share_box:false,
      coupon_box:false,
    },
    methods: {
      selectCoupon: function(e){
        var el = e.currentTarget;
        var data = el.getAttribute("data-prop")
        var prop = eval('(' + data + ')');
        console.log(data);
        if((this.product_total+this.fee) >= prop.amount){
          this.coupon_id = prop.id;
          this.coupon_discount = prop.discount;
          this.coupon_box = false;
        }
        console.log(typeof(prop) );
      },
      nochoose: function(){
        this.coupon_box = false;
        this.coupon_discount = 0;
        this.coupon_id = null;
      },
      pay: function(){
        var data = {
          address_id: {{ $cart->address->id }},
          share: this.share,
          coupon_id: this.coupon_id,
          products: {!! $varia !!}
        };
        axios.post("{{ route("wechat.order.store") }}", data)
          .then(function(res) {
            location.assign("{{ route("wechat.pay") }}" +
              "/?order_id=" + res.data.store);
          });
      }
    }
  })

  wx.ready(function() {
    var _this = app;
    wx.onMenuShareTimeline({
      title: "太好买化工品原料商城",
      link: "{{ route("wechat.product.show", ["id" => $product->id, "rec_code" => auth()->user()->rec_code]) }}",
      imgUrl: "{{ asset("assets/img/logo.png") }}",
      success: function () {
        _this.share = true;
        _this.share_discount = (_this.product_total + _this.fee) < 20000 ? 50 : 100;
       },
      cancel: function () {
      }
    });

    wx.onMenuShareAppMessage({
      title: "太好买化工品原料商城",
      desc : "我正在使用太好买化工品原料商城购买商品",
      link: "{{ route("wechat.product.show", ["id" => $product->id, "rec_code" => auth()->user()->rec_code]) }}",
      imgUrl: "{{ asset("assets/img/logo.png") }}",
        success: function () {
            // 用户确认分享后执行的回调函数
        },
        cancel: function () {
            // 用户取消分享后执行的回调函数
        }
    });
  });

</script>
@endsection
