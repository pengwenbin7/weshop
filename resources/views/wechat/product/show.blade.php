@extends("layouts.wechat2")

@section("style")
@endsection

@section("content")
	<div class="product" id="app">
		<div class="container">
			<div class="info">
				<div class="collect">
					<span class="icons">
								<i class="iconfont icon-shoucang"></i>
							</span>
				</div>
				<h1><span> {{ $product->brand->name }}</span><span> {{ $product->name }}</span><span>{{ $product->model }}</span></h1>
				<div class="i-info">
					<div class="i-price">
						<p>￥{{ $product->variable->unit_price*1000 }}</p>
						<p><del>历史价格￥788800/吨历史价格￥788800/吨</del></p>
					</div>
					<div class="i-size">
						<p>{{ $product->pack() }}</p>
						<p>发货地：上海</p>
					</div>
				</div>
				<div class="tips">
					<p>此价格为满30吨优惠价，实际价格根据你的位置和数量有所调整</p>
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

			<div class="p-desc">
				<div class="tit">
					<span>产品说明</span>
				</div>
				<p>具有高白度、质软易分散悬浮于水中，良好的可塑性 和高的粘结性、优良的电绝缘性能以及良好的抗酸溶 液、很低的阳离子交换容量。
				</p>
			</div>
			<div class="footer" v-on:click="showBox()">
        <span>选购</span>
      </div>


			<div class="gobuy" v-bind:class='{hide:active=="0"}'>
        <div class="mask" v-on:click="hideBox()">
        </div>
        <div class="gb-box">
          <div class="swith-bth">
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
              <span class="p-name"> {{ $product->name }} </span>
              <span class="p-model">{{ $product->model }} </span>
            </div>
            <div class="item clearfix">
              <span>数量</span>
              <div class="quantity">
                <p class="btn-minus">
                  <a class="minus" v-on:click="reduceCartNubmer()"></a>
                </p>
                <p class="btn-input"><input type="tel" name="" ref="goodsNum" value="1" data-arr="{'limit':100,'price':{{ $product->variable->unit_price }},'weight':{{ $product->content }}}" v-on:blur="textCartNumber()"></p>
                <p class="btn-plus">
                  <a class="plus" v-on:click="addCartNumber()"></a>
                </p>
              </div>
            </div>
            <div class="item clearfix">
              <span>重量</span><span class="right"><i ref = "productW">25</i>KG</span>
            </div>
            <div class="item clearfix">
              <span>价格</span><span class="right">￥<i ref = "totalPriceD">30850</i></span>
            </div>
          </div>
          <div class="product" v-if="tonTap==2">
            <div class="item title  clearfix">
							<span class="p-bname">{{ $product->brand->name }}</span>
              <span class="p-name"> {{ $product->name }} </span>
              <span class="p-model">{{ $product->model }} </span>
            </div>
            <div class="item clearfix">
              <span>数量</span>
              <div class="quantity">
                <p class="btn-minus">
                  <a class="minus" v-on:click="reduceCartNubmer()"></a>
                </p>
                <p class="btn-input"><input type="tel" name="" ref="goodsNum" value="1" data-arr="{'limit':100,'price':{{ $product->variable->unit_price }},'weight':1000}" v-on:blur="textCartNumber()"></p>
                <p class="btn-plus">
                  <a class="plus" v-on:click="addCartNumber()"></a>
                </p>
              </div>
            </div>
            <div class="item clearfix">
              <span>重量</span><span class="right"><i ref = "productW">25</i>KG</span>
            </div>
            <div class="item clearfix">
              <span>价格</span><span class="right">￥<i ref = "totalPriceD">30850</i></span>
            </div>
          </div>
          <div class="gb-footer">
            <div class="buy-commit"  v-on:click="buyMe">
              <span class="green">立即购买</span>
            </div>
            <div class="addtocart" v-on:click="addToCart">
              <span>加入采购单</span>
            </div>
          </div>
        </div>
      </div>
	</div>

    <!-- <p>product id: {{ $product->id }}</p>
    <p>name:</p>
    <p>brand name:</p>
    <p>brand id: {{ $product->brand->id }}</p>
    <p>storage name: {{ $product->storage->name }}</p>
    <p>is ton: {{ $product->is_ton }}</p>
    <p>unique code: {{ $product->unique_code }}</p>
    <p>pack: {{ $product->pack() }}</p>
    <p>unit price: {{ $product->variable->unit_price }}</p>
    <p>stock: {{ $product->variable->stock }}</p>
    <p>buy: {{ $product->variable->buy }}</p> -->

   
      @if (auth()->user()->carts->isNotEmpty())
	<select v-model="cart_id">
	  @foreach (auth()->user()->carts as $cart)
	    <option value="{{ $cart->id }}">{{ $cart->address->getText() }}</option>
	  @endforeach
	</select>
	 
	新建采购单:
	<button v-on:click="createCart">createCart</button>
      @else
	新建采购单:
	<button v-on:click="createCart">createCart</button>
      @endif
<!-- <div>
      <button v-on:click="addToCart">add to cart</button>
      <button v-on:click="buyMe">buy me</button>
    </div> -->
   
  </div>
@endsection

@section("script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
      cart_id: null,
      cart_addr: null,
			active: "0",
			num: "2",
			tonTap: "1"
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
      addToCart: function () {
				var params = {
					cart_id: this.cart_id,
					product_id: "{{ $product->id }}"
				};
				axios.post("{{ route("wechat.cart.add_product") }}", params)
					.then(function (res) {
						alert(res.data.add);
					});
						},
						buyMe: function () {
				location.assign("{{ route("wechat.product.buyme") }}" +
					"?product_id={{ $product->id }}"
				);
      },
			showBox: function() {
				this.active = "1";
			},
			hideBox: function() {
				this.active = "0";
			},
			goBuy: function() {
				console.log(1)
				location.href = "./order_confirm.html"
			},
			reduceCartNubmer: function() {
				setPrice(this, "reduce");
			},
			addCartNumber: function(a) {
				setPrice(this, "add");
			},
			textCartNumber: function(a) {
				setPrice(this, "blur");
			},
			tontap: function(index) {
				var _this = this;
				this.tonTap = index;
				setTimeout(function() {
					setPrice(_this)
				}, 10)

			}
    }
  });
	function setPrice(_this, mode) { // mode  方式  ： 加 -减   blur  
        var _this = _this;
        var goodsNum = _this.$refs.goodsNum;
        var mode = mode;
        var data = eval('(' + goodsNum.getAttribute("data-arr") + ')');
        var limit = data.limit;
        var price = data.price;
        var weight = data.weight;

        var aNum = Number(goodsNum.value);
        var totalPrice;
        if(mode == "reduce") {
          if(aNum <= 1) {
            return;
          } else {
            aNum = aNum - 1;
          }
        } else if(mode == "add") {
          if(aNum >= limit) {
            alert("购买达到最大数量")
            return;
          } else {
            aNum = aNum + 1;
          }
        } else if(mode == "blur") {
          if(aNum > limit) {
            alert("购买达到最大数量");
            aNum = limit;
          }
        }
        totalPrice = aNum * weight * price;
        goodsNum.value = aNum;
        _this.$refs.productW.innerText = aNum * weight;
        _this.$refs.totalPriceD.innerText = totalPrice;
      }
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
              borderColor: "blue",
              backgroundColor: "blue",
              fill: false,

            }]
          },
          options: {
            responsive: true,
            title: {
              display: true,
              text: '价格变动图'
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
                  display: true,
                  labelString: '价格元/吨'
                }
              }]
            }
          }
        });

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
