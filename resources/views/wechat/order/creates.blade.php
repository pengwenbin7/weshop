@extends("layouts.wechat2")

@section("content")
  <div class="container" id="app">
    <div class="order">

      <div class="address">
	<div class="a-info" >
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
		<span>数量：<i class="black">{{ $product->number }}包</i><i class="black">{{ $product->number*$product->content }}KG</i></span>

	      </div>
	      <div class="pirce">
		<span>价格：<i class="black">￥{{ $product->variable->unit_price }}</i></span>
	      </div>
	    </div>
	  </div>
	@endforeach
      </div>
      <div class="grid">
	<div class="item" @click="show('curpon')">
	  <span> 优惠券</span>
	  <span class="value y">-￥300 <i class="iconfont icon-zhankai"></i></span>
	</div>
	<div class="item">
	  <span> 实付款</span>
	  <span class="value">￥300</span>
	</div>

      </div>
    </div>
    <div class="flexbox" v-if="curpon">
      <div class="mask" @click="hideBox()"></div>
      <div class="coupon-list">
	<div class="tit">优惠券<small>({{ count($coupons) }}张可用)</small></div>

	<div class="coupons">
	  @foreach ($coupons as $coupon)
	    <div class="item">
	      <div class="c-h">
		<div class="ch-price">
		  <span>￥{{ intval($coupon->discount) }}</span>
		</div>
		<div class="ch-info">
		  <p class="title">{{ $coupon->description }}</p>
		  <p>有效期至：{{ date("Y-m-d", strtotime($coupon->expire) ) }}</p>
		</div>
	      </div>
	      <div class="c-f">
		<div class="circle"></div>
		<div class="circle-r"></div>
		<div class="cf-desc">
		  <p>满{{ intval($coupon->amount) }}元可用</p>
		</div>
	      </div>
	    </div>
	  @endforeach
	</div>
	<div class="no-use" @click="hideBox()">
	  <span>不使用优惠券</span>
	</div>
      </div>
    </div>
  </div>
  <div class="footer order-footer" onclick="pay()">
    <div class="item"  v-on:click="pay">
      <span>提交订单</span>
    </div>
  </div>

@endsection

@section("script")

  <script>
  var app = new Vue({
    el: "#app",
    data: {
      address_id:1,
      channel_id: 1,
      freight: 0,
      paymode:false,
      curpon:false,
    },
    beforeCreate: function () {
      var _this = this;
      if(!this.address_id){
	//选择地址
	console.log(this.address_id);
      }
    },
    methods: {
      show:function(mode){
	if(mode == 'paymode'){
	  this.paymode = true;
	}else{
	  this.curpon = true
	}
      },
      hideBox:function(){
	this.paymode=false;
	this.curpon = false;
      },
      // storage default freight function
      storageFunc: function () {
	var func = JSON.parse('{!! $product->storage->func !!}');
      },

      selectAddress: function () {
	var $this = this;
	wx.openAddress({
	  success: function (res) {
	    axios.post(
	      "{{ route("wechat.address.store") }}",
	      res
	    ).then(function (res) {
	      $this.address_id = res.data.address_id;
	    });
	  },
	  cancel: function () {
	    alert("取消");
	  }
	});
      },



      countFreight: function () {
	var $this = this;
	var data = {
	  address_id: this.address_id,
	  products: [
	    {id: {{ $product->id }}, number: $this.number}
	  ]
	};
	axios.post("{{ route("wechat.order.count-freight") }}",
	  data).then(function (res) {
	    $this.freight = res.data;
	  });
      }
    },

    mounted: function () {
    }

  });

  function pay () {
    var data = {
      address_id: app.address_id,
      channel_id: app.channel_id,
      products: [
	{
	  number: 1,
	  id: 1
	}
      ]
    };
    axios.post("{{ route("wechat.order.store") }}", data)
      .then(function (res) {
	    location.assign("{{ route("wechat.pay") }}" +
	  "/?order_id=" + res.data.store);
      });
  }
  </script>
@endsection
