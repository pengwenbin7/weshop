@extends( "layouts.wechat2")
@section( "content")
<div class="container">
  <div class="product">
    <div class="info" id="info"  v-cloak>
      <div class="title">
        <div class="name">
          <h1><span>{{ $product->name }}&nbsp;&nbsp;{{ $product->model }}</span></h1>
          <h2>{{ $product->brand->name }}</h2>
        </div>
        <div :class="star?'collect on':'collect'" v-on:click="collect(star)"  >
          <span class="icons" > <i class="iconfont icon-shoucang"></i><br/>收藏</span>
        </div>
      </div>
      <div class="i-info clearfix" >
        <p>
          @if ($product->is_ton)
             <del>历史价格￥@{{ old_price }}/吨</del>
          @else
             <del>历史价格￥@{{ parseFloat(old_price) }}/{{ $product->packing_unit }}</del>
          @endif
          <span>{{ $product->pack() }}</span>&nbsp;&nbsp;
          <span>发货地：{{ $product->address }}</span>
        </p>
        <div class="i-price">
          <p class="y">￥{{ $product->price }}</p>
        </div>
      </div>
    </div>
    <div class="price-h">
      <div class="tit">
        <span>价格走势</span>
      </div>
      <div class="chart">
        <canvas id="myChart" width="600" height="400"></canvas>
      </div>
    </div>
    <div class="tips" onclick="serverShow()">
      <p>
        <span class="t-left">
                    <i class="iconfont icon-gou"></i><i class="t-t">原厂原包</i>
                    <i class="iconfont icon-gou"></i><i class="t-t">假一赔十</i>
                    <i class="iconfont icon-gou"></i><i class="t-t">包退包换</i>
                    <i class="iconfont icon-gou"></i><i class="t-t">极速发货</i>
                </span>
        <span class="t-right">
                    <i class="iconfont icon-jinru"></i>
                </span>
      </p>
    </div>

    <div class="p-desc">
      <div class="tit">
        <span>产品说明</span>
      </div>
      <p>{{ $product->detail?$product->detail->content:"暂无描述" }}
      </p>
    </div>
  </div>
