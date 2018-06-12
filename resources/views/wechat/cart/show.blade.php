@extends( "layouts.wechat2")

@section( "content")

<div class="container" id="app" v-lock>
  <div class="cart-info">

    <div class="cart-info-header">
      <div class="txt">
        <span>选购单<small>(已添加{{ count($cart->cartItems) }}件商品)</small></span>
      </div>
      <div class="icon">
        <i class="iconfont icon-del"></i>
      </div>
    </div>
    <div class="products" v-for="(pitem,i) in products" v-cloak>
      <div class="product" v-for="(item,index) in pitem">
        <div class="p-check">
          <input type="checkbox" v-bind:id="'check'+i+index" name="goods_checked[]" v-on:change="check(i,index)" v-bind:checked="item.checked">
          <label v-bind:for="'check'+i+index"></label>
        </div>
        <div class="p-info">
          <div class="prop">
            <p class="p-name">
              <span>@{{ item.product.name }} </span>
              <span>@{{ item.product.model }}</span>
            </p>
            <p class="p-bname">
              <span>@{{ item.brand_name }}</span>
              <span>重量<i >@{{  Number(item.product.content)*item.number | tonC }}</i></span>
            </p>
          </div>
         
          <div class="pirce">
            <span>
              <i class="y" v-if="item.product.is_ton">￥@{{ Number(item.price) }}/吨</i>
              <i class="y" v-else>￥@{{ Number(item.price) }}/@{{ item.product.packing_unit }}</i>
            </span>
          </div>
        </div>
        <div class="p-edit">
          <div class="p-del">
            <span class="icons" v-on:click="del(i,index)">
                   <i class="iconfont icon-shanchu"></i>
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

    @if (!count($cart->cartItems))
    <div class="no-content" >
      <span><i class="iconfont icon-dingdan1"></i></span>
      <br>
      <p><a class="gray" href="{{ route("wechat.product.index") }}">您的选购单还没有商品,尽快去 <a href="{{route("wechat.product.index")}}" class="green">选购</a>吧～</a></p>
    </div>
     @endif
  </div>
</div>
<div class="goBuy">
  <div class="check-all">
    <div class="p-check">
      <input type="checkbox" id="ck-all" onchange="checkAllBtn()">
      <label for="ck-all">全选</label>
    </div>
  </div>
  <div class="goods-price">
    <p><span class="fee gray">零售附加：<i  id="fee">0</i></span>
    <span><i class="font-co">¥</i><i class="font-co" id="totalprice" >0</i></span>
  </p>

  </div>
  <div class="btn-submit" onclick="buyAll()">
    <a>结算</a>
  </div>
</div>
@endsection
@section( "script")
<script>
  var totalDom = document.getElementById("totalprice");
  var domAll = document.getElementById("ck-all");
  var domFee = document.getElementById("fee");
  var app = new Vue({
    el: '#app',
    data: {
      products: {!!$products!!},
      cart_id: {{ $cart->id }},
      PayChannel: 1,
      price:0,
    },
    //总价
    beforeMount: function() { //加载页面前计算价格

    },
    filters: {
      tonC: function (value) {
        if (value<1000){
          return value+"kg";
        }else{
          return value/1000+"吨"
        }
      }
    },
    methods: {
      buyAll: function() {
        location.assign("{{ route("wechat.cart.buyall") }}" +
          "?cart_id=" + this.cart_id );
      },
      reduceCartNubmer: function(i, a) {
        var _this = this;
        if (_this.products[i][a].number <= 1) {
          return
        } else {
          _this.products[i][a].number--;
         count(this);
        }
      },
      addCartNumber: function(i, a) {
        this.products[i][a].number++;
        count(this);
      },
      textCartNumber: function(i, a) {
        this.products[i][a].number = Number(this.$refs.xxx[a].value)
        count(this);
      },
      check: function(i, a) {
        if(typeof(this.products[i][a].checked)=="undefined"){
          this.$set(this.products[i][a],"checked",true);
        }else{
          this.products[i][a].checked=!this.products[i][a].checked;
        }
        count(this);
        checkall(this);
      },
      setCheckAll: function(status){
        var products = this.products;
        for(var x in products){
          for (var y in products[x]){
            if(typeof(products[x][y].checked)=="undefined"){
              this.$set(products[x][y],"checked",status);
            }else{
              products[x][y].checked = status;
            }
          }
        }
        count(this);
      },
      del: function(i, a) {
        var _this = this;
        var id = _this.products[i][a].id;
        axios.delete("{{ route("wechat.cart_item.index") }}"+"/"+id)
        .then(function(res){
          if(res.data.destroy){
            _this.products[i].splice(a, 1);
            count(_this)
          }
        })
      }
    }
  })
  function count(_this){
    var _this = _this;
    var products = _this.products;
    var fee = 0, distance = 0, weight = 0,price = 0, func;
    //循环数组获得距离-和公式
    for (var n in products) {
      weight = 0;
      distance = products[n][0].distance;
      func     = JSON.parse(products[n][0].func);
      for (var m in products[n]) {
        if(products[n][m].checked){
          weight += products[n][m].number * Number(products[n][m].product.content);
          price +=  products[n][m].number * Number(products[n][m].price);
        }
      }
      console.log(weight);
      if(weight){
        fee += freight(func, weight, distance);
      }


    }
    //赋值
    totalDom.innerText = price+Math.round(fee/100)*100;
    domFee.innerText = Math.round(fee/100)*100;
  }
  //计算费用
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
  function checkall(_this) {
    var products = _this.products;
    var check = true;
    for(var x in products){
      if(!check){
        break;
      }
      for (var y in products[x]){
        if(!products[x][y].checked){
          check = false;
          break;
        }else{
          check = true;
        }
      }
    }
    if(check){
      domAll.checked = true;
    }else{
      domAll.checked = false;
    }
  }
  function checkAllBtn(){
    var status   = domAll.checked;
    app.setCheckAll(status);
  }
  function buyAll() {
    var param = [];
    var products = app.products;
    for (var k in products) {
      for (var l in products[k]) {
        if (products[k][l].checked) {
          param.push({
            "id": products[k][l].product.id,
            "number": products[k][l].number,
          })
        }
      }
    }
    if (param.length) {
      location.assign("{{ route("wechat.cart.buyall") }}" + "?cart_id=" + app.cart_id + "&&products=" + JSON.stringify(param));
    }
  }
</script>
@endsection
