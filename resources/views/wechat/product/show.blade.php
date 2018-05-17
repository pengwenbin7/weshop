@extends("layouts.wechat2")

@section("style")
<style>
.cart{
  height:100%;
  position:fixed;
  bottom:0;
  background:#fff;
}
.container .cart {
    margin-top: 0;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    background: #fff;

}
  .server-box{position: fixed;width: 100%;bottom: 0;left: 0;background-color: #fff;font-size: .32rem;z-index: 11111;}
  .server-box .sb-tit h2{height: 1rem;line-height: 1rem;font-size: .32rem;text-align: center;letter-spacing: 2px;border-bottom: 1px solid #eee;}
  .server-box .server-content{padding: 0 .4rem;padding-bottom: 1.4rem;}
  .server-box .item{display: flex;display: -webkit-flex; border-bottom: 1px solid #eee; height: 1rem;padding: .15rem 0;}
  .server-box .item .icon{width: .7rem;}
  .server-box .item .icon i{color: #ff782f;}
  .server-box .item .sb-desc{flex: 1;-webkit-flex:1;}
  .sb-desc h3{height: .35rem;line-height: .35rem;font-size: .3rem;}
  .sb-desc p{height: .35rem;line-height: .35rem;font-size: .26rem}
</style>

@endsection

@section("content")
<div class="container">
    <div class="product">

        <div class="info" id="info">
            <div class="collect" v-on:click="collect({{ $product->id }})">
                <span class="icons">
                    <i class="iconfont icon-shoucang"></i>
                </span>
            </div>
            <h1>
                <span>
                    {{ $product->brand->name }}</span>
                <span>
                    {{ $product->name }}</span>
                <span>{{ $product->model }}</span>
            </h1>

            <div class="i-info">
                <p>
                    <del>历史价格￥788800/吨</del>
                    <span>{{ $product->pack() }}</span>
                </p>
                <div class="i-price">
                    <p class="y">{{ $product->variable->unit_price*1000 }}/吨</p>
                    <p></p>
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
                <span>
                    <i class="iconfont icon-gou"></i>原厂原包</span>
                <span>
                    <i class="iconfont icon-gou"></i>假一赔十</span>
                <span>
                    <i class="iconfont icon-gou"></i>包退包换</span>
                <span>
                    <i class="iconfont icon-gou"></i>极速发货</span>
                <span class="right">
                    <i class="iconfont icon-jinru"></i>
                </span>
            </p>
        </div>

        <div class="p-desc">
            <div class="tit">
                <span>产品说明</span>
            </div>
            <p>{{ $product->detail->content }}
            </p>
        </div>
    </div>
</div>
 <div class="buy-box" id="app">
    <!-- footer -->
    <div class="footer product-footer" v-on:click="showBox()">
        <span>选购</span>
    </div>

    <!-- //cart -->
    <div class="container" v-if="addr_box">
    <div class="cart" >
        <div class="create" v-on:click="createCart">
            <div class="txt">
                <span class="black">新建选购单<small>(已创建1个采购单)</small>
                </span>
            </div>
            <div class="icon">
                <i class="iconfont icon-tianjia"></i>
            </div>
        </div>
        <div class="cart-list">
            @foreach (auth()->user()->carts as $cart)
            <div class="item" v-on:click="addToCart( {{ $cart->id }} )">
                <div class="cart-header">
                    <div class="title">
                        <a >采购单1
                            <small>(已添加2件商品)</small>
                        </a>
                    </div>
                    <div class="cart-del">
                        <span></span>
                    </div>
                </div>
                <div class="cart-addr">
                    <a >
                        <div class="cart-user-info">
                            <span>收货人：</span>
                            <span class="tel"></span>
                        </div>
                        <div class="cart-desc">
                            <p>收货地址:
                                {{ $cart->address->getText() }}</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>
    <!-- //server-box -->
    <div  v-if="server_box">
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
              <p>我们承诺，太好买所有商品均系厂家直供原厂原包</p>
            </div>
          </div>
          <div class="item">
            <div class="icon">
              <i class="iconfont icon-gou"></i>
            </div>
            <div class="sb-desc">
              <h3>原厂原包</h3>
              <p>我们承诺，太好买所有商品均系厂家直供原厂原包</p>
            </div>
          </div>
          <div class="item">
            <div class="icon">
              <i class="iconfont icon-gou"></i>
            </div>
            <div class="sb-desc">
              <h3>原厂原包</h3>
              <p>我们承诺，太好买所有商品均系厂家直供原厂原包</p>
            </div>
          </div>
          <div class="item">
            <div class="icon">
              <i class="iconfont icon-gou"></i>
            </div>
            <div class="sb-desc">
              <h3>原厂原包</h3>
              <p>我们承诺，太好买所有商品均系厂家直供原厂原包</p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- //buybox -->
    <div class="gobuy" v-if="buy_box">
        <div class="mask" v-on:click="hideBox()"></div>

        <div class="gb-box">
            <div class="swith-bth"  v-if="is_ton">
                <div class="item" v-bind:class="{on:tonTap=='1'}" @click="tontap(1)">
                    <span>按包选购</span>
                </div>
                <div class="item" v-bind:class="{on:tonTap=='2'}" @click="tontap(2)">
                    <span>按吨选购</span>
                </div>
            </div>
            <div class="product" v-if="tonTap==1">
                <div class="item title  clearfix">
                    <span class="p-bname">{{ $product->brand->name }}</span>
                    <span class="p-name">
                        {{ $product->name }}
                    </span>
                    <span class="p-model">{{ $product->model }}
                    </span>
                </div>
                <div class="item clearfix">
                  <span>重量</span>
                  <span class="value"><i ref = "productW">@{{ weight }}</i></span>
                    <div class="quantity">
                        <p class="btn-minus">
                            <a class="minus" v-on:click="reduceCartNubmer()"></a>
                        </p>
                        <p class="btn-input">
                            <input type="tel" name="" ref="goodsNum" step="1" v-bind:value="num" v-on:blur="textCartNumber()">
                        </p>
                        <p class="btn-plus">
                            <a class="plus" v-on:click="addCartNumber()"></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="product" v-if="tonTap==2">
                <div class="item title  clearfix">
                    <span class="p-bname">{{ $product->brand->name }}</span>
                    <span class="p-name">
                        {{ $product->name }}
                    </span>
                    <span class="p-model">{{ $product->model }}
                    </span>
                </div>
                <div class="item clearfix">
                  <span>重量</span>
                  <span class="value"><i >@{{ ton_num }}</i>吨</span>
                    <div class="quantity">
                        <p class="btn-minus">
                            <a class="minus" v-on:click="reduceCartNubmer()"></a>
                        </p>
                        <p class="btn-input">
                            <input
                                type="tel" step="1" ref="goodsNum"  v-bind:value="ton_num"  v-on:blur="textCartNumber()">
                        </p>
                        <p class="btn-plus">
                            <a class="plus" v-on:click="addCartNumber()"></a>
                        </p>
                    </div>
                </div>


            </div>
            <div class="gb-footer">
                <div class="addtocart" v-on:click="choseAddr">
                    <span class="green">加入采购单</span>
                </div>
                <div class="buy-commit" v-on:click="buyMe">
                    <span >立即购买</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
      cart_id: null,
      cart_addr: null,
      num: {{ 1000/$product->content }},  //按包购买数量
      content:{{ $product->content }},
      ton_num:2,   //按吨购买数量
      tonTap: "2",  //吨<-->包切换
      buy_box: false,  //购买按钮弹窗
      addr_box:false, //购物单弹窗
      server_box:false, //
      stock:{{ $product->variable->stock*$product->content }},
      is_ton:{{ $product->is_ton }}
    },
    computed: {
			weight: function () {
				return (this.num*this.content)<=999.99?
        this.num*this.content+"KG":
        this.num*this.content/1000+"吨"
			}
		},
    methods: {
      createCart: function () {
        var $this = this;
        wx.openAddress({
          success: function (res) {
            axios.post(
              "{{ route("wechat.address.store") }}",
              res
            ).then(function (res) {
              var url = "{{ route("wechat.cart.store") }}";
              var d = {
          address_id: res.data.address_id
              };
              axios.post(url, d).
          then(function (res) {
            location.reload();
          });
            });
          },
          cancel: function () {
            //
          }
        });
      },
      choseAddr:function(){
        this.buy_box = false;
        this.addr_box = true;
      },
      addToCart: function (id) {
        var _this = this
        var id = id;
        var params = {
          cart_id: id,
          product_id: "{{ $product->id }}"
        };
        axios.post("{{ route("wechat.cart.add_product") }}", params)
          .then(function (res) {
            alert("添加成功");
            _this.addr_box = false;
            _this.buy_box = false;
          });
      },
      buyMe: function () {
        location.assign("{{ route("wechat.product.buyme") }}" +
          "?product_id={{ $product->id }}"
        );
      },
      showBox: function() {
        this.buy_box = true;
      },
      hideBox: function() {
        this.buy_box = false;
      },
      severHide:function(){
        this.server_box=false;
      },
      goBuy: function() {
        console.log(1)
        location.href = "./order_confirm.html"
      },
      reduceCartNubmer: function() {
        setNum(this, "reduce");
      },
      addCartNumber: function(a) {
        setNum(this, "add");
      },
      textCartNumber: function(a) {
        // setPrice(this, "blur");
      },
      tontap: function(index) {  //切换吨<-->包
        var _this = this;
        this.tonTap = index;
        //切换时同步数量
        if(index ==1){
          this.num = this.ton_num*1000/this.content;
        }else{
          this.ton_num = Math.ceil(this.num*this.content/1000) ;
        }
      }
    }
  });
  function setNum(_this, mode) { // mode  方式  ： 加 -减   blur
        // 点击加减更新 num与ton_num的值
        var _this = _this;
        var mode = mode;
        var limit = _this.stock;
        var n_num = 0;//临时数量
        if (_this.tonTap==1){
          // console.log(_this.num);
          _this.num = getNum(_this,mode,_this.num);

        }else if(_this.tonTap==2){
          // console.log(getNum(_this,mode,_this.ton_num));
          _this.ton_num = getNum(_this,mode,_this.ton_num)
        }


      }
    function getNum(_this,mode,n_num){
      var weight = 0;
      if(_this.tonTap==1){
        weight = (n_num+1) * _this.content;
      }else{
        weight = (n_num+1) * 1000;
      }
    console.log(weight);
      var limit = _this.stock;
      if(mode == "reduce") {
        console.log(n_num);
          if(n_num <= 1) {
            console.log(n_num);
            return 1;
          } else {
            return n_num-1;
          }
        } else if(mode == "add") {
        if(weight >= limit) {
          alert("购买达到最大数量")
          return;
        } else {
          return n_num+1;
        }
      }
    }
    function serverShow(){
      var _this = app;
      _this.server_box=true;
    }
    var app2 = new Vue({
      el: "#info",
      data: {

      },
      methods:{
        collect:function(id){
          // 收藏
        }
      }
    })
  </script>
  <script src="https://cdn.bootcss.com/Chart.js/2.7.2/Chart.js" async="async"></script>
  <script type="text/javascript">
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
        // console.log({!! $product->prices !!})

        function generateLabels() {
          var arr = ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"]
          return arr;
        }

        function generateDate() {
          var arr = [7888, 7890, 8288, 8388, 7999, 7890, 8130, 8210, 7990, 7888, 8000, 7989]
          return arr;
        }
      }
    </script>
@endsection