</div>
<div class="buy-box" id="app" v-cloak>
  <!-- footer -->
  <div class="footer product-footer" v-on:click="showBox()">
    <span>选购</span>
  </div>

  <!-- //cart -->
  <div class="container" v-show="addr_box">
    <div class="cart">
      <div class="create" v-on:click="createCart">
        <div class="txt">
          <span class="black">新建选购单<small>(已创建{{ count(auth()->user()->carts) }}个选购单)</small>
                </span>
        </div>
        <div class="icon">
          <i class="iconfont icon-tianjia"></i>
        </div>
      </div>
      <div class="cart-list">
        @foreach (auth()->user()->carts as $index => $cart)
        <div class="item" v-on:click="addToCart( {{ $cart->id }} )">
          <div class="cart-header">
            <div class="title">
              <a>选购单{{ $index+1 }}
                  <small>(已添加{{ count($cart->cartItems) }}件商品)</small>
              </a>
            </div>
            <div class="cart-del">
              <span></span>
            </div>
          </div>
          <div class="cart-addr">
            <a>
              <div class="cart-user-info">
                <span>收货人：{{ $cart->address->contact_name }}</span>
                <span class="tel">{{ $cart->address->contact_tel }}</span>
              </div>
              <div class="cart-desc">
                <p>收货地址: {{ $cart->address->getText() }}</p>
              </div>
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
  <!-- //server-box -->
  <div v-show="server_box">
    <div class="mask" v-on:click="severHide"></div>
    <div class="server-box">
      <div class="sb-tit">
        <h2>服务说明</h2>
      </div>
      <div class="server-content">
        <div class="item">
          <div class="icon">
            <i class="iconfont icon-gou"></i>
          </div>
          <div class="sb-desc">
            <h3>原厂原包</h3>
            <p>太好买承诺所有商品均系原厂原包。</p>
          </div>
        </div>
        <div class="item">
          <div class="icon">
            <i class="iconfont icon-gou"></i>
          </div>
          <div class="sb-desc">
            <h3>假一赔十</h3>
            <p>非原厂原包商品，假一赔十。</p>
          </div>
        </div>
        <div class="item">
          <div class="icon">
            <i class="iconfont icon-gou"></i>
          </div>
          <div class="sb-desc">
            <h3>包退包换  </h3>
            <p>太好买提供七天无理由退换货。</p>
          </div>
        </div>
        <div class="item">
          <div class="icon">
            <i class="iconfont icon-gou"></i>
          </div>
          <div class="sb-desc">
            <h3>极速发货</h3>
            <p>太好买所有商品24小时内发货。</p>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- //buybox -->
  <div class="gobuy" v-show="buy_box">
    <div class="mask" v-on:click="hideBox()"></div>

    <div class="gb-box">
      <div class="swith-bth" v-if="is_ton">
        <div class="item" v-bind:class="{on:tonTap=='0'}" @click="tontap(0)">
          <span>按包选购</span>
        </div>
        <div class="item" v-bind:class="{on:tonTap=='1'}" @click="tontap(1)">
          <span>按吨选购</span>
        </div>
      </div>
      <div class="product" v-if="tonTap==0">
        <div class="title">
          <p><span >{{ $product->name }}</span><span>{{ $product->model }}</span> </p>
          <p><span >{{ $product->brand->name }}</span></p>
        </div>

        <div class="item">
          <span>金额:</span>
          <span class="value y">￥@{{ Number(unit_price)*number }}</span>
        </div>
        <div class="item">
          <span>库存:</span>
          <span class="value">{{ $product->stock }}</span>
        </div>

        <div class="inputarea clearfix">
          <div class="i-left">
            <p><span>重量:</span><span class="value">@{{ weight }}</span></p>
            <p><span class="tip">采购@{{ top }}免零售附加费</span></p>
          </div>

          <div class="quantity">
            <p class="btn-minus">
              <a class="minus" v-on:click="reduceCartNubmer()"></a>
            </p>
            <p class="btn-input">
              <input type="number" max="{{ $product->variable->stock }}" step="1" ref="goodsNum" v-model="number" v-on:blur="textCartNumber()"  @keyup="check($event)" >
            </p>
            <p class="btn-plus">
              <a class="plus"  max="{{ $product->variable->stock }}" v-on:click="addCartNumber($event)"></a>
            </p>
          </div>
        </div>



      </div>
      <div class="product" v-if="tonTap==1">
        <div class="title">
          <p><span >{{ $product->name }}</span><span>{{ $product->model }}</span> </p>
          <p><span >{{ $product->brand->name }}</span></p>
        </div>

        <div class="item">
          <span>金额:</span>
          <span class="value y">￥@{{ Number(unit_price)*number }}</span>
        </div>
        <div class="item">
          <span>库存:</span>
          <span class="value">{{ $product->stock }}</span>
        </div>


        <div class="inputarea clearfix">
          <div class="i-left">
            <p><span>重量:</span><span class="value">@{{ ton_num }}吨</span></p>
            <p><span class="tip">采购@{{ top }}免零售附加费</span></p>
          </div>

          <div class="quantity">
            <p class="btn-minus">
              <a class="minus" v-on:click="reduceCartNubmer()"></a>
            </p>
            <p class="btn-input">
              <input type="number" max="{{ $product->variable->stock*$product->content/1000 }}" step="1" ref="goodsNum" v-model="ton_num" v-on:blur="textCartNumber()"  @keyup="check($event)" >
            </p>
            <p class="btn-plus">
              <a class="plus"  max="{{ $product->variable->stock*$product->content/1000 }}" v-on:click="addCartNumber($event)"></a>
            </p>
          </div>
        </div>

      </div>
      <div class="gb-footer">
        <div class="addtocart" v-on:click="choseAddr">
          <span class="green">加入选购单</span>
        </div>
        <div class="buy-commit" v-on:click="buyMe">
          <span>立即购买</span>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section( "script")
  <script src="https://cdn.bootcss.com/Chart.js/2.7.2/Chart.js" async="async"></script>
