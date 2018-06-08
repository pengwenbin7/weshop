@extends( "layouts.wechat2")
@section( "content")
<div class="container" id="app" v-lock>
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
    <div class="products" v-for="items in products" >
      <div class="product" v-for="product in items">
        <div class="p-info">
          <div class="num clearfix">
            <span>品名：<i class="black"> @{{ product.name }}</i></span>
          </div>
          <div class="num clearfix">
            <span>型号：<i class="black"> @{{ product.model }}</i></span>
          </div>
          <div class="num clearfix">
            <span>厂商：<i class="black"> @{{ product.brand_name }}</i></span>
          </div>
          <div class="pirce">
            <span>单价：<i class="black">￥@{{ product.price }}</i></span>
          </div>
          <div class="num clearfix">
            <span>数量：<i class="black">@{{ product.number }}@{{ product.packing_unit }}</i><i class="black">@{{ Number(product.number) * Number(product.content) }}KG</i></span>
          </div>

        </div>
      </div>
    </div>
    <div class="grid">
      <div class="item">
      <span> 零售附加</span>
      <span class="value"><i>@{{ freight }}</i> </span>
    </div>
      <div class="item" @click="show('coupon')"  v-if="coupons.length">
      <span> 优惠券</span>
      <span class="value y"><i>@{{ coupon_text }}</i> <i class="iconfont icon-zhankai"></i></span>
    </div>
    <div class="item">
      <span> 实付款</span>
      <span class="value y">￥@{{ price+freight-coupon_discount }}</span>
    </div>

  </div>
</div>
<div class="flexbox" v-if="coupon_box"  v-lock>
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
  var app = new Vue({
    el: "#app",
    data: {
      products:{!! $products !!},
      address_id: 1,
      channel_id: 1,
      coupon_id: null,
      freight: 0,
      coupon_text:"选择优惠券",
      limit_price:0,
      price:0,
      coupon_box: false,
      coupons: {!! $coupons !!},
      coupon_discount : 0,
    },
    beforeMount:function(){
      count(this);
    },
    methods: {
      show: function(mode) {
        if (mode == 'coupon') {
          this.coupon_box = true
        }
      },
      hideBox: function(m) {
        this.coupon_box = false;
        if(m=="coupon"){
          this.coupon_discount = 0;
          this.coupon_text = "选择优惠券";
          this.coupon_id = null;
        }
      },
      chooseCoupon: function(index){
        var coupon = this.coupons[index];
        var amount = coupon.amount;
        var discount = coupon.discount;
        if(amount<=this.limit_price){
          this.coupon_text = "-￥"+discount;
          this.coupon_discount = discount;
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
  function count(_this){
    var _this = _this;
    var products = _this.products;
    var fee = 0, distance = 0, weight = 0, total = 0,limit_price = 0, func;
    //循环数组获得距离-和公式
    for (var n in products) {
      weight = 0;
      distance = products[n][0].distance;
      func     = JSON.parse(products[n][0].func);
      for (var m in products[n]) {
          weight += products[n][m].number * Number(products[n][m].content);
          total  += products[n][m].number * Number(products[n][m].price)
      }
        fee += freight(func, weight, distance);
        console.log("物品总计  =>   "+total+"     运费计算(kg)  =>   "+fee);
    }
    _this.freight = fee;
    _this.price = total;
    //赋值

  }
  function freight(func, weight, distance) {
    var fee = 0;
    func.area.forEach(function(e, index, array) {
      if (e.low <= weight && weight < e.up) {
        fee = e.factor * distance + e.const;
        return
      }
    });
    return fee ? fee : func.other.factor * distance + func.other.const;
  }
  console.log({!! $products !!});
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
