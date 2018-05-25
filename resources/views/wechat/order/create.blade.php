@extends( "layouts.wechat2")
@section( "style")
  <style media="screen">
  [v-cloak] {
    display: none;
  }
  </style>
@endsection
@section( "content")
  <div class="container" id="app" v-cloak>
    <div class="order">

      <div class="address">
	<div class="a-info" v-on:click="selectAddress" >
          <p v-if="!address_id">点击选择地址</p>
          <div class="name" v-if="address_id">
            <span class="user-name">@{{ name }}</span>
            <span>@{{ tel }}</span>
          </div>
          <div class="a-dist" v-if="address_id">
            <span>
              @{{ dist }}</span>
          </div>
	</div>
	<div class="right-arrow">
          <i class="iconfont icon-jinru"></i>
	</div>
      </div>
      <div class="products">
	<div class="product">
          <div class="p-info">
            <div class="title" v-on:click="countFreight">
              <span class="p-bname">  {{ $products->brand->name }}</span>
              <span class="p-name"> {{ $products->name }} </span>
              <span class="p-model"> {{ $products->model }} </span>
            </div>
            <div class="num clearfix">
              {{-- <span>数量：<i class="black">@{{ number }}包</i><i class="black">25KG</i></span> --}}
              <span>重量：</span>
              <div class="quantity">
		<p class="btn-minus">
                  <a class="minus" v-on:click="reduceCartNubmer()"></a>
		</p>
		<p class="btn-input">
                  <input type="tel" name="" ref="goodsNum" step="1" v-bind:value="number" v-on:blur="textCartNumber()">
		</p>
		<p class="btn-plus">
                  <a class="plus" v-on:click="addCartNumber()"></a>
		</p>
              </div>
              (包)
              <i class="black">@{{ weight }}</i>
            </div>

            <div class="pirce">
              <span>价格：
                <i class="black" v-if="!address_id">选择地址后显示价格</i>
                <i class="black" v-if="address_id">￥@{{ number*unit_price+freight }}</i>
              </span>
            </div>
          </div>
	</div>
      </div>
      <div class="grid">
	<div class="item" @click="show('coupon')"  v-if="coupons.length&&address_id ">
	  <span> 优惠券</span>
	  <span class="value y"><i>@{{ coupon_text }}</i> <i class="iconfont icon-zhankai"></i></span>
	</div>
	<div class="item">
          <span> 实付款</span>
          <span class="value"  v-if="!address_id">选择地址后显示价格</span>
          <span class="value" v-if="address_id">@{{ number*unit_price+freight-coupon_discount }}</span>
	</div>

      </div>
    </div>
    <div class="flexbox" v-if="coupon_box">
      <div class="mask" @click="hideBox()"></div>
      <div class="coupon-list">
	<div class="tit">优惠券<small>(@{{ coupons.length }}张)</small></div>

	<div class="coupons">
          <div v-bind:class="coupon.amount>=(number*unit_price+freight)?'item on':'item'" v-for="(coupon,index) in coupons" v-on:click="chooseCoupon(index)">
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
    <div class="item">
      <span>提交订单</span>
    </div>
  </div>
@endsection

@section( "script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
      number: {{ $products->number }},
      address_id:  null,
      p_address_id:{{ $products->storage->address_id  }},
      freight: 0,
      channel_id: 1,
      coupon_id: 0,
      coupon_discount:0,
      coupon_amount:0,
      coupon_text:"选择优惠券",
      unit_price:{{$products->variable->unit_price }},
      coupons: {!! $coupons !!},
      distance:0,
      coupon_box: false,
      content: {{ $products->content }},
      name: '',
      tel: '',
      dist: ''
    },
    computed: {
      weight: function() {
        return this.number * this.content > 999.99 ?
          this.number * this.content / 1000 + "吨" :
          this.number * this.content + "KG"
      }
    },
    beforeCreate: function() {
      var _this = this;
      if (!this.address_id) {
        //选择地址
        console.log(this.address_id);

      }
    },
    methods: {
      show: function(mode) {
        this.coupon_box = true
      },
      hideBox: function(m) {
        this.coupon_box = false;
        if(m=="coupon"){
          this.coupon_discount = 0;
          this.coupon_text = "选择优惠券";
        }
      },
      // storage default freight function
      storageFunc: function() {
        var func = JSON.parse('{!! $products->storage->func !!}');
      },
      chooseCoupon: function(index){
        var coupon = this.coupons[index];
        var amount = coupon.amount;
        var discount = coupon.discount;
        var limit_price = this.number*this.unit_price+this.freight;
        if(amount<=limit_price){
          this.coupon_text = "-￥"+discount;
          this.coupon_discount =discount;
          this.coupon_amount =coupon.amount;
          this.coupon_id = coupon.id;
          this.coupon_box = false;
        }else{
          alert("此红包不可用");
          this.coupon_box = false;
        }

      },
      selectAddress: function() {
        oAddress();

      },
      reduceCartNubmer: function(i, a) {
        var _this = this;
        if (_this.number <= 1) {
          return
        } else {
          //点击减少，发送请求，成功后数量减一
          console.log(_this.number);
          _this.number--;
          _this.countFreight();
          if(_this.coupon_amount<=(_this.number*_this.unit_price+_this.freight)){
            return
          }else{
            _this.coupon_discount = 0;
            _this.coupon_text = "选择优惠券";

          }
        }
      },
      textCartNumber: function(){
        this.number = Number(this.$refs.goodsNum.value);
        this.countFreight();
      },
      addCartNumber:function(){
        var _this = this;
        _this.number++;
        this.countFreight();
      },
      countFreight: function() {
        var weight = this.number * this.content;
        var distance = this.distance;
        var func = JSON.parse('{!! $products->storage->func !!}');
        this.freight =Math.floor(freight(func,weight,distance));
      }
    },
    mounted: function() {



    }
  });

  function freight(func, weight, distance) {
    var freight = 0;
    console.log(func, weight, distance);
    func.area.forEach(function(e, index, array) {
      if (e.low <= weight && weight < e.up) {
        freight = e.factor * distance + e.const;
        return
      }
    });
    return freight ? freight : func.other.factor * distance + func.other.const;
  }

  wx.ready(function() {
    oAddress();
  });
  function oAddress(){
    wx.openAddress({
      success: function(res) {
	      var _this = app;
        _this.name = res.userName;
        _this.tel = res.telNumber;
        _this.dist = res.provinceName + res.cityName + res.countryName + res.detailInfo;
        axios.post("{{ route("wechat.address.store") }}", res)
          .then(function(res1) {
            _this.address_id = res1.data.address_id;
            var param ={
              from: _this.address_id,
              to: _this.p_address_id,
            }
            axios.post("{{ route("wechat.tool.distance") }}", param)
              .then(function(res2) {
                alert(res2)
                if(res2.data<0){
                  alert("你的地址有误，请重新添加");
                }else{
                  _this.distance = res2.data;
                  _this.countFreight();
                }

              });

          });

      },
      cancel: function() {
        //
      }
    });
  }
  function pay() {
    var data = {
      address_id: app.address_id,
      channel_id: app.channel_id,
      coupon_id: app.coupon_id,
      products: [{
        number: app.number,
        id: {{ $products->id }}
      }]
    };
    if(app.address_id){
      axios.post("{{ route("wechat.order.store") }}", data)
        .then(function(res) {
          location.assign("{{ route("wechat.pay") }}" +
            "/?order_id=" + res.data.store);
        });
    }else{
      alert("请先选择收货地址");
    }

  }
  </script>
@endsection