<script>
  var app = new Vue({
    el: "#app",
    data: {
      number: {{ $product->is_ton }}?{{ 1000/$product->content }}:1,  //按包购买数量
      content:{{ $product->content }},
      ton_num:{{ $product->is_ton }},   //按吨购买数量
      tonTap: {{ $product->is_ton }},  //吨<-->包切换 1 为吨 0为包
      buy_box: false,  //购买按钮弹窗
      addr_box:false, //购物单弹窗
      server_box:false, //
      is_ton:{{ $product->is_ton }},
      unit_price:{{ $product->variable->unit_price }},
      top : '',
    },
    computed: {
      weight: function() {
        return (this.number * this.content) <= 999.99 ?
          this.number * this.content + "KG" :
          this.number * this.content / 1000 + "吨"
      }
    },
    mounted:function(){
     var func = JSON.parse('{!! $product->storage->func !!}');
     this.top = func.area.pop().up / 1000 + "吨";
   },
    methods: {
      createCart: function() {
        var $this = this;
        wx.openAddress({
          success: function(res) {
            axios.post("{{ route("wechat.address.store") }}",res)
            .then(function(res) {
              var url = "{{ route("wechat.cart.store") }}";
              var d = {
                address_id: res.data.address_id
              };
              axios.post(url, d).
              then(function(res) {
                location.reload();
              });
            });
          },
          cancel: function() {
            //
          }
        });
      },
      choseAddr: function() {
        this.buy_box = false;
        this.addr_box = true;
      },
      addToCart: function(id) {
        var _this = this
        var id = id;
        var params = {
          cart_id: id,
          product_id: "{{ $product->id }}",
          num : _this.number
        };
        axios.post("{{ route("wechat.cart.add_product") }}", params)
          .then(function(res) {
            alert("添加成功");
            location.assign("{{ route("wechat.cart.index") }}" + "/" + params.cart_id);
            _this.addr_box = false;
            _this.buy_box = false;
          });
      },
      buyMe: function() {
        location.assign("{{ route("wechat.product.buyme") }}" +
          "?product_id={{ $product->id }}"+"&&num="+this.number
        );
      },
      showBox: function() {
        this.buy_box = true;
      },
      hideBox: function() {
        this.buy_box = false;
      },
      severHide: function() {
        this.server_box = false;
      },
      reduceCartNubmer: function() {
        if(this.tonTap){
         if(this.ton_num>1){
           this.ton_num = Math.ceil(this.ton_num) - 1;
         }
         this.number = this.ton_num * 1000/this.content;
        }else{
          if(this.number>1){
            this.number = Math.ceil(this.number) - 1;
          }
        }
      },
      addCartNumber: function(event) {
        var dom = event.currentTarget
        var max = dom.getAttribute("max");
        if(this.tonTap){
          if(this.ton_num+1<max){
            this.ton_num++
          }else{
            alert("购买商品超出库存");
            this.ton_num = max;
          }
          this.number = this.ton_num * 1000/this.content;
        }else{
           if(this.number<max){
             this.number++
        }
      }

      },
      textCartNumber: function(a) {
        var dom = event.currentTarget
        var max =Number(dom.max);
        if(this.tonTap){
          if(this.ton_num>max){
            alert("购买商品超出库存");
            this.ton_num = max;
          }
        }else{
           if(this.number>max){
             alert("购买商品超出库存");
             this.number = max;
           }
        }
      },
      tontap: function(index) { //切换吨<-->包
        var _this = this;
        this.tonTap = index;
        //切换时同步数量
        if (index == 1) {
          this.ton_num = this.number * this.content / 1000;
          this.number = this.ton_num * 1000 / this.content;
        } else {
          this.number = this.ton_num * 1000 / this.content;
          this.ton_num = this.number * this.content / 1000;
        }
      },
      check(event){
        var dom = event.currentTarget
        var num = dom.value;
        num = num.replace(/\D/g, '');
        num = (isNaN(num) ? 1 : num); //只能为数字
        num = num > 0 ? num : 0;
        if(this.tonTap==1){
          this.ton_num = num;
          dom.value = num;
        }else{
          this.number =num;
          this.ton_num = num*this.content/1000;
          dom.value = num;
        }
      }
    }
  });

  function serverShow() {
    var _this = app;
    _this.server_box = true;
  }
  var app2 = new Vue({
    el: "#info",
    data: {
      star:"{{ $product->star }}",
      prices:{!! $product->prices !!},
      is_ton:{{ $product->is_ton }},
      content:{{ $product->content }},
      old_price:"",
      time:[],
      pri:[],
    },
    mounted:function(){
      var prices = this.prices;
      var time = [],pri = [];
      for (var i = 0; i < prices.length; i++) {
        time.push(prices[i].updated)
        if(this.is_ton){
          pri.push(Number(prices[i].unit_price) * 1000 / Number(this.content))
        }else{
          pri.push(prices[i].unit_price)
        }

      }
      if(prices.length>1){
         this.old_price = pri[pri.length-2];
      }else{
        this.old_price = pri[pri.length-1];
      }

       this.time = time;
       this.pri = pri;
    },
    methods: {
      collect: function(mode) {
        var _this = this;
        if(mode){
          axios.get("{{ route("wechat.unstar",$product->id)}}")
          .then(function(){
            _this.star = false;
          })
        }else{
          axios.get("{{ route("wechat.star",$product->id)}}")
          .then(function(){
            _this.star = true;
          })
        }
        // 收藏
      }
    }
  })

  onload = function() {
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: generateLabels(),
        datasets: [{
          label: '价格(元/吨)',
          data: generateDate(),
          borderWidth: 1,
          borderColor: "#00B945",
          backgroundColor: "#00B945",
          fill: false,

        }]
      },
      options: {
        responsive: true,
        title: {
          display: false,
          text: ''
        },
        legend: {
          display: false
        },
        elements: {
          line: {
            tension: 0.000001
          }
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: false,
              labelString: '日期'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: false,
              labelString: '价格元/吨'
            }
          }]
        }
      }
    });

    function generateLabels() {
      var arr = app2.time;
      return arr;
    }

    function generateDate() {
      var arr = app2.pri;
      return arr;
    }
  }
</script>
@endsection
