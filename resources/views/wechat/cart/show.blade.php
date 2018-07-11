@extends( "layouts.wechat2")
@section( "content")
<div class="container cart-info" v-cloak>
    <div class="cart-info-header">
      <div class="txt">
        <span>选购单<small>(已添加{{ count($cart->cartItems) }}件商品)</small></span>
      </div>
      <div class="icon">
        <a href="{{ route("wechat.product.index") }}">继续选购</a>
      </div>
    </div>
    <div class="products" v-for="(pitem,i) in products">
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
              <span>重量:<i >@{{  Number(item.product.content)*item.number | tonC }}</i></span>
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
            <p class="btn-input"><input type="tel" name="" v-bind:max="item.stock"  ref="stock_ipu" v-model="item.number" v-on:blur="textCartNumber(i,index)"   @keyup="checkipu($event)"></p>
            <p class="btn-plus">
              <a class="plus" v-on:click="addCartNumber(i,index)"></a>
            </p>
          </div>
        </div>
      </div>
    </div>

    @if (!$cart->cartItems->count())
    <div class="no-content" >
      <span><i class="iconfont icon-dingdan1"></i></span>
      <br>
      <p><a class="gray" href="{{ route("wechat.product.index") }}">您的选购单还没有商品,尽快去 <a href="{{route("wechat.product.index")}}" class="green">选购</a>吧～</a></p>
    </div>
     @endif
</div>
<div class="goBuy">
  <div class="check-all">
    <div class="p-check">
      <input type="checkbox"  v-bind:checked="domAll">
      <label for="ck-all" @click="checkAllBtn">全选</label>
    </div>
  </div>
  <div class="goods-price">
    <p><span class="fee gray">零售附加：<i  id="fee">@{{ fee }}</i></span>
    <span><i class="font-co">¥</i><i class="font-co" id="totalprice" >@{{ total }}</i></span>
  </p>

  </div>
  <div class="btn-submit" @click="buyAll">
    <a>结算</a>
  </div>
</div>
@endsection
@section( "script")
<script>
  var app = new Vue({
    el: '#app',
    data: {
      products: {!!$products!!},
      cart_id: {{ $cart->id }},
      PayChannel: 1,
      price:0,
      total:0,
      fee:0,
      domAll:false,
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
      buyAll :function() {
        var param = [];
        var products = this.products;
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
          if({{ auth()->user()->is_subscribe }}){
            location.assign("{{ route("wechat.cart.buyall") }}" + "?cart_id=" + this.cart_id + "&&products=" + JSON.stringify(param));
          }else{
            document.querySelector("#subscribe_box").style.display = "block";
          }

        }
      },
      checkall: function(_this) {
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
          this.domAll = true;
        }else{
          this.domAll = false;
        }
      },
      checkAllBtn: function(){
        console.log(this.domAll);
        var status = !this.domAll;
        this.domAll = status;
        this.setCheckAll(status);
      },
      reduceCartNubmer: function(i, a) {
        var _this = this;
        if (_this.products[i][a].number <= 1) {
          return
        } else {
          _this.products[i][a].number--;
          this.addPro(this.products[i][a].product.id,this.products[i][a].number);
         count(this);
        }
      },
      addCartNumber: function(i, a) {
        var dom = this.$refs.stock_ipu[a];
        var max = dom.max;
        if(max>this.products[i][a].number){
          this.products[i][a].number++;
        }
        this.addPro(this.products[i][a].product.id,this.products[i][a].number);
        count(this);
      },
      textCartNumber: function(i, a) {
        var num = Number(this.$refs.stock_ipu[a].value)?Number(this.$refs.stock_ipu[a].value):1;
        var dom = this.$refs.stock_ipu[a];
        var max = dom.max;
        if(max<num){
          num = max;
        }

        this.products[i][a].number = num;
        this.addPro(this.products[i][a].product.id,this.products[i][a].number);
        count(this);
      },
      check: function(i, a) {
        if(typeof(this.products[i][a].checked)=="undefined"){
          this.$set(this.products[i][a],"checked",true);
        }else{
          this.products[i][a].checked=!this.products[i][a].checked;
        }
        count(this);
        this.checkall(this);
      },
      checkipu(event){
        var dom = event.currentTarget
        var num = dom.value;
        num = num.replace(/\D/g, '');
        num = (isNaN(num) ? 1 : num); //只能为数字
        num = num > 0 ? num : 0;
        if(this.tonTap==1){
          this.ton_num = num;
          dom.value = num;
        }else{
          this.num =num;
          this.ton_num = num*this.content/1000;
          dom.value = num;
        }
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
      },
      addPro:function(id,num){
        var params = {
          cart_id: {{ $cart->id }},
          product_id: id,
          num : num
        };
        axios.post("{{ route("wechat.cart.add_product") }}", params)
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
      if(products[n].length){
        distance = products[n][0].distance;
        func     = JSON.parse(products[n][0].func);
        for (var m in products[n]) {
          if(products[n][m].checked){
            weight += products[n][m].number * Number(products[n][m].product.content);
            price +=  products[n][m].number * Number(products[n][m].unit_price);
          }
        }
        if(weight){
          fee += freight(func, weight, distance);
        }
      }
    }
    //赋值
    app.total = price + fee;
    app.fee = fee;
  }
  //计算费用
  function freight(func, weight, distance) {
    var fee = 0;
    func.area.forEach(function(e, index, array) {
      if (e.low <= weight && weight < e.up) {
        fee = Math.round((e.factor * distance * weight + Number(e.const)) / 100) * 100;
        return
      }
    });
    return fee ? fee : Math.round((func.other.factor * distance * weight + Number(func.other.const)) / 100) * 100;
  }


</script>
@endsection
