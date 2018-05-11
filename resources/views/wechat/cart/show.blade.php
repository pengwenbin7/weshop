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
        <div class="products" v-for="(pitem,i) in products">
          <div class="product" v-for="(item,index) in pitem">
            <div class="p-check">
              <input type="checkbox" v-bind:id="'check'+i+index" name="goods_checked[]" v-on:change="check(i,index)" v-bind:checked="item.checked">
              <label v-bind:for="'check'+i+index"></label>
            </div>
            <div class="p-info">
              <div class="title">
                <span class="p-bname">@{{ item.product.name }}</span>
                <span class="p-name">@{{ item.product.name }} </span>
                <span class="p-model">@{{ item.product.model }}</span>
              </div>
              <div class="pirce">
                <span><i>￥@{{ Number(item.price)*Number(item.number)* Number(item.product.content) }}</i>元</span>
              </div>
            </div>
            <div class="p-edit">
              <div class="p-del">
                <span class="icons" v-on:click="del(i,index)">
                   <i class="iconfont icon-del"></i>
                </span>
              </div>
              <div class="quantity">
                <p class="btn-minus">
                  <a class="minus" v-on:click="reduceCartNubmer(i,index)"></a>
                </p>
                <p class="btn-input"><input type="tel" name="" id="cart_num_2578" ref="xxx" v-bind:value="item.number" v-on:blur="textCartNumber(i,index)"></p>
                <p class="btn-plus">
                  <a class="plus" v-on:click="addCartNumber(i,index)"></a>
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
            <span><i class="font-co">¥</i><i class="font-co" ref="totalprice" >@{{ totalprice }}</i></span>
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
          products: {!! $products !!},
          ckall: false, //全选状态
          totalprice: "0",
          distance:1000,
        },
        //总价
        beforeMount: function() { //加载页面前计算价格
        console.log({!! $products !!})
          this.totalprice = getTotalPrice(this);
          checkall(this);

        },
        methods: {
          reduceCartNubmer: function(i,a) {
            var _this = this;
            console.log(_this.products[i][a].number)
            if(_this.products[i][a].number <= 1) {
              return
            } else {
              // Vue.http.get('./a.json').then(successCallback); //点击减少，发送请求，成功后数量减一
              function successCallback(date) {
                if(date.body.code) {
                  console.log("请求成功")
                  _this.products[i][a].number--;
                  _this.totalprice = getTotalPrice(_this)
                }
              }
              _this.products[i][a].number--;
              _this.totalprice = getTotalPrice(_this)
            }
          },
          addCartNumber: function(i,a) {

            this.products[i][a].number++;
            this.totalprice = getTotalPrice(this)
          },
          textCartNumber: function(i,a) {
            console.log(this.$refs.xxx)
            this.products[i][a].number = Number(this.$refs.xxx[a].value)
          },
          check: function(i,a) {
            this.products[i][a].checked = !this.products[i][a].checked;
            checkall(this);
            this.totalprice = getTotalPrice(this)
          },
          checkAll: function() {
            var status = this.ckall;
            console.log(status)
            for(var m in this.products) {
              for(var n in this.products[m] ){
                this.products[m][n].checked = !status;
              }
            }
            checkall(this);
            this.totalprice = getTotalPrice(this)
          },
          del: function(i,a) {
            this.products[i].splice(a, 1);
            this.totalprice = getTotalPrice(this)
          }
        }
      })

      function getTotalPrice(_this) {
        var _this = _this;
        var arr = _this.products;
        var distance = _this.distance;
        resetPrice(_this)
        var totalPrice = 0;
        for(var i in arr) {
          for(var j in arr[i]){
            if(arr[i][j].checked) {
              totalPrice += arr[i][j].number * arr[i][j].product.content * arr[i][j].price;
            }
          }

        }
        return totalPrice;
      }
      function resetPrice(_this){
        var _this = _this;
        var pro =_this.products;
        var distance = _this.distance;
        for(var p in pro){
            var func = JSON.parse(pro[p][0].func);
            // 获取每个数组
            //计算每个数组的价格
            var weight = 0;
            for(var g in pro[p]){
                weight += pro[p][g].number * pro[p][g].product.content;
              
            }
            //计算   费用 = 初始值 + 重量*距离*系数 == 初始值/重量+距离*系数
              pro[p][0].freight = freight(func,weight,distance)/weight;
          }
          for(var x in pro){
            for(var z in pro[x]){
                pro[x][z].price = Number(pro[x][z].unit_price)+Number(pro[x][0].freight);
            }
          }
      }
      function freight(func,weight,distance){
          var freight = 0;
          func.area.forEach(function (e, index, array) {
            if(e.low<=weight&&weight<e.up){
              freight =e.factor * distance + e.const;
              return 
            }
          });
          return freight?freight:func.other.factor * distance + func.other.const;
         
      }
      function getDate(name) {
        console.log("ajax获取" + name + "的数据")
      }

      function checkall(_this) {
        var _this = _this;
        var products = _this.products;
        for(var k in products) {
          for(var l in products[k]){
            if(!products[k][l].checked) {
              _this.ckall = false;
              return;
            } else {
              _this.ckall = true;
            }
          }
          
        }
      }
  </script>
  @endsection