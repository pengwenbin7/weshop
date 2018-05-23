@extends( "layouts.wechat2")

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
          <p>{{ $cart->address->province }}{{ $cart->address->city }}{{ $cart->address->district }}{{ $cart->address->detail }}</p>
        </div>
      </div>
      <div class="right-arrow">

      </div>
    </div>
    <div class="products">
      @foreach ($products as $product)
      <div class="product">
        <div class="p-info">
          <div class="title">
            <span class="p-bname">  {{ $product->brand->name }}</span>
            <span class="p-name"> {{ $product->name }} </span>
            <span class="p-model"> {{ $product->model }} </span>
          </div>
          <div class="num clearfix">
            <span>数量：<i class="black">{{ $product->number }}{{ $product->packing_unit }}</i><i class="black">{{ $product->number*$product->content }}KG</i></span>
          </div>
          <div class="pirce">
            <span>价格：<i class="black">￥{{ $product->variable->unit_price }}</i></span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="grid">
      <div class="item" @click="show('coupon')"  v-if="coupons.length">
      <span> 优惠券</span>
      <span class="value y"><i>@{{ coupon_text }}</i> <i class="iconfont icon-zhankai"></i></span>
    </div>
    <div class="item">
      <span> 实付款</span>
      <span class="value">￥@{{ price }}</span>
    </div>

  </div>
</div>
<div class="flexbox" v-if="coupon_box">
  <div class="mask" @click="hideBox()"></div>
  <div class="coupon-list">
    <div class="tit">优惠券<small>(@{{ coupons.length }}张)</small></div>

    <div class="coupons">
      <div v-bind:class="coupon.amount>=limit_price?'item on':'item'" v-for="(coupon,index) in coupons" v-on:click="chooseCoupon(index)">
        <div class="c-h">
          <div class="ch-price">
            <span>￥@{{ parseInt(coupon.discount) }}</span>
          </div>
          <div class="ch-info">
            <p class="title">
              @{{ coupon.description }}</p>
            <p>有效期至：
              @{{ coupon.expire_time }}</p>
          </div>
        </div>
        <div class="c-f">
          <div class="circle"></div>
          <div class="circle-r"></div>
          <div class="cf-desc">
            <p>满
              @{{ parseInt(coupon.amount) }}元可用</p>
          </div>
        </div>
      </div>
    </div>
    <div class="no-use" @click="hideBox()">
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
  var app = new Vue({
    el: "#app",
    data: {
      address_id: 1,
      channel_id: 1,
      coupon_id: 0,
      freight: 0,
      coupon_text:"选择优惠券",
      limit_price:{{ $price }},
      price:{{ $price }},
      coupon_box: false,
      coupons: {!! $coupons !!},
    },
    methods: {
      show: function(mode) {
        if (mode == 'coupon') {
          this.coupon_box = true
        }
      },
      hideBox: function() {
        this.coupon_box = false;
      },
      chooseCoupon: function(index){
        var coupon = this.coupons[index];
        var amount = coupon.amount;
        var discount = coupon.discount;
        if(amount<=this.limit_price){
          this.coupon_text = "-￥"+discount;
          this.price = this.limit_price-discount;
          this.coupon_id = coupon.id;
          this.coupon_box = false;
        }else{
          alert("此红包不可用");
          this.coupon_box = false;
        }

      }
    },

    mounted: function() {}

  });

  function pay() {
    var data = {
      address_id: app.address_id,
      channel_id: app.channel_id,
      coupon_id: app.coupon_id,
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
