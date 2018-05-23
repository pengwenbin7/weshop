@extends( "layouts.wechat2")

@section( "content")
<div class="container" id="app">
  <div class="order">

    <div class="address">
      <div class="a-info" v-on:click="selectAddress" >
        <p v-if="!address_id">点击选择地址</p>
        <div class="name" v-if="address_id">
          <span class="user-name">@{{ name }}</span>
          <span>@{{ tel }}</span>
        </div>
        <div class="a-dist" v-if="address_id">
          <p>
            @{{ dist }}</p>
        </div>
      </div>
      <div class="right-arrow">
        <i class="iconfont icon-jinru"></i>
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
            <span>价格：<i class="black">￥{{ $product->variable->unit_price*25 }}</i></span>
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
      is_ton: {{ $product -> is_ton }},
      show_number: 1,
      address_id:  null,
      channel_id: 1,
      freight: 0,
      paymode: false,
      curpon: false,
      content: {{ $product -> content }},
      name: '',
      tel: '',
      dist: ''
    },
    computed: {
      number: function() {
        return 0 == this.is_ton ?
          this.show_number :
          this.show_number * 1000 / {{ $product -> content }};
      },
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
        this.curpon = true
      },
      hideBox: function() {
        this.paymode = false;
        this.curpon = false;
      },
      // storage default freight function
      storageFunc: function() {
        var func = JSON.parse('{!! $product->storage->func !!}');
      },

      selectAddress: function() {
        var _this = this;
        wx.openAddress({
          success: function(res) {
            _this.name = res.userName;
            _this.tel = res.telNumber;
            _this.dist = res.provinceName + res.cityName + res.countryName + res.detailInfo;
            axios.post("{{ route("wechat.address.store") }}", res)
              .then(function(res) {
                _this.address_id = res.data.address_id;
              });
          },
          cancel: function() {
            alert("取消");
          }
        });
      },

      pay: function() {
        var data = {
          address_id: this.address_id,
          channel_id: this.channel_id,
          products: [{
            number: this.number,
            id: {{ $product -> id }}
          }]
        };
        alert(JSON.stringify(data))
        axios.post("{{ route("wechat.order.store") }}", data)
          .then(function(res) {
            location.assign("{{ route("wechat.pay") }}" +
              "/?order_id=" + res.data.store);
          });
      },

      countFreight: function() {
        var $this = this;
        var data = {
          address_id: this.address_id,
          products: [{
            id: {{ $product -> id }},
            number: $this.number
          }]
        };
        axios.post("{{ route("wechat.order.count-freight") }}",
          data).then(function(res) {
          $this.freight = res.data;
        });
      }
    },

    mounted: function() {}

  });
  wx.ready(function() {
    var _this = app;
    wx.openAddress({
      success: function(res) {
        _this.name = res.userName;
        _this.tel = res.telNumber;
        _this.dist = res.provinceName + res.cityName + res.countryName + res.detailInfo;
        axios.post("{{ route("wechat.address.store") }}", res)
          .then(function(res) {
            _this.address_id = res.data.address_id;
          });
      },
      cancel: function() {
        //
      }
    });
  });

  function pay() {
    var data = {
      address_id: app.address_id,
      channel_id: app.channel_id,
      products: [{
        number: app.number,
        id: {{ $product->id }}
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
