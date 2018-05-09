@extends("layouts.wechat2")

@section("content")
<div class="cart-info">

      <div class="container" id="app">
        <div class="cart-info-header">
          <div class="txt">
            <span>采购单1<small>(已创建3个采购单)</small></span>
          </div>
          <div class="icon">
            <i class="iconfont icon-del"></i>
          </div>
        </div>
        <div class="products">
          <div class="product" v-for="(item,index) in products">
            <div class="p-check">
              <input type="checkbox" v-bind:id="'check'+index" name="goods_checked[]" v-on:change="check(index)" v-bind:checked="item.checked">
              <label v-bind:for="'check'+index"></label>
            </div>
            <div class="p-info">
              <div class="title">
                <span class="p-bname">@{{ item.product.name }}</span>
                <span class="p-name">@{{ item.product.name }} </span>
                <span class="p-model">@{{ item.product.model }}</span>
              </div>
              <div class="pirce">
                <span><i>￥</i>元/吨</span>
              </div>
            </div>
            <div class="p-edit">
              <div class="p-del">
                <span class="icons" v-on:click="del(index)">
                   <i class="iconfont icon-del"></i>
                </span>
              </div>
              <div class="quantity">
                <p class="btn-minus">
                  <a class="minus" v-on:click="reduceCartNubmer(index)"></a>
                </p>
                <p class="btn-input"><input type="tel" name="" id="cart_num_2578" ref="xxx" v-bind:value="item.number" v-on:blur="textCartNumber(index)"></p>
                <p class="btn-plus">
                  <a class="plus" v-on:click="addCartNumber(index)"></a>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="goBuy">
          <div class="check-all">
            <div class="p-check">
              <input type="checkbox" id="ck-all" v-on:change="checkAll()" v-bind:checked="ckall">
              <label for="ck-all">全选</label>
            </div>
          </div>
          <div class="goods-price">
            <span><i class="font-co">¥</i><i class="font-co" ref="totalprice" >111</i></span>
          </div>
          <div class="btn-submit"><a href="order_confirm.html">结算</a>
            
          </div>
        </div>
      </div>
    </div>
@endsection
@section("script")
  <script>
  new Vue({
        el: '#app',
        data: {
          products: {!! $items !!},
          ckall: false, //全选状态
          totalprice: "0",
        },
        //总价
        beforeMount: function() { //加载页面前计算价格
          this.totalprice = getTotalPrice(this.products);
          console.log(this.totalprice);
          checkall(this);

        },
        methods: {
          reduceCartNubmer: function(a) {
            var _this = this;
            if(_this.products[a].active <= 1) {
              return
            } else {
              // Vue.http.get('./a.json').then(successCallback); //点击减少，发送请求，成功后数量减一
              function successCallback(date) {
                if(date.body.code) {
                  console.log("请求成功")
                  _this.products[a].active--;
                  _this.totalprice = getTotalPrice(_this.products)
                }
              }
              _this.products[a].active--;
                  _this.totalprice = getTotalPrice(_this.products)
            }
          },
          addCartNumber: function(a) {

            this.products[a].active++;
            this.totalprice = getTotalPrice(this.products)
          },
          textCartNumber: function(a) {
            console.log(this.$refs.xxx)
            this.products[a].active = Number(this.$refs.xxx[a].value)
          },
          check: function(a) {
            this.products[a].checked = !this.products[a].checked;
            checkall(this);
            this.totalprice = getTotalPrice(this.products)
          },
          checkAll: function() {
            var status = this.ckall;
            console.log(status)
            for(var k in this.products) {
              this.products[k].checked = !status;
            }
            checkall(this);
            this.totalprice = getTotalPrice(this.products)
          },
          del: function(a) {
            this.products.splice(a, 1);
            this.totalprice = getTotalPrice(this.products)
          }
        }
      })

      function getTotalPrice(arr) {
        var totalPrice = 0;
        for(var i in arr) {
          if(arr[i].checked) {
            totalPrice += arr[i].active * arr[i].price;
          }

        }
        return totalPrice;
      }

      function getDate(name) {
        console.log("ajax获取" + name + "的数据")
      }

      function checkall(_this) {
        var _this = _this;
        var products = _this.products;
        for(var j in products) {
          if(!products[j].checked) {
            _this.ckall = false;
            return;
          } else {
            _this.ckall = true;
          }
        }
      }
  </script>
  @endsection